<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$accounts = App\Models\Account::get(['id', 'code', 'name', 'category', 'type', 'is_active', 'branch_id']);
file_put_contents('accounts_full.json', $accounts->toJson(JSON_PRETTY_PRINT));
