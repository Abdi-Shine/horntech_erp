<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$accounts = App\Models\Account::get(['id', 'code', 'name']);
foreach($accounts as $acc) {
    echo $acc->id . " | " . $acc->code . " | " . $acc->name . "\n";
}
