<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$tables = ['vendors', 'suppliers', 'supplier'];
foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        echo "Table: $table exists. Count: " . DB::table($table)->count() . PHP_EOL;
        echo "Columns: " . implode(', ', Schema::getColumnListing($table)) . PHP_EOL;
    } else {
        echo "Table: $table does not exist." . PHP_EOL;
    }
}
