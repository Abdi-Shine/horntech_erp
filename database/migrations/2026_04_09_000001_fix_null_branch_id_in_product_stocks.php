<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For each company, assign its first branch to any product_stocks with NULL branch_id
        $companies = DB::table('companies')->pluck('id');

        foreach ($companies as $companyId) {
            $firstBranchId = DB::table('branches')
                ->where('company_id', $companyId)
                ->value('id');

            if (!$firstBranchId) continue;

            DB::table('product_stocks')
                ->where('company_id', $companyId)
                ->whereNull('branch_id')
                ->update(['branch_id' => $firstBranchId]);
        }
    }

    public function down(): void
    {
        // Not reversible — we don't know which were originally NULL
    }
};
