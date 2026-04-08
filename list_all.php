<?php
use App\Models\JournalEntry;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$entries = JournalEntry::with('items.account')->get();
foreach ($entries as $e) {
    echo "Entry ID: $e->id | Desc: $e->description\n";
    foreach ($e->items as $i) {
        echo "  - {$i->account->name} ({$i->account->code}): DB {$i->debit} | CR {$i->credit}\n";
    }
}
echo "\nAccount Balances:\n";
foreach (App\Models\Account::all() as $a) {
    if ($a->balance != 0) {
        echo "  {$a->name} ({$a->code}): {$a->balance}\n";
    }
}
