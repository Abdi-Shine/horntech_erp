<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\PurchaseBill;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AskAiController extends Controller
{
    public function index()
    {
        return view('frontend.ask_ai');
    }

    public function ask(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $apiKey = config('services.anthropic.key');
        if (!$apiKey) {
            return response()->json(['error' => 'AI service is not configured. Please add your ANTHROPIC_API_KEY.'], 503);
        }

        $cid     = auth()->user()->company_id;
        $company = \App\Models\Company::withoutGlobalScopes()->find($cid);
        $context = $this->buildContext($cid, $company);

        $systemPrompt = <<<PROMPT
You are a helpful business assistant for {$company->name}. You answer questions about the company's sales, purchases, expenses, inventory, and financial data.

Always reply in the SAME LANGUAGE the user writes in. If they write in Somali, reply fully in Somali. If they write in English, reply in English.

Here is the current business data snapshot (today: {$this->today()}):

{$context}

Guidelines:
- Be concise and direct
- Format numbers with commas and 2 decimal places
- Use the company's currency symbol: {$this->currency($company)}
- If data is not available for a query, say so clearly
- For Somali replies, use clear and natural Somali language
PROMPT;

        $response = Http::withHeaders([
            'x-api-key'         => $apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->timeout(30)->post('https://api.anthropic.com/v1/messages', [
            'model'      => 'claude-haiku-4-5-20251001',
            'max_tokens' => 1024,
            'system'     => $systemPrompt,
            'messages'   => [
                ['role' => 'user', 'content' => $request->message],
            ],
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'AI service error. Please try again.'], 500);
        }

        $text = $response->json('content.0.text') ?? 'No response received.';

        return response()->json(['reply' => $text]);
    }

    private function buildContext(int $cid, $company): string
    {
        $now   = now();
        $month = $now->month;
        $year  = $now->year;

        // Sales this month
        $salesThisMonth = SalesOrder::withoutGlobalScopes()
            ->where('company_id', $cid)
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $salesThisYear = SalesOrder::withoutGlobalScopes()
            ->where('company_id', $cid)
            ->whereYear('created_at', $year)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $salesOrdersCount = SalesOrder::withoutGlobalScopes()
            ->where('company_id', $cid)
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->count();

        // Purchases this month
        $purchasesThisMonth = PurchaseBill::withoutGlobalScopes()
            ->where('company_id', $cid)
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->sum('total_amount');

        $purchasesThisYear = PurchaseBill::withoutGlobalScopes()
            ->where('company_id', $cid)
            ->whereYear('created_at', $year)
            ->sum('total_amount');

        // Expenses this month
        $expensesThisMonth = Expense::withoutGlobalScopes()
            ->where('company_id', $cid)
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->sum('amount');

        $expensesThisYear = Expense::withoutGlobalScopes()
            ->where('company_id', $cid)
            ->whereYear('created_at', $year)
            ->sum('amount');

        // Inventory
        $totalProducts = Product::withoutGlobalScopes()
            ->where('company_id', $cid)->count();

        $lowStockCount = Product::withoutGlobalScopes()
            ->where('company_id', $cid)
            ->whereNotNull('low_stock_threshold')
            ->where('low_stock_threshold', '>', 0)
            ->get()
            ->filter(function ($p) {
                $stock = ProductStock::withoutGlobalScopes()
                    ->where('product_id', $p->id)->sum('quantity');
                return $stock < $p->low_stock_threshold;
            })->count();

        // Top 5 products by sales this month
        $topProducts = DB::table('sales_order_items as soi')
            ->join('sales_orders as so', 'so.id', '=', 'soi.sales_order_id')
            ->join('products as p', 'p.id', '=', 'soi.product_id')
            ->where('so.company_id', $cid)
            ->whereMonth('so.created_at', $month)->whereYear('so.created_at', $year)
            ->where('so.status', '!=', 'cancelled')
            ->select('p.name', DB::raw('SUM(soi.quantity) as qty_sold'), DB::raw('SUM(soi.total_price) as revenue'))
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $topList = $topProducts->map(fn($r) => "  - {$r->name}: qty={$r->qty_sold}, revenue=" . number_format($r->revenue, 2))->join("\n");

        // Gross profit estimate
        $grossProfit = $salesThisMonth - $purchasesThisMonth - $expensesThisMonth;
        $grossProfitYear = $salesThisYear - $purchasesThisYear - $expensesThisYear;

        $sym = $this->currency($company);

        return <<<DATA
Company: {$company->name}
Currency: {$sym}
Current Month: {$now->format('F Y')}

=== THIS MONTH ===
Sales Total: {$sym} {$salesThisMonth} ({$salesOrdersCount} orders)
Purchases Total: {$sym} {$purchasesThisMonth}
Expenses Total: {$sym} {$expensesThisMonth}
Estimated Net Profit: {$sym} {$grossProfit}

=== THIS YEAR ({$year}) ===
Sales Total: {$sym} {$salesThisYear}
Purchases Total: {$sym} {$purchasesThisYear}
Expenses Total: {$sym} {$expensesThisYear}
Estimated Net Profit: {$sym} {$grossProfitYear}

=== INVENTORY ===
Total Products: {$totalProducts}
Low Stock Products: {$lowStockCount}

=== TOP SELLING PRODUCTS THIS MONTH ===
{$topList}
DATA;
    }

    private function today(): string
    {
        return now()->format('Y-m-d');
    }

    private function currency($company): string
    {
        $map = ['USD' => '$', 'SAR' => 'SAR', 'EUR' => '€', 'GBP' => '£', 'KES' => 'KES', 'SOS' => 'SOS'];
        $c = $company->currency ?? '$';
        return $map[$c] ?? $c;
    }
}
