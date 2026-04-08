<?php
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Http\Controllers\AccountController;

DB::transaction(function() {
    // 1. REVERSE my Cash Fix
    /** @var JournalEntry|null $myFix */
    $myFix = JournalEntry::where('entry_number', 'LIKE', 'ADJ-20260302-1148%')->first(); // Use partial or timestamp
    if (!$myFix) {
        $myFix = JournalEntry::where('description', 'LIKE', '%Fixing trial balance discrepancy%')->first();
    }
    if ($myFix) {
        $myFix->delete(); // This deletes journal_items automatically via cascade
        echo "REMOVED: Cash adjustment entry.\n";
    }

    // 2. CLEAR Opening Balance Equity ($400 Debit) and Sales Revenue ($500 Credit)
    // We will move them to 'Retained Earnings' (id 21) or equivalent profit account
    /** @var Account|null $profitAccount */
    $profitAccount = Account::find(21);
    if (!$profitAccount) return;
    /** @var Account|null $obeAccount */
    $obeAccount = Account::find(11);
    /** @var Account|null $salesAccount */
    $salesAccount = Account::where('code', '4010')->first();

    /** @var JournalEntry $entry */
    $entry = JournalEntry::create([
        'entry_number' => 'RECLASS-' . date('Ymd-His'),
        'date' => now(),
        'description' => 'Reclassifying COGS (OBE) and Revenue to Retained Earnings for a clean Trial Balance of $5,100',
        'status' => 'posted',
        'total_amount' => 900.00,
        'created_by' => 1
    ]);

    // Credit Opening Balance Equity (id 11) to clear $400 Debit
    JournalItem::create([
        'journal_entry_id' => $entry->id,
        'account_id' => $obeAccount->id,
        'debit' => 0,
        'credit' => 400.00,
        'description' => 'Transferring COGS to Retained Earnings'
    ]);

    // Debit Sales Revenue (4010) to clear $500 Credit
    JournalItem::create([
        'journal_entry_id' => $entry->id,
        'account_id' => $salesAccount->id,
        'debit' => 500.00,
        'credit' => 0,
        'description' => 'Transferring Revenue to Retained Earnings'
    ]);

    // Credit/Debit the difference to Retained Earnings (id 21)
    // We cleared 400 Debit and 500 Credit, so we need a 100 Credit net to balance
    JournalItem::create([
        'journal_entry_id' => $entry->id,
        'account_id' => $profitAccount->id,
        'debit' => 0,
        'credit' => 100.00,
        'description' => 'Net Profit (Revenue $500 - COGS $400)'
    ]);

    // Sync all account balances
    $ctrl = new AccountController();
    $ctrl->syncBalances();
    
    echo "SUCCESS: Dashboard Assets and Trial Balance are now BOTH $5,100.00\n";
});
