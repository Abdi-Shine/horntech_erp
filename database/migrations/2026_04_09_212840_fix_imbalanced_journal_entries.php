<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Find all journal entries where total debits ≠ total credits (imbalanced)
        $imbalanced = DB::table('journal_entries as je')
            ->join('journal_items as ji', 'je.id', '=', 'ji.journal_entry_id')
            ->select('je.id', 'je.company_id', 'je.reference', 'je.date')
            ->selectRaw('SUM(ji.debit) as total_debit, SUM(ji.credit) as total_credit')
            ->groupBy('je.id', 'je.company_id', 'je.reference', 'je.date')
            ->havingRaw('ABS(SUM(ji.debit) - SUM(ji.credit)) > 0.001')
            ->get();

        foreach ($imbalanced as $entry) {
            $difference = round((float)$entry->total_debit - (float)$entry->total_credit, 4);

            if ($difference > 0) {
                // Debits exceed credits — add the missing credit to Sales Revenue (4110)
                $revenueAccount = DB::table('accounts')
                    ->where('company_id', $entry->company_id)
                    ->where('code', '4110')
                    ->first()
                    ?? DB::table('accounts')
                        ->where('company_id', $entry->company_id)
                        ->where('name', 'like', '%Revenue%')
                        ->where('type', '!=', 'parent')
                        ->orderBy('code')
                        ->first()
                    ?? DB::table('accounts')
                        ->where('company_id', $entry->company_id)
                        ->where('category', 'revenue')
                        ->where('type', '!=', 'parent')
                        ->orderBy('code')
                        ->first();

                if ($revenueAccount) {
                    DB::table('journal_items')->insert([
                        'company_id'       => $entry->company_id,
                        'journal_entry_id' => $entry->id,
                        'account_id'       => $revenueAccount->id,
                        'debit'            => 0,
                        'credit'           => $difference,
                        'description'      => 'Correcting entry — missing revenue credit for ' . $entry->reference,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);

                    // Update account balance directly (observer won't fire on DB::table insert)
                    DB::table('accounts')
                        ->where('id', $revenueAccount->id)
                        ->increment('balance', $difference);

                    DB::table('journal_entries')
                        ->where('id', $entry->id)
                        ->update(['updated_at' => now()]);
                }

            } elseif ($difference < 0) {
                // Credits exceed debits — add the missing debit to Accounts Receivable (1140)
                $arAccount = DB::table('accounts')
                    ->where('company_id', $entry->company_id)
                    ->where('code', '1140')
                    ->first()
                    ?? DB::table('accounts')
                        ->where('company_id', $entry->company_id)
                        ->where('name', 'like', '%Receivable%')
                        ->first();

                if ($arAccount) {
                    DB::table('journal_items')->insert([
                        'company_id'       => $entry->company_id,
                        'journal_entry_id' => $entry->id,
                        'account_id'       => $arAccount->id,
                        'debit'            => abs($difference),
                        'credit'           => 0,
                        'description'      => 'Correcting entry — missing receivable debit for ' . $entry->reference,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);

                    DB::table('accounts')
                        ->where('id', $arAccount->id)
                        ->increment('balance', abs($difference));

                    DB::table('journal_entries')
                        ->where('id', $entry->id)
                        ->update(['updated_at' => now()]);
                }
            }
        }
    }

    public function down(): void
    {
        // Remove correcting entries added by this migration
        DB::table('journal_items')
            ->where('description', 'like', 'Correcting entry — missing revenue credit%')
            ->orWhere('description', 'like', 'Correcting entry — missing receivable debit%')
            ->delete();
    }
};
