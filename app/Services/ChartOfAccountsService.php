<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Seeds a clean 30-account Chart of Accounts for small businesses.
 * No parent/group rows — only real posting accounts.
 *
 * Structure (5 categories):
 *   Assets      1110–1220
 *   Liabilities 2110–2210
 *   Equity      3110–3300
 *   Revenue     4110–4210
 *   Expenses    5110–5320
 */
class ChartOfAccountsService
{
    public function seedForCompany(int $companyId, ?int $branchId = null): void
    {
        if ($branchId === null) {
            $branchId = DB::table('branches')->where('company_id', $companyId)->value('id');
        }

        foreach ($this->getAccountTree() as $acc) {
            $existing = DB::table('chart_of_accounts')
                ->where('company_id', $companyId)
                ->where('code', $acc['code'])
                ->first();

            if ($existing) {
                DB::table('chart_of_accounts')
                    ->where('id', $existing->id)
                    ->update([
                        'branch_id'  => $branchId,
                        'name'       => $acc['name'],
                        'category'   => $acc['category'],
                        'type'       => $acc['type'],
                        'parent_id'  => null,
                        'is_active'  => 1,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('chart_of_accounts')->insertGetId([
                    'company_id' => $companyId,
                    'branch_id'  => $branchId,
                    'code'       => $acc['code'],
                    'name'       => $acc['name'],
                    'category'   => $acc['category'],
                    'type'       => $acc['type'],
                    'parent_id'  => null,
                    'balance'    => 0,
                    'is_active'  => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getAccountTree(): array
    {
        return [
            // ── ASSETS ──────────────────────────────────────────────────────
            ['code' => '1110', 'name' => 'Cash on Hand',             'category' => 'assets',      'type' => 'cash'],
            ['code' => '1120', 'name' => 'Petty Cash',               'category' => 'assets',      'type' => 'cash'],
            ['code' => '1131', 'name' => 'Main Operating Bank',      'category' => 'assets',      'type' => 'bank'],
            ['code' => '1140', 'name' => 'Accounts Receivable',      'category' => 'assets',      'type' => 'receivable'],
            ['code' => '1150', 'name' => 'Inventory',                'category' => 'assets',      'type' => 'inventory'],
            ['code' => '1160', 'name' => 'Prepaid Expenses',         'category' => 'assets',      'type' => 'other'],
            ['code' => '1210', 'name' => 'Property & Equipment',     'category' => 'assets',      'type' => 'fixed'],
            ['code' => '1220', 'name' => 'Accumulated Depreciation', 'category' => 'assets',      'type' => 'fixed'],

            // ── LIABILITIES ─────────────────────────────────────────────────
            ['code' => '2110', 'name' => 'Accounts Payable',         'category' => 'liabilities', 'type' => 'payable'],
            ['code' => '2120', 'name' => 'Taxes Payable',            'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '2130', 'name' => 'VAT Payable',              'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '2140', 'name' => 'Accrued Salaries',         'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '2150', 'name' => 'Accrued Expenses',         'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '2210', 'name' => 'Loans Payable',            'category' => 'liabilities', 'type' => 'liability'],

            // ── EQUITY ──────────────────────────────────────────────────────
            ['code' => '3110', 'name' => 'Owners Capital',           'category' => 'equity',      'type' => 'equity'],
            ['code' => '3200', 'name' => 'Retained Earnings',        'category' => 'equity',      'type' => 'equity'],
            ['code' => '3300', 'name' => 'Opening Balance Equity',   'category' => 'equity',      'type' => 'equity'],

            // ── REVENUE ─────────────────────────────────────────────────────
            ['code' => '4110', 'name' => 'Sales Revenue',            'category' => 'revenue',     'type' => 'revenue'],
            ['code' => '4120', 'name' => 'Service Income',           'category' => 'revenue',     'type' => 'revenue'],
            ['code' => '4210', 'name' => 'Miscellaneous Income',     'category' => 'revenue',     'type' => 'revenue'],

            // ── EXPENSES ────────────────────────────────────────────────────
            ['code' => '5110', 'name' => 'Product Cost (COGS)',      'category' => 'expenses',    'type' => 'expense'],
            ['code' => '5210', 'name' => 'Salaries & Wages',         'category' => 'expenses',    'type' => 'operating'],
            ['code' => '5220', 'name' => 'Rent Expense',             'category' => 'expenses',    'type' => 'operating'],
            ['code' => '5230', 'name' => 'Utilities Expense',        'category' => 'expenses',    'type' => 'operating'],
            ['code' => '5240', 'name' => 'Office Supplies',          'category' => 'expenses',    'type' => 'operating'],
            ['code' => '5250', 'name' => 'Depreciation Expense',     'category' => 'expenses',    'type' => 'operating'],
            ['code' => '5260', 'name' => 'Insurance Expense',        'category' => 'expenses',    'type' => 'operating'],
            ['code' => '5270', 'name' => 'Marketing & Advertising',  'category' => 'expenses',    'type' => 'operating'],
            ['code' => '5310', 'name' => 'Bank Charges',             'category' => 'expenses',    'type' => 'operating'],
            ['code' => '5320', 'name' => 'Interest Expense',         'category' => 'expenses',    'type' => 'operating'],
        ];
    }
}
