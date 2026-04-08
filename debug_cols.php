<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$columns = Illuminate\Support\Facades\Schema::getColumnListing('products');
file_put_contents('debug_cols.txt', implode("\n", $columns));
