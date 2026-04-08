<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$table = 'chart_of_accounts';

// Check duplicates by name + company_id
$dupesName = DB::table($table)
    ->select('name', 'company_id', DB::raw('COUNT(*) as count'))
    ->groupBy('name', 'company_id')
    ->having('count', '>', 1)
    ->get();

echo "Found " . count($dupesName) . " sets of duplicate account NAMES.\n";

// Check duplicates by code (where code is not null)
$dupesCode = DB::table($table)
    ->whereNotNull('code')
    ->select('code', 'company_id', DB::raw('COUNT(*) as count'))
    ->groupBy('code', 'company_id')
    ->having('count', '>', 1)
    ->get();

echo "Found " . count($dupesCode) . " sets of duplicate account CODES.\n";

// Total records
$total = DB::table($table)->count();
echo "Total records in $table: $total\n";

// Sample data
$sample = DB::table($table)->limit(5)->get(['id', 'code', 'name', 'company_id']);
print_r($sample->toArray());
