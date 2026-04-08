<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Account;

$table = 'chart_of_accounts';

// 1. Identify duplicates based on NAME and company_id
$dupesName = DB::table($table)
    ->select('name', 'company_id', DB::raw('COUNT(*) as count'))
    ->groupBy('name', 'company_id')
    ->having('count', '>', 1)
    ->get();

echo "Found " . count($dupesName) . " sets of duplicate account NAMES.\n";

foreach ($dupesName as $dupe) {
    if (empty($dupe->name)) continue;

    $accounts = DB::table($table)
        ->where('name', $dupe->name)
        ->where('company_id', $dupe->company_id)
        ->orderBy('id', 'asc')
        ->get();
    
    $main = $accounts->shift(); // Keep lowest ID
    $mainId = $main->id;
    
    echo "Processing name [{$dupe->name}]: Keeping ID {$mainId}, removing others.\n";

    foreach ($accounts as $dup) {
        remapAndDelete($dup->id, $mainId, $table);
    }
}

// 2. Identify duplicates based on CODE and company_id
$dupesCode = DB::table($table)
    ->whereNotNull('code')
    ->select('code', 'company_id', DB::raw('COUNT(*) as count'))
    ->groupBy('code', 'company_id')
    ->having('count', '>', 1)
    ->get();

echo "Found " . count($dupesCode) . " sets of duplicate account CODES.\n";

foreach ($dupesCode as $dupe) {
    $accounts = DB::table($table)
        ->where('code', $dupe->code)
        ->where('company_id', $dupe->company_id)
        ->orderBy('id', 'asc')
        ->get();
    
    if ($accounts->isEmpty()) continue;
    $main = $accounts->shift();
    $mainId = $main->id;
    
    echo "Processing code [{$dupe->code}]: Keeping ID {$mainId}, removing others.\n";

    foreach ($accounts as $dup) {
        remapAndDelete($dup->id, $mainId, $table);
    }
}

function remapAndDelete($dupId, $mainId, $table) {
    echo " - Remapping references from ID {$dupId} to {$mainId}...\n";

    $remaps = [
        ['journal_items', 'account_id'],
        ['supplier_payments', 'bank_account_id'],
        ['payment_ins', 'bank_account_id'],
        ['companies', 'default_bank_account'],
        ['companies', 'default_inventory_account_id'],
        ['companies', 'default_sales_income_account_id'],
        ['companies', 'default_cogs_account_id'],
    ];

    foreach ($remaps as $map) {
        $t = $map[0];
        $c = $map[1];
        if (Illuminate\Support\Facades\Schema::hasTable($t) && Illuminate\Support\Facades\Schema::hasColumn($t, $c)) {
            DB::table($t)->where($c, $dupId)->update([$c => $mainId]);
        }
    }

    DB::table($table)->where('id', $dupId)->delete();
}

echo "Cleanup complete.\n";
