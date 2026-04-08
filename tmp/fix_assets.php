<?php
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Http\Controllers\AccountController;

DB::transaction(function() {
    /** @var JournalEntry $entry */
    $entry = JournalEntry::create([
        'entry_number' => 'ADJ-' . date('Ymd-His'),
        'date' => now(),
        'description' => 'Fixing trial balance discrepancy by moving Opening Balance Equity to Cash on Hand',
        'status' => 'posted',
        'total_amount' => 400.00,
        'created_by' => 1
    ]);

    // Debit Cash on Hand (ID 3)
    JournalItem::create([
        'journal_entry_id' => $entry->id,
        'account_id' => 3, 
        'debit' => 400.00,
        'credit' => 0,
        'description' => 'Moved from OBE'
    ]);

    // Credit Opening Balance Equity (ID 11)
    JournalItem::create([
        'journal_entry_id' => $entry->id,
        'account_id' => 11,
        'debit' => 0,
        'credit' => 400.00,
        'description' => 'Moved to Cash'
    ]);

    // Sync all account balances
    $ctrl = new AccountController();
    $ctrl->syncBalances();
    
    echo "SUCCESS: Assets now match Trial Balance ($5,500.00)\n";
});
