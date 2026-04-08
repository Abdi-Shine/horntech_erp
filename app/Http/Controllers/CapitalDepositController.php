<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Company;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\Shareholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CapitalDepositController extends Controller
{
    public function index()
    {
        /** @var Company|null $company */
        $company = Company::find(auth()->user()->company_id);
        $companyCurrency = $company->currency ?? '$';
        $shareholders = Shareholder::query()->get();
        $bankAccounts = Account::query()
            ->where(function($q) {
                $q->whereIn('type', ['bank', 'cash'])
                  ->orWhere('code', '3011'); // Share Capital
            })
            ->where('is_active', 1)
            ->get();
        
        // Contributions History
        $history = JournalEntry::query()->where('reference', 'like', 'CAP-%')
            ->with(['items.account'])
            ->orderBy('date', 'desc')
            ->get();
        
        // Stats
        $totalCapital = Shareholder::query()->sum('share_amount');
        $thisYearCapital = JournalEntry::query()->where('reference', 'like', 'CAP-%')
            ->where('status', 'posted')
            ->whereYear('date', date('Y'))
            ->sum('total_amount');
            
        $activeShareholdersCount = $shareholders->count();
        $pendingDeposits = JournalEntry::query()->where('reference', 'like', 'CAP-%')
            ->where('status', 'pending')
            ->sum('total_amount');

        $allAccounts = Account::query()->orderBy('code')->get();

        return view('frontend.setting.capital_deposit', [
            'companyCurrency' => $companyCurrency,
            'shareholders' => $shareholders,
            'bankAccounts' => $bankAccounts,
            'allAccounts' => $allAccounts,
            'history' => $history,
            'totalCapital' => $totalCapital,
            'thisYearCapital' => $thisYearCapital,
            'activeShareholdersCount' => $activeShareholdersCount,
            'pendingDeposits' => $pendingDeposits,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'shareholder_id' => 'required|exists:shareholders,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'credit_account_id' => 'required|exists:chart_of_accounts,id',
            'payment_method' => 'string',
        ]);

        // Auto-detect default bank/cash account for debit
        $bankAccountId = $request->bank_account_id ?? Account::query()->whereIn('type', ['bank', 'cash'])->where('is_active', 1)->first()?->id;
        if (!$bankAccountId) return redirect()->back()->with('error', 'No active bank/cash account found for debit.');

        $depositType = $request->deposit_type ?? 'Share Capital';

        DB::transaction(function () use ($request, $depositType, $bankAccountId) {
            $count = JournalEntry::query()->where('reference', 'like', 'CAP-%')->count() + 1;
            $ref = 'CAP-' . date('Ymd') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
            /** @var Shareholder|null $shareholder */
            $shareholder = Shareholder::query()->find($request->shareholder_id);

            // Create Journal Entry
            $entry = JournalEntry::query()->create([
                'entry_number' => $ref,
                'date' => $request->date,
                'reference' => $ref,
                'description' => 'Capital Deposit (' . $depositType . ') from ' . $shareholder->name . '. ' . $request->notes,
                'status' => 'posted',
                'total_amount' => $request->amount,
                'created_by' => Auth::id() ?? 1,
            ]);

            // Debit Bank (Asset Increases)
            JournalItem::query()->create([
                'journal_entry_id' => $entry->id,
                'account_id' => $bankAccountId,
                'debit' => $request->amount,
                'credit' => 0,
                'description' => 'Capital contribution: ' . $ref
            ]);

            // Credit Equity/Liability (Equity Increases)
            JournalItem::query()->create([
                'journal_entry_id' => $entry->id,
                'account_id' => $request->credit_account_id,
                'debit' => 0,
                'credit' => $request->amount,
                'description' => 'Invested by ' . $shareholder->name . ' (' . $depositType . ')'
            ]);

            // Update Shareholder Balance
            $shareholder->increment('share_amount', $request->amount);
        });

        return redirect()->back()->with('success', 'Capital contribution recorded and ledger posted successfully.');
    }

    /* Shareholder CRUD */
    public function storeShareholder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'share_amount' => 'required|numeric|min:0',
            'credit_account_id' => 'required_if:share_amount,>0|exists:chart_of_accounts,id',
            'payment_method' => 'required_if:share_amount,>0|string',
            'date' => 'required_if:share_amount,>0|date',
            'notes' => 'nullable|string',
        ]);

        /** @var Company|null $company */
        $company = Company::find(auth()->user()->company_id);
        if (!$company) return redirect()->back()->with('error', 'Company not initialized.');

        $bankAccountId = $request->bank_account_id ?? Account::query()->whereIn('type', ['bank', 'cash'])->where('is_active', 1)->first()?->id;

        $depositType = $request->deposit_type ?? 'Share Capital';

        DB::transaction(function () use ($request, $company, $depositType, $bankAccountId) {
            $shareholder = Shareholder::query()->create([
                'company_id' => $company->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'share_amount' => 0, // Will be updated by increment if share_amount > 0
            ]);

            if ($request->share_amount > 0) {
                $count = JournalEntry::query()->where('reference', 'like', 'CAP-%')->count() + 1;
                $ref = 'CAP-' . date('Ymd') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

                // Create Journal Entry
                $entry = JournalEntry::query()->create([
                    'entry_number' => $ref,
                    'date' => $request->date ?? date('Y-m-d'),
                    'reference' => $ref,
                    'description' => 'Initial Capital Deposit (' . $depositType . ') from ' . $shareholder->name . '. ' . ($request->notes ?? ''),
                    'status' => 'posted',
                    'total_amount' => $request->share_amount,
                    'created_by' => Auth::id() ?? 1,
                ]);

                // Debit Bank (Asset Increases)
                JournalItem::query()->create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $bankAccountId,
                    'debit' => $request->share_amount,
                    'credit' => 0,
                    'description' => 'Initial Capital contribution: ' . $ref
                ]);

                // Credit Equity/Liability (Equity Increases)
                JournalItem::query()->create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $request->credit_account_id,
                    'debit' => 0,
                    'credit' => $request->share_amount,
                    'description' => 'Invested by ' . $shareholder->name . ' (' . $depositType . ')'
                ]);

                // Update Shareholder Balance
                $shareholder->increment('share_amount', $request->share_amount);
            }
        });

        return redirect()->back()->with('success', 'Shareholder added successfully.');
    }

    public function updateShareholder(Request $request, $id)
    {
        $shareholder = Shareholder::query()->findOrFail($id);

        $request->validate([
            'name'                 => 'required|string|max:255',
            'phone'                => 'nullable|string|max:50',
            'email'                => 'nullable|email|max:255',
            'address'              => 'nullable|string|max:500',
            'status'               => 'nullable|string|in:active,inactive',
            'ownership_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $shareholder->update($request->only([
            'name', 'phone', 'email', 'address', 'status', 'ownership_percentage',
        ]));

        return redirect()->back()->with('success', 'Shareholder updated successfully.');
    }

    public function destroyShareholder($id)
    {
        $shareholder = Shareholder::query()->findOrFail($id);

        // Block deletion if any capital has ever been recorded for this shareholder.
        // Using share_amount as the authoritative indicator avoids fragile text matching
        // against journal entry descriptions.
        if ($shareholder->share_amount > 0) {
            return redirect()->back()->with('error', 'Cannot delete "' . $shareholder->name . '" — they have capital contributions on record. Set their status to inactive instead.');
        }

        $shareholder->delete();
        return redirect()->back()->with('success', 'Shareholder removed successfully.');
    }

    public function statement($id)
    {
        $shareholder = Shareholder::query()->findOrFail($id);
        $company = Company::find(auth()->user()->company_id);
        $totalCapital = Shareholder::query()->sum('share_amount');
        
        return view('frontend.setting.shareholder_statement_pdf', compact('shareholder', 'company', 'totalCapital'));
    }
}
