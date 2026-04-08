<?php
use App\Models\Account;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach ([23, 20, 25, 15] as $id) {
    $a = Account::find($id);
    if ($a) {
        echo "ID: $id | Code: " . $a->code . " | Name: " . $a->name . " | Balance: " . $a->balance . "\n";
    } else {
        echo "ID: $id NOT FOUND\n";
    }
}
