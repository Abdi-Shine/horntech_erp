<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Backfill missing COGS (debit) and Inventory (credit) journal items for
 * sales orders that already have a journal entry but were recorded before
 * the correct chart-of-accounts codes (5110 / 1150) existed.
 *
 * Safe to re-run: it only inserts where no COGS item exists yet.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Gather every company that has sales journal entries
        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            $companyId = $company->id;

            // Resolve COGS account: prefer 5110, fall back to 5100, then name match
            $cogsAccount = DB::table('chart_of_accounts')
                ->where('company_id', $companyId)
                ->where('code', '5110')
                ->first()
                ?? DB::table('chart_of_accounts')
                    ->where('company_id', $companyId)
                    ->where('code', '5100')
                    ->first()
                ?? DB::table('chart_of_accounts')
                    ->where('company_id', $companyId)
                    ->where('category', 'expenses')
                    ->where('name', 'LIKE', '%Cost%')
                    ->whereNull('parent_id')
                    ->first();

            // Resolve Inventory account: prefer 1150, then name match
            $inventoryAccount = DB::table('chart_of_accounts')
                ->where('company_id', $companyId)
                ->where('code', '1150')
                ->first()
                ?? DB::table('chart_of_accounts')
                    ->where('company_id', $companyId)
                    ->where('name', 'LIKE', '%Inventory%')
                    ->first();

            // Skip this company if either account is missing
            if (!$cogsAccount || !$inventoryAccount) {
                continue;
            }

            $cogsAccId = $cogsAccount->id;
            $invAccId  = $inventoryAccount->id;

            // Find all sales journal entries for this company that have NO COGS item yet.
            // Identify sales entries by matching reference to a known sales_order invoice_no.
            $salesInvoiceNos = DB::table('sales_orders')
                ->where('company_id', $companyId)
                ->pluck('invoice_no');

            if ($salesInvoiceNos->isEmpty()) continue;

            $entriesWithoutCogs = DB::table('journal_entries as je')
                ->where('je.company_id', $companyId)
                ->whereIn('je.reference', $salesInvoiceNos)
                ->whereNotExists(function ($q) use ($cogsAccId) {
                    $q->select(DB::raw(1))
                      ->from('journal_items as ji')
                      ->whereColumn('ji.journal_entry_id', 'je.id')
                      ->where('ji.account_id', $cogsAccId)
                      ->where('ji.debit', '>', 0);
                })
                ->get(['je.id', 'je.reference', 'je.branch_id', 'je.date']);

            foreach ($entriesWithoutCogs as $entry) {
                // Look up the matching sales order via invoice_no = reference
                if (!$entry->reference) continue;

                $order = DB::table('sales_orders')
                    ->where('company_id', $companyId)
                    ->where('invoice_no', $entry->reference)
                    ->first();

                if (!$order) continue;

                // Sum purchase_price × qty for all items on this order
                $items = DB::table('sales_order_items as soi')
                    ->join('products as p', 'p.id', '=', 'soi.product_id')
                    ->where('soi.sales_order_id', $order->id)
                    ->whereNotNull('soi.product_id')
                    ->get(['soi.quantity', 'p.purchase_price']);

                $totalCogs = 0;
                foreach ($items as $item) {
                    $purchasePrice = (float) ($item->purchase_price ?? 0);
                    $qty = (float) ($item->quantity ?? 0);
                    $totalCogs += $purchasePrice * $qty;
                }

                if ($totalCogs <= 0) continue;

                $now = now()->toDateTimeString();

                // COGS debit — increases expense
                DB::table('journal_items')->insert([
                    'company_id'       => $companyId,
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $cogsAccId,
                    'debit'            => $totalCogs,
                    'credit'           => 0,
                    'description'      => 'COGS for ' . $entry->reference . ' (backfilled)',
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ]);

                // Inventory credit — decreases asset
                DB::table('journal_items')->insert([
                    'company_id'       => $companyId,
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $invAccId,
                    'debit'            => 0,
                    'credit'           => $totalCogs,
                    'description'      => 'Inventory reduction for ' . $entry->reference . ' (backfilled)',
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Remove backfilled items only (identified by the description suffix)
        DB::table('journal_items')
            ->where('description', 'LIKE', '%(backfilled)')
            ->delete();
    }
};
