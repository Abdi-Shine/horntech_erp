<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('purchase_returns', 'company_id')) {
            Schema::table('purchase_returns', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable()->after('id');
            });

            $firstCompanyId = DB::table('companies')->value('id');
            if ($firstCompanyId) {
                DB::table('purchase_returns')->whereNull('company_id')->update(['company_id' => $firstCompanyId]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('purchase_returns', 'company_id')) {
            Schema::table('purchase_returns', function (Blueprint $table) {
                $table->dropColumn('company_id');
            });
        }
    }
};
