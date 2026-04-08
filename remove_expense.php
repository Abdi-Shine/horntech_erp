<?php
use App\Models\JournalEntry;
use App\Http\Controllers\AccountController;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$entry = JournalEntry::find(10);
if ($entry) {
    echo "Deleting Entry 10: " . $entry->description . "\n";
    $entry->items()->delete();
    $entry->delete();
    echo "Entry deleted.\n";
} else {
    echo "Entry 10 not found.\n";
}

// Sync balances
$controller = new AccountController();
$controller->syncBalances();
echo "Balances synced.\n";

// Show current state
$accounts = App\Models\Account::whereIn('id', [23, 20, 25, 15])->get();
foreach ($accounts as $a) {
    echo "ID: $a->id | Code: $a->code | Name: $a->name | Balance: $a->balance\n";
}
