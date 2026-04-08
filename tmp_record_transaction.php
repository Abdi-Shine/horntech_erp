<?php
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use Illuminate\Support\Facades\DB;

DB::transaction(function () {
    // 1. Create Journal Entry
    $entry = JournalEntry::create([
        'date' => date('Y-m-d'),
        'reference' => 'INV-001',
        'description' => 'Purchase of Asset Inventory',
        'is_posted' => true,
    ]);

    // 2. Debit Inventory (1040)
    $inventory = Account::where('code', '1040')->first();
    JournalItem::create([
        'journal_entry_id' => $entry->id,
        'account_id' => $inventory->id,
        'debit' => 1000.00,
        'credit' => 0.00,
    ]);

    // 3. Credit Cash on Hand (1010)
    $cash = Account::where('code', '1010')->first();
    JournalItem::create([
        'journal_entry_id' => $entry->id,
        'account_id' => $cash->id,
        'debit' => 0.00,
        'credit' => 1000.00,
    ]);

    // 4. Sync Balances
    $controller = new \App\Http\Controllers\AccountController();
    $controller->syncBalances();
});

echo "Transaction COMPLETED: $1,000 Inventory purchased using Cash. Balances updated.\n";
unlink(__FILE__);
