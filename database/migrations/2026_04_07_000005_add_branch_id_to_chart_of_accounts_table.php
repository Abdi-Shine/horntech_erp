<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('chart_of_accounts', 'branch_id')) {
            Schema::table('chart_of_accounts', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('company_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('chart_of_accounts', 'branch_id')) {
            Schema::table('chart_of_accounts', function (Blueprint $table) {
                $table->dropColumn('branch_id');
            });
        }
    }
};
