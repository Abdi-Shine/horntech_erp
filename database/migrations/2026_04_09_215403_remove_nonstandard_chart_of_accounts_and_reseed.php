<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The canonical 60-account chart (5 categories, clean hierarchy).
     * These are the ONLY accounts that should exist per company.
     */
    private function getCanonicalAccounts(): array
    {
        return [
            // ── ASSETS ──────────────────────────────────────────────────────
            ['code' => '1',    'name' => 'Assets',                  'category' => 'assets',      'type' => 'parent',     'parent_code' => null],
            ['code' => '1100', 'name' => 'Current Assets',          'category' => 'assets',      'type' => 'parent',     'parent_code' => '1'],
            ['code' => '1110', 'name' => 'Cash on Hand',            'category' => 'assets',      'type' => 'cash',       'parent_code' => '1100'],
            ['code' => '1120', 'name' => 'Petty Cash',              'category' => 'assets',      'type' => 'cash',       'parent_code' => '1100'],
            ['code' => '1130', 'name' => 'Bank Accounts',           'category' => 'assets',      'type' => 'parent',     'parent_code' => '1100'],
            ['code' => '1131', 'name' => 'Main Operating Bank',     'category' => 'assets',      'type' => 'bank',       'parent_code' => '1130'],
            ['code' => '1132', 'name' => 'Savings Account',         'category' => 'assets',      'type' => 'bank',       'parent_code' => '1130'],
            ['code' => '1140', 'name' => 'Accounts Receivable',     'category' => 'assets',      'type' => 'receivable', 'parent_code' => '1100'],
            ['code' => '1150', 'name' => 'Inventory',               'category' => 'assets',      'type' => 'inventory',  'parent_code' => '1100'],
            ['code' => '1160', 'name' => 'Prepaid Expenses',        'category' => 'assets',      'type' => 'other',      'parent_code' => '1100'],
            ['code' => '1170', 'name' => 'Other Current Assets',    'category' => 'assets',      'type' => 'other',      'parent_code' => '1100'],
            ['code' => '1200', 'name' => 'Non-Current Assets',      'category' => 'assets',      'type' => 'parent',     'parent_code' => '1'],
            ['code' => '1210', 'name' => 'Property & Equipment',    'category' => 'assets',      'type' => 'fixed',      'parent_code' => '1200'],
            ['code' => '1220', 'name' => 'Accumulated Depreciation','category' => 'assets',      'type' => 'fixed',      'parent_code' => '1200'],
            ['code' => '1230', 'name' => 'Intangible Assets',       'category' => 'assets',      'type' => 'fixed',      'parent_code' => '1200'],
            ['code' => '1240', 'name' => 'Long-Term Investments',   'category' => 'assets',      'type' => 'other',      'parent_code' => '1200'],

            // ── LIABILITIES ─────────────────────────────────────────────────
            ['code' => '2',    'name' => 'Liabilities',             'category' => 'liabilities', 'type' => 'parent',     'parent_code' => null],
            ['code' => '2100', 'name' => 'Current Liabilities',     'category' => 'liabilities', 'type' => 'parent',     'parent_code' => '2'],
            ['code' => '2110', 'name' => 'Accounts Payable',        'category' => 'liabilities', 'type' => 'payable',    'parent_code' => '2100'],
            ['code' => '2120', 'name' => 'Taxes Payable',           'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2130', 'name' => 'VAT Payable',             'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2140', 'name' => 'Accrued Salaries',        'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2150', 'name' => 'Accrued Expenses',        'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2160', 'name' => 'Deferred Revenue',        'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2200', 'name' => 'Non-Current Liabilities', 'category' => 'liabilities', 'type' => 'parent',     'parent_code' => '2'],
            ['code' => '2210', 'name' => 'Loans Payable',           'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2200'],
            ['code' => '2220', 'name' => 'Long-Term Debt',          'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2200'],

            // ── EQUITY ──────────────────────────────────────────────────────
            ['code' => '3',    'name' => 'Equity',                  'category' => 'equity',      'type' => 'parent',     'parent_code' => null],
            ['code' => '3100', 'name' => 'Capital',                 'category' => 'equity',      'type' => 'parent',     'parent_code' => '3'],
            ['code' => '3110', 'name' => 'Owners Capital',          'category' => 'equity',      'type' => 'equity',     'parent_code' => '3100'],
            ['code' => '3120', 'name' => "Shareholders' Equity",    'category' => 'equity',      'type' => 'equity',     'parent_code' => '3100'],
            ['code' => '3200', 'name' => 'Retained Earnings',       'category' => 'equity',      'type' => 'equity',     'parent_code' => '3'],
            ['code' => '3300', 'name' => 'Opening Balance Equity',  'category' => 'equity',      'type' => 'equity',     'parent_code' => '3'],

            // ── REVENUE ─────────────────────────────────────────────────────
            ['code' => '4',    'name' => 'Revenue',                 'category' => 'revenue',     'type' => 'parent',     'parent_code' => null],
            ['code' => '4100', 'name' => 'Operating Revenue',       'category' => 'revenue',     'type' => 'parent',     'parent_code' => '4'],
            ['code' => '4110', 'name' => 'Sales Revenue',           'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4100'],
            ['code' => '4120', 'name' => 'Service Income',          'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4100'],
            ['code' => '4130', 'name' => 'Subscription Revenue',    'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4100'],
            ['code' => '4200', 'name' => 'Other Income',            'category' => 'revenue',     'type' => 'parent',     'parent_code' => '4'],
            ['code' => '4210', 'name' => 'Interest Income',         'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4200'],
            ['code' => '4220', 'name' => 'Gain on Asset Sale',      'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4200'],
            ['code' => '4230', 'name' => 'Miscellaneous Income',    'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4200'],

            // ── EXPENSES ────────────────────────────────────────────────────
            ['code' => '5',    'name' => 'Expenses',                'category' => 'expenses',    'type' => 'parent',     'parent_code' => null],
            ['code' => '5100', 'name' => 'Cost of Goods Sold',      'category' => 'expenses',    'type' => 'parent',     'parent_code' => '5'],
            ['code' => '5110', 'name' => 'Product Cost',            'category' => 'expenses',    'type' => 'expense',    'parent_code' => '5100'],
            ['code' => '5120', 'name' => 'Direct Labour',           'category' => 'expenses',    'type' => 'expense',    'parent_code' => '5100'],
            ['code' => '5130', 'name' => 'Manufacturing Overhead',  'category' => 'expenses',    'type' => 'expense',    'parent_code' => '5100'],
            ['code' => '5200', 'name' => 'Operating Expenses',      'category' => 'expenses',    'type' => 'parent',     'parent_code' => '5'],
            ['code' => '5210', 'name' => 'Salaries & Wages',        'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5220', 'name' => 'Rent Expense',            'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5230', 'name' => 'Utilities Expense',       'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5240', 'name' => 'Office Supplies',         'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5250', 'name' => 'Depreciation Expense',    'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5260', 'name' => 'Insurance Expense',       'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5270', 'name' => 'Marketing & Advertising', 'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5280', 'name' => 'Travel & Transport',      'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5300', 'name' => 'Financial Expenses',      'category' => 'expenses',    'type' => 'parent',     'parent_code' => '5'],
            ['code' => '5310', 'name' => 'Bank Charges',            'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5300'],
            ['code' => '5320', 'name' => 'Interest Expense',        'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5300'],
            ['code' => '5330', 'name' => 'Foreign Exchange Loss',   'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5300'],
        ];
    }

    /**
     * Map old nonstandard codes → nearest canonical code for journal rerouting.
     */
    private function getLegacyRemap(): array
    {
        return [
            // Old 3-digit / short codes → canonical equivalents
            '101'  => '1110', '111'  => '1110', '1011' => '1110', '1111' => '1110', // Cash on Hand
            '102'  => '1120', '1012' => '1120',                                      // Petty Cash
            '103'  => '1130', '1013' => '1131',                                      // Bank
            '104'  => '1140', '1030' => '1140', '1031' => '1140',                   // AR
            '105'  => '1150', '1050' => '1150', '1400' => '1150',                   // Inventory
            '106'  => '1160',                                                         // Prepaid
            '107'  => '1170',                                                         // Other Current
            '201'  => '2110', '2001' => '2110',                                      // AP
            '202'  => '2120',                                                         // Taxes Payable
            '203'  => '2130',                                                         // VAT
            '204'  => '2140',                                                         // Accrued Salaries
            '205'  => '2150',                                                         // Accrued Expenses
            '210'  => '2210',                                                         // Loans Payable
            '301'  => '3110',                                                         // Owner Capital
            '302'  => '3200',                                                         // Retained Earnings
            '3010' => '3300',                                                         // Opening Balance Equity
            '400'  => '4110', '4000' => '4110', '401'  => '4110',                   // Revenue / Sales
            '402'  => '4120',                                                         // Service Income
            '403'  => '4210',                                                         // Interest Income
            '500'  => '5110', '5000' => '5110', '501'  => '5110',                   // Product Cost / COGS
            '502'  => '5120',                                                         // Direct Labour
            '510'  => '5210', '5100' => '5210',                                      // Salaries (old 5100 was operating)
            '511'  => '5220',                                                         // Rent
            '512'  => '5230',                                                         // Utilities
            '513'  => '5240',                                                         // Office Supplies
            '514'  => '5250',                                                         // Depreciation
            '515'  => '5260',                                                         // Insurance
            '600'  => '5310', '601'  => '5310',                                      // Bank Charges
            '602'  => '5320',                                                         // Interest Expense
            '700'  => '4110', '701'  => '4230',                                      // Misc Income
        ];
    }

    public function up(): void
    {
        $canonicalCodes = array_column($this->getCanonicalAccounts(), 'code');
        $legacyRemap    = $this->getLegacyRemap();

        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            $cid = $company->id;

            // Build map: canonical code → id for this company
            $canonicalMap = DB::table('chart_of_accounts')
                ->where('company_id', $cid)
                ->whereIn('code', $canonicalCodes)
                ->pluck('id', 'code')
                ->toArray();

            // Get all nonstandard accounts for this company
            $nonstandard = DB::table('chart_of_accounts')
                ->where('company_id', $cid)
                ->whereNotIn('code', $canonicalCodes)
                ->get();

            foreach ($nonstandard as $old) {
                // Find the canonical account to reroute references to
                $targetCode = $legacyRemap[$old->code] ?? null;
                $targetId   = $targetCode ? ($canonicalMap[$targetCode] ?? null) : null;

                // Fallback: match by type
                if (!$targetId) {
                    $targetId = match ($old->type) {
                        'cash'       => $canonicalMap['1110'] ?? null,
                        'bank'       => $canonicalMap['1131'] ?? null,
                        'receivable' => $canonicalMap['1140'] ?? null,
                        'inventory'  => $canonicalMap['1150'] ?? null,
                        'payable'    => $canonicalMap['2110'] ?? null,
                        'revenue'    => $canonicalMap['4110'] ?? null,
                        'expense', 'operating' => $canonicalMap['5110'] ?? null,
                        default      => null,
                    };
                }

                if ($targetId) {
                    // Reroute journal_items
                    DB::table('journal_items')
                        ->where('account_id', $old->id)
                        ->update(['account_id' => $targetId]);

                    // Reroute customers
                    DB::table('customers')
                        ->where('account_id', $old->id)
                        ->update(['account_id' => $targetId]);

                    // Update target account balance from journal_items
                    $bal = DB::table('journal_items')
                        ->where('account_id', $targetId)
                        ->selectRaw('SUM(debit) as d, SUM(credit) as c')
                        ->first();
                    $d = (float)($bal->d ?? 0);
                    $c = (float)($bal->c ?? 0);
                    $targetAcc = DB::table('chart_of_accounts')->where('id', $targetId)->first();
                    $balance   = in_array($targetAcc->category, ['assets', 'expenses']) ? ($d - $c) : ($c - $d);
                    DB::table('chart_of_accounts')->where('id', $targetId)->update(['balance' => $balance]);
                }

                // Delete the nonstandard account
                DB::table('chart_of_accounts')->where('id', $old->id)->delete();
            }

            // Fix parent_id references that may now be broken (point to deleted parents)
            // Re-seed canonical hierarchy using updateOrInsert
            $this->reseedHierarchy($cid);
        }
    }

    private function reseedHierarchy(int $cid): void
    {
        $accounts   = $this->getCanonicalAccounts();
        $insertedIds = [];

        // First pass: collect existing IDs
        foreach ($accounts as $acc) {
            $existing = DB::table('chart_of_accounts')
                ->where('company_id', $cid)
                ->where('code', $acc['code'])
                ->first();
            if ($existing) {
                $insertedIds[$acc['code']] = $existing->id;
            }
        }

        // Second pass: fix parent_id for all canonical accounts
        foreach ($accounts as $acc) {
            $parentId = ($acc['parent_code'] !== null)
                ? ($insertedIds[$acc['parent_code']] ?? null)
                : null;

            if (isset($insertedIds[$acc['code']])) {
                DB::table('chart_of_accounts')
                    ->where('id', $insertedIds[$acc['code']])
                    ->update(['parent_id' => $parentId, 'updated_at' => now()]);
            } else {
                // Insert missing canonical account
                $id = DB::table('chart_of_accounts')->insertGetId([
                    'company_id' => $cid,
                    'code'       => $acc['code'],
                    'name'       => $acc['name'],
                    'category'   => $acc['category'],
                    'type'       => $acc['type'],
                    'parent_id'  => $parentId,
                    'balance'    => 0,
                    'is_active'  => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $insertedIds[$acc['code']] = $id;
            }
        }
    }

    public function down(): void
    {
        // Nonstandard accounts cannot be safely restored.
    }
};
