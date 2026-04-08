<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('purchase_orders', 'company_id')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable()->after('id');
            });

            // Back-fill existing rows using the supplier's company_id or the first company
            $firstCompanyId = DB::table('companies')->value('id');
            if ($firstCompanyId) {
                DB::table('purchase_orders')->whereNull('company_id')->update(['company_id' => $firstCompanyId]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('purchase_orders', 'company_id')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->dropColumn('company_id');
            });
        }
    }
};
