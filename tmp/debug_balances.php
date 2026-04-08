<?php
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalItem;

$logFile = 'd:\\Bilkheyr\\tmp\\audit_log.txt';
$log = "";

$log .= "Opening Balance Equity (id=11) Items:\n";
$obeItems = JournalItem::where('account_id', 11)->get();
foreach ($obeItems as $item) {
    if (!$item->entry) continue;
    $log .= "  [Entry: {$item->entry->entry_number}] Debit: {$item->debit}, Credit: {$item->credit} ({$item->description})\n";
}

$log .= "\nAccounts balances overview:\n";
$accounts = Account::orderBy('code')->get();
foreach ($accounts as $a) {
    if ($a->balance != 0) {
        $log .= "  {$a->code} | {$a->name} | {$a->category} | Bal: {$a->balance}\n";
    }
}

file_put_contents($logFile, $log);
echo "SUCCESS: Log saved to " . $logFile . "\n";
