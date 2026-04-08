<?php

use App\Models\SalesOrder;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\Account;
use App\Http\Controllers\SalesController;

echo "Starting Sync for Company 2...\n";

$orders = SalesOrder::where('company_id', 2)->get();
$controller = new SalesController();

foreach ($orders as $order) {
    echo "Processing Invoice: {$order->invoice_no} (ID: {$order->id})\n";
    
    // 1. Delete old journal entry for this invoice
    $oldEntry = JournalEntry::where('reference', $order->invoice_no)->first();
    if ($oldEntry) {
        echo " - Found existing ledger entry. Deleting and reversing balances...\n";
        foreach ($oldEntry->items as $item) {
            $account = Account::find($item->account_id);
            if ($account) {
                if ($item->debit > 0) $account->decrement('balance', $item->debit);
                if ($item->credit > 0) $account->decrement('balance', $item->credit);
            }
            $item->delete();
        }
        $oldEntry->delete();
    }
    
    // 2. Re-create accounting entry
    try {
        $controller->createAccountingEntry($order);
        echo " - Ledger re-created successfully.\n";
    } catch (\Exception $e) {
        echo " - ERROR: " . $e->getMessage() . "\n";
    }
}

echo "Sync completed. Please check your Profit & Loss report now.\n";
