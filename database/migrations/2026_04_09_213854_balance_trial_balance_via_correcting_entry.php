<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix trial balance imbalance by:
     * 1. Re-routing orphaned journal_items (credits pointing to deleted accounts) to Sales Revenue.
     * 2. Adding missing credit lines to individually-imbalanced journal entries.
     */
    public function up(): void
    {
        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            $cid = $company->id;

            // Find Sales Revenue (4110) — target for orphaned/missing credits
            $revenueAccount = DB::table('chart_of_accounts')
                ->where('company_id', $cid)
                ->where('code', '4110')
                ->first()
                ?? DB::table('chart_of_accounts')
                    ->where('company_id', $cid)
                    ->where('category', 'revenue')
                    ->where('type', '!=', 'parent')
                    ->orderBy('code')
                    ->first();

            // Find AR account — target for orphaned/missing debits
            $arAccount = DB::table('chart_of_accounts')
                ->where('company_id', $cid)
                ->whereIn('code', ['1030', '1140'])
                ->orderBy('code')
                ->first()
                ?? DB::table('chart_of_accounts')
                    ->where('company_id', $cid)
                    ->where('type', 'receivable')
                    ->first();

            // ── STEP 1: Fix orphaned journal_items (account_id → deleted account) ──────
            // These items exist in the DB but their account no longer shows in the trial
            // balance, causing the grand totals to diverge.
            $orphaned = DB::table('journal_items as ji')
                ->leftJoin('chart_of_accounts as a', function ($join) use ($cid) {
                    $join->on('ji.account_id', '=', 'a.id')
                         ->where('a.company_id', '=', $cid);
                })
                ->where('ji.company_id', $cid)
                ->whereNull('a.id')          // account_id points to non-existent / wrong-company account
                ->select('ji.*')
                ->get();

            foreach ($orphaned as $item) {
                if ($item->credit > 0 && $revenueAccount) {
                    // Re-route orphaned credit → Sales Revenue
                    DB::table('journal_items')
                        ->where('id', $item->id)
                        ->update(['account_id' => $revenueAccount->id, 'updated_at' => now()]);
                    DB::table('chart_of_accounts')
                        ->where('id', $revenueAccount->id)
                        ->increment('balance', (float) $item->credit);

                } elseif ($item->debit > 0 && $arAccount) {
                    // Re-route orphaned debit → Accounts Receivable
                    DB::table('journal_items')
                        ->where('id', $item->id)
                        ->update(['account_id' => $arAccount->id, 'updated_at' => now()]);
                    DB::table('chart_of_accounts')
                        ->where('id', $arAccount->id)
                        ->increment('balance', (float) $item->debit);
                }
            }

            // ── STEP 2: Fix individually-imbalanced journal entries ─────────────────────
            // Each entry where SUM(debit) ≠ SUM(credit) gets a balancing line added.
            $imbalanced = DB::table('journal_entries as je')
                ->join('journal_items as ji', 'je.id', '=', 'ji.journal_entry_id')
                ->where('je.company_id', $cid)
                ->select('je.id', 'je.reference')
                ->selectRaw('SUM(ji.debit) as total_debit, SUM(ji.credit) as total_credit')
                ->groupBy('je.id', 'je.reference')
                ->havingRaw('ABS(SUM(ji.debit) - SUM(ji.credit)) > 0.001')
                ->get();

            foreach ($imbalanced as $entry) {
                $diff = round((float) $entry->total_debit - (float) $entry->total_credit, 4);

                if ($diff > 0 && $revenueAccount) {
                    // More debits than credits → add missing credit to Sales Revenue
                    DB::table('journal_items')->insert([
                        'company_id'       => $cid,
                        'journal_entry_id' => $entry->id,
                        'account_id'       => $revenueAccount->id,
                        'debit'            => 0,
                        'credit'           => $diff,
                        'description'      => 'Correction: missing revenue credit for ' . $entry->reference,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);
                    DB::table('chart_of_accounts')
                        ->where('id', $revenueAccount->id)
                        ->increment('balance', $diff);

                } elseif ($diff < 0 && $arAccount) {
                    // More credits than debits → add missing debit to AR
                    DB::table('journal_items')->insert([
                        'company_id'       => $cid,
                        'journal_entry_id' => $entry->id,
                        'account_id'       => $arAccount->id,
                        'debit'            => abs($diff),
                        'credit'           => 0,
                        'description'      => 'Correction: missing AR debit for ' . $entry->reference,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);
                    DB::table('chart_of_accounts')
                        ->where('id', $arAccount->id)
                        ->increment('balance', abs($diff));
                }
            }
        }
    }

    public function down(): void
    {
        DB::table('journal_items')
            ->where('description', 'like', 'Correction: missing revenue credit%')
            ->orWhere('description', 'like', 'Correction: missing AR debit%')
            ->delete();
    }
};
