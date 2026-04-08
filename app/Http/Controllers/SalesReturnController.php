<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\SalesOrder;
use App\Models\SalesReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesReturnController extends Controller
{
    public function viewSalesReturn(Request $request)
    {
        $query = SalesReturn::query()->with('customer', 'invoice')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('credit_note_no', 'like', '%' . $request->search . '%')
                  ->orWhereHas('customer', fn($s) => $s->where('name', 'like', '%' . $request->search . '%'));
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $returns   = $query->paginate(10)->withQueryString();
        $customers = Customer::query()->orderBy('name')->get();
        $invoices  = SalesOrder::query()->whereIn('status', ['completed', 'partial'])->latest()->get();

        $stats = [
            'total_returns'  => SalesReturn::query()->whereMonth('return_date', now()->month)->count(),
            'return_value'   => SalesReturn::query()->whereMonth('return_date', now()->month)->sum('amount'),
            'credit_notes'   => SalesReturn::query()->where('status', 'approved')->count(),
            'pending'        => SalesReturn::query()->where('status', 'pending')->count(),
        ];

        return view('frontend.sales.sales_return_credit_note', compact('returns', 'customers', 'invoices', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'  => 'required|exists:customers,id',
            'invoice_id'   => 'nullable|exists:sales_orders,id',
            'reason'       => 'required|string|max:255',
            'return_date'  => 'required|date',
            'amount'       => 'required|numeric|min:0.01',
            'notes'        => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $companyId = auth()->user()->company_id;

            $count = SalesReturn::query()->count() + 1;
            $creditNoteNo = 'CN-' . date('Y') . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);

            $return = SalesReturn::query()->create([
                'company_id'     => $companyId,
                'credit_note_no' => $creditNoteNo,
                'customer_id'    => $request->customer_id,
                'invoice_id'     => $request->invoice_id ?: null,
                'reason'         => $request->reason,
                'return_date'    => $request->return_date,
                'amount'         => $request->amount,
                'notes'          => $request->notes,
                'status'         => 'approved',
                'created_by'     => Auth::id(),
            ]);

            // Increase customer balance (they are owed this amount)
            $customer = Customer::query()->find($request->customer_id);
            if ($customer) {
                $customer->amount_balance = ($customer->amount_balance ?? 0) - $request->amount;
                $customer->save();
            }

            // Journal Entry: Dr Sales Revenue / Cr Accounts Receivable
            $this->createReturnJournalEntry($return, $companyId);
        });

        return redirect()->back()->with('success', 'Credit note issued successfully.');
    }

    public function destroy($id)
    {
        $return = SalesReturn::query()->findOrFail($id);

        DB::transaction(function () use ($return) {
            // Reverse customer balance
            $customer = Customer::query()->find($return->customer_id);
            if ($customer) {
                $customer->amount_balance = ($customer->amount_balance ?? 0) + $return->amount;
                $customer->save();
            }

            // Reverse journal entry
            $entry = JournalEntry::query()->where('reference', $return->credit_note_no)->first();
            if ($entry) {
                foreach ($entry->items as $item) {
                    $item->delete();
                }
                $entry->delete();
            }

            $return->delete();
        });

        return redirect()->back()->with('success', 'Credit note reversed and deleted.');
    }

    private function createReturnJournalEntry(SalesReturn $return, $companyId)
    {
        // Dr Sales Revenue (reverses earned revenue)
        $revenueAccount = Account::query()->where('company_id', $companyId)->where('code', '4110')->first()
                       ?: Account::query()->where('company_id', $companyId)->where('name', 'like', '%Revenue%')->first();

        // Cr Accounts Receivable (reduces what customer owes — or creates a credit balance)
        $receivableAccount = Account::query()->where('company_id', $companyId)->where('code', '1140')->first()
                          ?: Account::query()->where('company_id', $companyId)->where('name', 'like', '%Receivable%')->first();

        if (!$revenueAccount || !$receivableAccount) {
            return;
        }

        $entry = JournalEntry::query()->create([
            'company_id'   => $companyId,
            'entry_number' => 'JE-CN-' . $return->id . '-' . strtoupper(substr(uniqid(), -5)),
            'date'         => $return->return_date,
            'reference'    => $return->credit_note_no,
            'description'  => 'Sales return / credit note for ' . ($return->customer->name ?? ''),
            'status'       => 'posted',
            'total_amount' => $return->amount,
            'created_by'   => Auth::id(),
        ]);

        // Dr Revenue (reduces revenue)
        JournalItem::query()->create([
            'company_id'       => $companyId,
            'journal_entry_id' => $entry->id,
            'account_id'       => $revenueAccount->id,
            'debit'            => $return->amount,
            'credit'           => 0,
            'description'      => 'Return: ' . $return->credit_note_no,
        ]);

        // Cr Receivable (reduces AR balance)
        JournalItem::query()->create([
            'company_id'       => $companyId,
            'journal_entry_id' => $entry->id,
            'account_id'       => $receivableAccount->id,
            'debit'            => 0,
            'credit'           => $return->amount,
            'description'      => 'Return: ' . $return->credit_note_no,
        ]);
    }
}
