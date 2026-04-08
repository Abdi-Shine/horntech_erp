<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$table = 'chart_of_accounts';

$mappings = [
    '1030' => ['name' => 'Inventory', 'type' => 'inventory'],
    '4000' => ['name' => 'Sales Revenue', 'type' => 'revenue'],
    '5000' => ['name' => 'Cost of Goods Sold', 'type' => 'expense'], // or cogs
];

foreach ($mappings as $code => $data) {
    echo "Processing code [{$code}]...\n";
    
    // Find all accounts with this code
    $accounts = DB::table($table)->where('code', $code)->orderBy('id', 'asc')->get();
    
    if ($accounts->isEmpty()) {
        // Create it if missing
        DB::table($table)->insert([
            'code' => $code,
            'name' => $data['name'],
            'type' => $data['type'],
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo " - Created missing account: {$data['name']}\n";
        continue;
    }

    // Identify the best match (the one that ALREADY has the right name)
    $bestMatch = null;
    foreach ($accounts as $acc) {
        if ($acc->name === $data['name']) {
            $bestMatch = $acc;
            break;
        }
    }

    if (!$bestMatch) {
        // Just take the first one and rename it
        $bestMatch = $accounts[0];
        DB::table($table)->where('id', $bestMatch->id)->update([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);
        echo " - Renamed ID {$bestMatch->id} to {$data['name']}\n";
    }

    $keepId = $bestMatch->id;
    echo " - Keeping ID {$keepId} for code {$code}.\n";

    // Delete all OTHERS with the same code (remapping first)
    foreach ($accounts as $acc) {
        if ($acc->id == $keepId) continue;
        
        $dupId = $acc->id;
        echo " - Removing ID {$dupId} (Name: {$acc->name}) and remapping to {$keepId}...\n";

        $remaps = [
            ['journal_items', 'account_id'],
            ['supplier_payments', 'bank_account_id'],
            ['payment_ins', 'bank_account_id'],
        ];

        foreach ($remaps as $map) {
            $t = $map[0]; $c = $map[1];
            if (Illuminate\Support\Facades\Schema::hasTable($t) && Illuminate\Support\Facades\Schema::hasColumn($t, $c)) {
                DB::table($t)->where($c, $dupId)->update([$c => $keepId]);
            }
        }
        
        DB::table($table)->where('id', $dupId)->delete();
    }
}

// Also fix standard Asset/Liability/Equity parent codes if they are messy
$parents = [
    '1' => 'Assets',
    '2' => 'Liabilities',
    '3' => 'Equity',
    '4' => 'Revenue',
    '5' => 'Expenses'
];

foreach ($parents as $code => $name) {
     DB::table($table)->where('code', $code)->update(['name' => $name, 'type' => 'parent']);
}

echo "Chart of Accounts updated successfully.\n";
