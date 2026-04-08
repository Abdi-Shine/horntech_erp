<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\Auth::loginUsingId(1);
$request = new \Illuminate\Http\Request();
$controller = app()->make(\App\Http\Controllers\ReportController::class);

try {
    $res = $controller->profitLossReport($request);
    file_put_contents('test.log', "SUCCESS\nRENDERED length: " . strlen($res->render()) . "\n");
} catch (\Exception $e) {
    file_put_contents('test.log', "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n");
}
