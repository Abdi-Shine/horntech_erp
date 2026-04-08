<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$accounts = \App\Models\Account::all(['id', 'name', 'code', 'category', 'type'])->toArray();
echo json_encode($accounts, JSON_PRETTY_PRINT);
