<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$order = \App\Models\SalesOrder::latest()->first();
if ($order) {
    echo "Sales Order: " . $order->invoice_no . "\n";
    $entry = \App\Models\JournalEntry::where('reference', $order->invoice_no)->first();
    if ($entry) {
        echo "Journal Entry: " . $entry->entry_number . "\n";
        foreach ($entry->items as $item) {
            $acc = \App\Models\Account::find($item->account_id);
            echo "  - Account: " . ($acc->name ?? 'Unknown') . " (Code: " . ($acc->code ?? 'N/A') . "), DR: " . $item->debit . ", CR: " . $item->credit . "\n";
        }
    } else {
        echo "No Journal Entry found for reference " . $order->invoice_no . "\n";
    }
} else {
    echo "No Sales Order found.\n";
}
