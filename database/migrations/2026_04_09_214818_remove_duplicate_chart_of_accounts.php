<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Remove duplicate accounts from chart_of_accounts.
     * For each group of duplicates (same company_id + code), keep the one with
     * the lowest id. Re-point all journal_items and customer references to the
     * surviving account before deleting the duplicates.
     */
    public function up(): void
    {
        // Find duplicate codes per company — get all IDs grouped by company+code
        $duplicateGroups = DB::table('chart_of_accounts')
            ->select('company_id', 'code')
            ->selectRaw('MIN(id) as keep_id, COUNT(*) as total')
            ->groupBy('company_id', 'code')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicateGroups as $group) {
            $keepId = $group->keep_id;

            // Get all duplicate IDs (everything except the one we're keeping)
            $duplicateIds = DB::table('chart_of_accounts')
                ->where('company_id', $group->company_id)
                ->where('code', $group->code)
                ->where('id', '!=', $keepId)
                ->pluck('id');

            foreach ($duplicateIds as $dupId) {
                // Re-point journal_items referencing the duplicate → kept account
                DB::table('journal_items')
                    ->where('account_id', $dupId)
                    ->update(['account_id' => $keepId]);

                // Re-point customers referencing the duplicate account
                DB::table('customers')
                    ->where('account_id', $dupId)
                    ->update(['account_id' => $keepId]);

                // Delete the duplicate account
                DB::table('chart_of_accounts')->where('id', $dupId)->delete();
            }

            // Recalculate the surviving account's balance from journal_items
            $balanceData = DB::table('journal_items')
                ->where('account_id', $keepId)
                ->selectRaw('SUM(debit) as total_debit, SUM(credit) as total_credit')
                ->first();

            $totalDebit  = (float)($balanceData->total_debit  ?? 0);
            $totalCredit = (float)($balanceData->total_credit ?? 0);

            // Determine normal balance side based on category
            $account = DB::table('chart_of_accounts')->where('id', $keepId)->first();
            if ($account) {
                $debitNormal = in_array($account->category, ['assets', 'expenses']);
                $balance = $debitNormal
                    ? ($totalDebit - $totalCredit)
                    : ($totalCredit - $totalDebit);

                DB::table('chart_of_accounts')
                    ->where('id', $keepId)
                    ->update(['balance' => $balance]);
            }
        }
    }

    public function down(): void
    {
        // Duplicates cannot be safely restored — this migration is irreversible.
    }
};
