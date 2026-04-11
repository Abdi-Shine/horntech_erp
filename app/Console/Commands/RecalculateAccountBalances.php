<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;
use App\Models\JournalItem;
use Illuminate\Support\Facades\DB;

class RecalculateAccountBalances extends Command
{
    protected $signature   = 'accounts:recalculate {company_id? : Only recalculate for this company}';
    protected $description = 'Recalculate all account balances from posted journal entries';

    public function handle()
    {
        $companyId = $this->argument('company_id');

        $query = Account::withoutGlobalScopes()->where('type', '!=', 'parent');
        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $accounts = $query->get();
        $bar = $this->output->createProgressBar($accounts->count());
        $bar->start();

        DB::transaction(function () use ($accounts, $bar) {
            foreach ($accounts as $account) {
                $items = JournalItem::withoutGlobalScopes()
                    ->where('account_id', $account->id)
                    ->join('journal_entries', 'journal_items.journal_entry_id', '=', 'journal_entries.id')
                    ->where('journal_entries.status', 'posted')
                    ->select('journal_items.debit', 'journal_items.credit')
                    ->get();

                $totalDebit  = $items->sum('debit');
                $totalCredit = $items->sum('credit');

                $normalDebit = in_array($account->category, ['assets', 'expenses']);
                $balance     = $normalDebit ? ($totalDebit - $totalCredit) : ($totalCredit - $totalDebit);

                Account::withoutGlobalScopes()
                    ->where('id', $account->id)
                    ->update(['balance' => $balance]);

                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info('Account balances recalculated successfully.');
    }
}
