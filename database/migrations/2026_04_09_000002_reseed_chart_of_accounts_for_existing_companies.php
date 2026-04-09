<?php

use Illuminate\Database\Migrations\Migration;
use App\Services\ChartOfAccountsService;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $service = app(ChartOfAccountsService::class);
        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            $branchId = DB::table('branches')->where('company_id', $company->id)->value('id');
            $service->seedForCompany($company->id, $branchId);
        }
    }

    public function down(): void {}
};
