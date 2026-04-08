<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\Auth::loginUsingId(1); // Usually superadmin is 1, maybe admin is 2 or 1. If super admin is 1, they don't have company_id. The user logged in as a tenant admin.
$user = \App\Models\User::whereNotNull('company_id')->first();
if ($user) \Auth::login($user);

try {
    // We can just execute the logic from web.php manually
    $accounts = \App\Models\Account::all();

    $assets = $accounts->where('category', 'assets')->sum('balance');
    $liabilities = $accounts->where('category', 'liabilities')->sum('balance');
    $baseEquity = $accounts->where('category', 'equity')->sum('balance');
    $revenue = $accounts->where('category', 'revenue')->sum('balance');
    $expenses = $accounts->where('category', 'expenses')->sum('balance');
    $netProfit = $revenue - $expenses;
    $cashOnHand = $accounts->where('category', 'assets')
        ->filter(function($account) {
            $name = strtolower($account->name);
            return str_contains($name, 'cash') || str_contains($name, 'bank');
        })->sum('balance');

    $stockValue = \App\Models\ProductStock::with('product')->get()->sum(function($stock) {
        return $stock->quantity * ($stock->product->purchase_price ?? 0);
    });

    $accountsReceivable = \App\Models\SalesOrder::sum('due_amount');

    file_put_contents('test_dashboard.log', "SUCCESS\nStock Value: " . $stockValue . "\n");
} catch (\Exception $e) {
    file_put_contents('test_dashboard.log', "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n");
}
