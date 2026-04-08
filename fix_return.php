<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\ProductStock;
use App\Models\StockMovement;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
try {
    $return = PurchaseReturn::find(1);
    if (!$return) throw new \Exception("Return 1 not found");

    echo "Found Return PR-2026-00001 with amount " . $return->total_amount . "\n";

    // 1. Create Stock Movement and Decrease Stock
    foreach ($return->items as $item) {
        $stock = ProductStock::where([
            'product_id' => $item->product_id,
            'branch_id' => $return->branch_id,
            'store_id' => $return->store_id,
        ])->first();

        if ($stock) {
            echo "Processing item: " . $item->product_id . ", quantity: " . $item->quantity . "\n";
            echo "Old Stock: " . $stock->quantity . "\n";
            $stock->decrement('quantity', $item->quantity);
            echo "New Stock: " . $stock->quantity . "\n";

            StockMovement::create([
                'product_id' => $item->product_id,
                'branch_id' => $return->branch_id,
                'store_id' => $return->store_id,
                'quantity' => -$item->quantity,
                'type' => 'purchase_return',
                'reference_id' => $item->id,
                'reference_type' => PurchaseReturnItem::class,
                'balance_after' => $stock->quantity,
                'created_by' => $return->created_by,
                'created_at' => $return->created_at,
            ]);
        }
    }

    // 2. Create Journal Entry
    $entry = JournalEntry::create([
        'date' => $return->return_date,
        'reference' => $return->return_number,
        'description' => "Purchase Return (Manual Fix for consistency)",
        'branch_id' => $return->branch_id,
        'created_by' => $return->created_by,
        'created_at' => $return->created_at,
        'entry_number' => 'JE-FIX-' . $return->return_number,
        'total_amount' => $return->total_amount,
        'status' => 'posted',
    ]);

    $supplier = $return->supplier;
    if ($supplier && $supplier->account_id) {
        JournalItem::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $supplier->account_id,
            'debit' => $return->total_amount,
            'credit' => 0,
            'description' => 'Liability reduction for ' . $return->return_number
        ]);
    }

    JournalItem::create([
        'journal_entry_id' => $entry->id,
        'account_id' => 6, // Inventory Asset
        'debit' => 0,
        'credit' => $return->total_amount,
        'description' => 'Inventory reduction for ' . $return->return_number
    ]);

    DB::commit();
    echo "Fix applied successfully.\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
