<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = \App\Models\SalesOrder::all();
$controller = new \App\Http\Controllers\SalesController();
$ref = new ReflectionMethod($controller, 'createAccountingEntry');
$ref->setAccessible(true);

foreach ($orders as $order) {
    echo "Processing Invoice: " . $order->invoice_no . "\n";
    $oldEntry = \App\Models\JournalEntry::where('reference', $order->invoice_no)->first();
    if ($oldEntry) {
        foreach($oldEntry->items as $item) $item->delete();
        $oldEntry->delete();
        echo "  - Deleted old entry\n";
    }
    $ref->invoke($controller, $order);
    echo "  - Created new accounting entry with Inventory and COGS\n";
}
echo "Done.\n";
