<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\JournalEntry;
use App\Models\Account;

echo "--- Checking Journal Entries ---\n";
$unbalancedEntries = [];
foreach(JournalEntry::all() as $e) {
    $d = $e->items()->sum('debit');
    $c = $e->items()->sum('credit');
    if(abs($d - $c) > 0.01) {
        $unbalancedEntries[] = "Entry ID {$e->id} ({$e->entry_number}) is unbalanced: Debit $d, Credit $c";
    }
}

if (empty($unbalancedEntries)) {
    echo "All journal entries are balanced.\n";
} else {
    echo implode("\n", $unbalancedEntries) . "\n";
}

echo "\n--- Syncing Account Balances ---\n";
foreach(Account::all() as $account) {
    $debitSum = $account->journalItems()->sum('debit') ?: 0;
    $creditSum = $account->journalItems()->sum('credit') ?: 0;
    if (in_array($account->category, ['assets', 'expenses'])) {
        $account->balance = $debitSum - $creditSum;
    } else {
        $account->balance = $creditSum - $debitSum;
    }
    $account->save();
}
echo "All balances synced with Journal Items.\n";

echo "\n--- Final Global Totals Check ---\n";
$totalDebit = 0;
$totalCredit = 0;
foreach (Account::where('balance', '!=', 0)->get() as $acc) {
    if (in_array($acc->category, ['assets', 'expenses'])) {
        if ($acc->balance >= 0) $totalDebit += $acc->balance;
        else $totalCredit += abs($acc->balance);
    } else {
        if ($acc->balance >= 0) $totalCredit += $acc->balance;
        else $totalDebit += abs($acc->balance);
    }
}
echo "Calculated Total Debit: $totalDebit\n";
echo "Calculated Total Credit: $totalCredit\n";
echo "Difference: " . abs($totalDebit - $totalCredit) . "\n";
if(abs($totalDebit - $totalCredit) < 0.01) {
    echo "SUCCESS: Trial Balance is now in equilibrium.\n";
} else {
    echo "WARNING: Trial Balance is STILL unbalanced. This implies source Journal Entries are intrinsically unbalanced.\n";
}
