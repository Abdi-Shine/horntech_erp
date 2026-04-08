<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$s = App\Models\ProductStock::find(9);
echo "Store ID value: ";
var_dump($s->store_id);

$bill = App\Models\PurchaseBill::find(6);
echo "Bill Store ID value: ";
var_dump($bill->store_id);

$stock = App\Models\ProductStock::where([
    'product_id' => 7,
    'branch_id' => 4,
    'store_id' => $bill->store_id,
])->first();

if ($stock) {
    echo "Stock record FOUND (ID: " . $stock->id . ")\n";
} else {
    echo "Stock record NOT FOUND\n";
}
