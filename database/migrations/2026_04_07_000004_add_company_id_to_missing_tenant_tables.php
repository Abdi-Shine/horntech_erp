<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $firstCompanyId = DB::table('companies')->value('id');

        $tables = ['purchase_expenses', 'purchase_order_items', 'purchase_return_items', 'chart_of_accounts'];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'company_id')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->unsignedBigInteger('company_id')->nullable()->after('id');
                });

                if ($firstCompanyId) {
                    DB::table($table)->whereNull('company_id')->update(['company_id' => $firstCompanyId]);
                }
            }
        }
    }

    public function down(): void
    {
        $tables = ['purchase_expenses', 'purchase_order_items', 'purchase_return_items', 'chart_of_accounts'];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'company_id')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('company_id');
                });
            }
        }
    }
};
