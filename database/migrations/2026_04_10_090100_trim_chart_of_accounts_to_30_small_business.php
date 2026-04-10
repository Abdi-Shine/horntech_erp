<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The 30 canonical small-business account codes to KEEP.
     * Everything else gets deleted after journal refs are rerouted.
     */
    private array $keep = [
        '1110','1120','1131','1140','1150','1160','1210','1220',
        '2110','2120','2130','2140','2150','2210',
        '3110','3200','3300',
        '4110','4120','4210',
        '5110','5210','5220','5230','5240','5250','5260','5270','5310','5320',
    ];

    /**
     * Remap every non-kept code → the best kept equivalent.
     */
    private array $remap = [
        // Assets
        '1'    => '1110', '100'  => '1110', '101'  => '1110', '1011' => '1110',
        '1100' => '1110', '1111' => '1110',
        '102'  => '1120', '1012' => '1120',
        '1130' => '1131', '103'  => '1131', '1132' => '1131',
        '104'  => '1140', '1030' => '1140', '1031' => '1140',
        '105'  => '1150', '1050' => '1150', '1400' => '1150',
        '106'  => '1160',
        '107'  => '1160', '1170' => '1160',
        '1200' => '1210', '108'  => '1210',
        '1230' => '1210', '1240' => '1210',

        // Liabilities
        '2'    => '2110', '200'  => '2110', '201'  => '2110', '2001' => '2110',
        '2100' => '2110', '270'  => '2110', '275'  => '2110',
        '202'  => '2120',
        '203'  => '2130',
        '204'  => '2140',
        '205'  => '2150', '2160' => '2150',
        '2200' => '2210', '210'  => '2210', '2220' => '2210',

        // Equity
        '3'    => '3110', '300'  => '3110', '301'  => '3110',
        '3100' => '3110', '3120' => '3110',
        '302'  => '3200',
        '3010' => '3300', '303'  => '3300',

        // Revenue
        '4'    => '4110', '400'  => '4110', '401'  => '4110',
        '4000' => '4110', '4100' => '4110', '4130' => '4110',
        '4200' => '4210', '402'  => '4120',
        '4220' => '4210', '4230' => '4210',
        '403'  => '4210', '404'  => '4210',
        '700'  => '4210', '701'  => '4210',

        // Expenses
        '5'    => '5110', '500'  => '5110', '501'  => '5110',
        '5000' => '5110', '5100' => '5110',
        '5120' => '5110', '5130' => '5110',
        '502'  => '5110',
        '5200' => '5210', '510'  => '5210',
        '511'  => '5220', '512'  => '5230',
        '513'  => '5240', '514'  => '5250',
        '515'  => '5260', '516'  => '5270', '5280' => '5270',
        '5300' => '5310', '600'  => '5310', '601'  => '5310',
        '602'  => '5320', '5330' => '5310',
    ];

    public function up(): void
    {
        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            $cid = $company->id;

            // Build code → id map for the 30 kept accounts
            $keptMap = DB::table('chart_of_accounts')
                ->where('company_id', $cid)
                ->whereIn('code', $this->keep)
                ->pluck('id', 'code')
                ->toArray();

            // Find all accounts NOT in the keep list
            $toRemove = DB::table('chart_of_accounts')
                ->where('company_id', $cid)
                ->whereNotIn('code', $this->keep)
                ->get();

            foreach ($toRemove as $old) {
                // Find the target kept account
                $targetCode = $this->remap[$old->code] ?? null;
                $targetId   = $targetCode ? ($keptMap[$targetCode] ?? null) : null;

                // Fallback by type if no explicit remap
                if (!$targetId) {
                    $targetId = match ($old->type) {
                        'cash'            => $keptMap['1110'] ?? null,
                        'bank'            => $keptMap['1131'] ?? null,
                        'receivable'      => $keptMap['1140'] ?? null,
                        'inventory'       => $keptMap['1150'] ?? null,
                        'fixed'           => $keptMap['1210'] ?? null,
                        'payable'         => $keptMap['2110'] ?? null,
                        'liability'       => $keptMap['2150'] ?? null,
                        'equity'          => $keptMap['3110'] ?? null,
                        'revenue'         => $keptMap['4110'] ?? null,
                        'expense'         => $keptMap['5110'] ?? null,
                        'operating'       => $keptMap['5210'] ?? null,
                        default           => null,
                    };
                }

                if ($targetId) {
                    DB::table('journal_items')
                        ->where('account_id', $old->id)
                        ->update(['account_id' => $targetId]);

                    DB::table('customers')
                        ->where('account_id', $old->id)
                        ->update(['account_id' => $targetId]);
                }

                DB::table('chart_of_accounts')->where('id', $old->id)->delete();
            }

            // Recalculate balances for all kept accounts from journal_items
            foreach ($keptMap as $code => $accId) {
                $bal = DB::table('journal_items')
                    ->where('account_id', $accId)
                    ->selectRaw('COALESCE(SUM(debit),0) as d, COALESCE(SUM(credit),0) as c')
                    ->first();

                $acc     = DB::table('chart_of_accounts')->where('id', $accId)->first();
                $balance = in_array($acc->category, ['assets', 'expenses'])
                    ? ((float)$bal->d - (float)$bal->c)
                    : ((float)$bal->c - (float)$bal->d);

                DB::table('chart_of_accounts')
                    ->where('id', $accId)
                    ->update(['balance' => $balance, 'parent_id' => null]);
            }

            // Ensure all 30 accounts exist — insert any that are missing
            $branchId = DB::table('branches')->where('company_id', $cid)->value('id');
            foreach ($this->getAccountTree() as $acc) {
                $exists = DB::table('chart_of_accounts')
                    ->where('company_id', $cid)
                    ->where('code', $acc['code'])
                    ->exists();

                if (!$exists) {
                    DB::table('chart_of_accounts')->insert([
                        'company_id' => $cid,
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
                } else {
                    // Update name to match new standard
                    DB::table('chart_of_accounts')
                        ->where('company_id', $cid)
                        ->where('code', $acc['code'])
                        ->update(['name' => $acc['name'], 'updated_at' => now()]);
                }
            }
        }
    }

    public function down(): void
    {
        // Cannot safely restore deleted accounts.
    }

    private function getAccountTree(): array
    {
        return [
            ['code' => '1110', 'name' => 'Cash on Hand',             'category' => 'assets',      'type' => 'cash'],
            ['code' => '1120', 'name' => 'Petty Cash',               'category' => 'assets',      'type' => 'cash'],
            ['code' => '1131', 'name' => 'Main Operating Bank',      'category' => 'assets',      'type' => 'bank'],
            ['code' => '1140', 'name' => 'Accounts Receivable',      'category' => 'assets',      'type' => 'receivable'],
            ['code' => '1150', 'name' => 'Inventory',                'category' => 'assets',      'type' => 'inventory'],
            ['code' => '1160', 'name' => 'Prepaid Expenses',         'category' => 'assets',      'type' => 'other'],
            ['code' => '1210', 'name' => 'Property & Equipment',     'category' => 'assets',      'type' => 'fixed'],
            ['code' => '1220', 'name' => 'Accumulated Depreciation', 'category' => 'assets',      'type' => 'fixed'],
            ['code' => '2110', 'name' => 'Accounts Payable',         'category' => 'liabilities', 'type' => 'payable'],
            ['code' => '2120', 'name' => 'Taxes Payable',            'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '2130', 'name' => 'VAT Payable',              'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '2140', 'name' => 'Accrued Salaries',         'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '2150', 'name' => 'Accrued Expenses',         'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '2210', 'name' => 'Loans Payable',            'category' => 'liabilities', 'type' => 'liability'],
            ['code' => '3110', 'name' => 'Owners Capital',           'category' => 'equity',      'type' => 'equity'],
            ['code' => '3200', 'name' => 'Retained Earnings',        'category' => 'equity',      'type' => 'equity'],
            ['code' => '3300', 'name' => 'Opening Balance Equity',   'category' => 'equity',      'type' => 'equity'],
            ['code' => '4110', 'name' => 'Sales Revenue',            'category' => 'revenue',     'type' => 'revenue'],
            ['code' => '4120', 'name' => 'Service Income',           'category' => 'revenue',     'type' => 'revenue'],
            ['code' => '4210', 'name' => 'Miscellaneous Income',     'category' => 'revenue',     'type' => 'revenue'],
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
};
