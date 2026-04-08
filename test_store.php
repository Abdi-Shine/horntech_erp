<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = new \Illuminate\Http\Request();
$request->merge([
    'name' => 'Test User 2',
    'customer_type' => 'individual',
    'amount_balance' => 0
]);

$controller = new \App\Http\Controllers\CustomerController();
$response = $controller->store($request);
var_dump($response);
echo "Done";
