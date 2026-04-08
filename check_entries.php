<?php
use App\Models\JournalEntry;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$entries = JournalEntry::whereIn('id', [7, 9, 10])->get();
foreach ($entries as $e) {
    echo "ID: $e->id | Desc: $e->description | Total: $e->total_amount | Status: $e->status\n";
    foreach ($e->items as $i) {
        echo "  Acc: {$i->account->name} ({$i->account->code}) | DB: $i->debit | CR: $i->credit\n";
    }
}
