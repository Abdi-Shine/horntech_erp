<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Responsible for seeding a complete, hierarchical Chart of Accounts for a
 * given company.  Called both from the DatabaseSeeder (for existing tenants)
 * and from RegisteredUserController (for brand-new tenants on sign-up).
 *
 * Structure
 * ─────────
 * Level-0  Root categories   (code  1, 2, 3, 4, 5)
 * Level-1  Sub-groups        (code  1100, 2100, …)
 * Level-2  Leaf accounts     (code  1110, 1120, …)
 */
class ChartOfAccountsService
{
    /**
     * Seed all accounts for a single company.
     * Uses updateOrInsert so it is safe to call more than once.
     */
    public function seedForCompany(int $companyId, ?int $branchId = null): void
    {
        // Fall back to first branch for this company if not provided
        if ($branchId === null) {
            $branchId = DB::table('branches')->where('company_id', $companyId)->value('id');
        }

        $accounts = $this->getAccountTree();

        // We need to insert parents before children.
        // The tree is already ordered top-down, so a single pass is enough.
        $insertedIds = []; // code => id map

        foreach ($accounts as $acc) {
            $parentId = null;
            if ($acc['parent_code'] !== null) {
                $parentId = $insertedIds[$acc['parent_code']] ?? null;
            }

            // Check if already exists
            $existing = DB::table('chart_of_accounts')
                ->where('company_id', $companyId)
                ->where('code', $acc['code'])
                ->first();

            if ($existing) {
                // Update in place
                DB::table('chart_of_accounts')
                    ->where('id', $existing->id)
                    ->update([
                        'branch_id'  => $branchId,
                        'name'       => $acc['name'],
                        'category'   => $acc['category'],
                        'type'       => $acc['type'],
                        'parent_id'  => $parentId,
                        'is_active'  => 1,
                        'updated_at' => now(),
                    ]);
                $insertedIds[$acc['code']] = $existing->id;
            } else {
                // Fresh insert
                $id = DB::table('chart_of_accounts')->insertGetId([
                    'company_id' => $companyId,
                    'branch_id'  => $branchId,
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

    // ──────────────────────────────────────────────────────────────────────────
    //  Account tree definition
    //  Every entry: code, name, category, type, parent_code (null = root)
    // ──────────────────────────────────────────────────────────────────────────
    private function getAccountTree(): array
    {
        return [

            // ── 1  ASSETS ────────────────────────────────────────────────────
            ['code' => '1',    'name' => 'Assets',                 'category' => 'assets',      'type' => 'parent',     'parent_code' => null],

            //  1.1 Current Assets
            ['code' => '1100', 'name' => 'Current Assets',         'category' => 'assets',      'type' => 'parent',     'parent_code' => '1'],
            ['code' => '1110', 'name' => 'Cash on Hand',           'category' => 'assets',      'type' => 'cash',       'parent_code' => '1100'],
            ['code' => '1120', 'name' => 'Petty Cash',             'category' => 'assets',      'type' => 'cash',       'parent_code' => '1100'],
            ['code' => '1130', 'name' => 'Bank Accounts',          'category' => 'assets',      'type' => 'parent',     'parent_code' => '1100'],
            ['code' => '1131', 'name' => 'Main Operating Bank',    'category' => 'assets',      'type' => 'bank',       'parent_code' => '1130'],
            ['code' => '1132', 'name' => 'Savings Account',        'category' => 'assets',      'type' => 'bank',       'parent_code' => '1130'],
            ['code' => '1140', 'name' => 'Accounts Receivable',    'category' => 'assets',      'type' => 'receivable', 'parent_code' => '1100'],
            ['code' => '1150', 'name' => 'Inventory',              'category' => 'assets',      'type' => 'inventory',  'parent_code' => '1100'],
            ['code' => '1160', 'name' => 'Prepaid Expenses',       'category' => 'assets',      'type' => 'other',      'parent_code' => '1100'],
            ['code' => '1170', 'name' => 'Other Current Assets',   'category' => 'assets',      'type' => 'other',      'parent_code' => '1100'],

            //  1.2 Non-Current Assets
            ['code' => '1200', 'name' => 'Non-Current Assets',     'category' => 'assets',      'type' => 'parent',     'parent_code' => '1'],
            ['code' => '1210', 'name' => 'Property & Equipment',   'category' => 'assets',      'type' => 'fixed',      'parent_code' => '1200'],
            ['code' => '1220', 'name' => 'Accumulated Depreciation','category' => 'assets',     'type' => 'fixed',      'parent_code' => '1200'],
            ['code' => '1230', 'name' => 'Intangible Assets',      'category' => 'assets',      'type' => 'fixed',      'parent_code' => '1200'],
            ['code' => '1240', 'name' => 'Long-Term Investments',  'category' => 'assets',      'type' => 'other',      'parent_code' => '1200'],

            // ── 2  LIABILITIES ───────────────────────────────────────────────
            ['code' => '2',    'name' => 'Liabilities',            'category' => 'liabilities', 'type' => 'parent',     'parent_code' => null],

            //  2.1 Current Liabilities
            ['code' => '2100', 'name' => 'Current Liabilities',    'category' => 'liabilities', 'type' => 'parent',     'parent_code' => '2'],
            ['code' => '2110', 'name' => 'Accounts Payable',       'category' => 'liabilities', 'type' => 'payable',    'parent_code' => '2100'],
            ['code' => '2120', 'name' => 'Taxes Payable',          'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2130', 'name' => 'VAT Payable',            'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2140', 'name' => 'Accrued Salaries',       'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2150', 'name' => 'Accrued Expenses',       'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],
            ['code' => '2160', 'name' => 'Deferred Revenue',       'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2100'],

            //  2.2 Non-Current Liabilities
            ['code' => '2200', 'name' => 'Non-Current Liabilities','category' => 'liabilities', 'type' => 'parent',     'parent_code' => '2'],
            ['code' => '2210', 'name' => 'Loans Payable',          'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2200'],
            ['code' => '2220', 'name' => 'Long-Term Debt',         'category' => 'liabilities', 'type' => 'liability',  'parent_code' => '2200'],

            // ── 3  EQUITY ────────────────────────────────────────────────────
            ['code' => '3',    'name' => 'Equity',                 'category' => 'equity',      'type' => 'parent',     'parent_code' => null],
            ['code' => '3100', 'name' => 'Capital',                'category' => 'equity',      'type' => 'parent',     'parent_code' => '3'],
            ['code' => '3110', 'name' => 'Owners Capital',         'category' => 'equity',      'type' => 'equity',     'parent_code' => '3100'],
            ['code' => '3120', 'name' => "Shareholders' Equity",   'category' => 'equity',      'type' => 'equity',     'parent_code' => '3100'],
            ['code' => '3200', 'name' => 'Retained Earnings',      'category' => 'equity',      'type' => 'equity',     'parent_code' => '3'],
            ['code' => '3300', 'name' => 'Opening Balance Equity', 'category' => 'equity',      'type' => 'equity',     'parent_code' => '3'],

            // ── 4  REVENUE ───────────────────────────────────────────────────
            ['code' => '4',    'name' => 'Revenue',                'category' => 'revenue',     'type' => 'parent',     'parent_code' => null],

            //  4.1 Operating Revenue
            ['code' => '4100', 'name' => 'Operating Revenue',      'category' => 'revenue',     'type' => 'parent',     'parent_code' => '4'],
            ['code' => '4110', 'name' => 'Sales Revenue',          'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4100'],
            ['code' => '4120', 'name' => 'Service Income',         'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4100'],
            ['code' => '4130', 'name' => 'Subscription Revenue',   'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4100'],

            //  4.2 Other Income
            ['code' => '4200', 'name' => 'Other Income',           'category' => 'revenue',     'type' => 'parent',     'parent_code' => '4'],
            ['code' => '4210', 'name' => 'Interest Income',        'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4200'],
            ['code' => '4220', 'name' => 'Gain on Asset Sale',     'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4200'],
            ['code' => '4230', 'name' => 'Miscellaneous Income',   'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4200'],

            // ── 5  EXPENSES ──────────────────────────────────────────────────
            ['code' => '5',    'name' => 'Expenses',               'category' => 'expenses',    'type' => 'parent',     'parent_code' => null],

            //  5.1 Cost of Goods Sold
            ['code' => '5100', 'name' => 'Cost of Goods Sold',     'category' => 'expenses',    'type' => 'parent',     'parent_code' => '5'],
            ['code' => '5110', 'name' => 'Product Cost',           'category' => 'expenses',    'type' => 'expense',    'parent_code' => '5100'],
            ['code' => '5120', 'name' => 'Direct Labour',          'category' => 'expenses',    'type' => 'expense',    'parent_code' => '5100'],
            ['code' => '5130', 'name' => 'Manufacturing Overhead', 'category' => 'expenses',    'type' => 'expense',    'parent_code' => '5100'],

            //  5.2 Operating Expenses
            ['code' => '5200', 'name' => 'Operating Expenses',     'category' => 'expenses',    'type' => 'parent',     'parent_code' => '5'],
            ['code' => '5210', 'name' => 'Salaries & Wages',       'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5220', 'name' => 'Rent Expense',           'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5230', 'name' => 'Utilities Expense',      'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5240', 'name' => 'Office Supplies',        'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5250', 'name' => 'Depreciation Expense',   'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5260', 'name' => 'Insurance Expense',      'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5270', 'name' => 'Marketing & Advertising','category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],
            ['code' => '5280', 'name' => 'Travel & Transport',     'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5200'],

            //  5.3 Financial Expenses
            ['code' => '5300', 'name' => 'Financial Expenses',     'category' => 'expenses',    'type' => 'parent',     'parent_code' => '5'],
            ['code' => '5310', 'name' => 'Bank Charges',           'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5300'],
            ['code' => '5320', 'name' => 'Interest Expense',       'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5300'],
            ['code' => '5330', 'name' => 'Foreign Exchange Loss',  'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5300'],
        ];
    }
}
