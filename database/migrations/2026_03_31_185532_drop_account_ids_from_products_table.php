<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $columns = ['inventory_account_id', 'Sales_Revenue_id', 'cogs_account_id'];

        foreach ($columns as $column) {
            if (!Schema::hasColumn('products', $column)) {
                continue;
            }

            // Safely drop FK if it exists
            $fk = DB::selectOne("
                SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'products'
                  AND COLUMN_NAME = ?
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$column]);

            if ($fk) {
                DB::statement("ALTER TABLE `products` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
            }

            Schema::table('products', function (Blueprint $table) use ($column) {
                $table->dropColumn($column);
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('inventory_account_id')->nullable()->constrained('chart_of_accounts')->onDelete('set null');
            $table->foreignId('Sales_Revenue_id')->nullable()->constrained('chart_of_accounts')->onDelete('set null');
            $table->foreignId('cogs_account_id')->nullable()->constrained('chart_of_accounts')->onDelete('set null');
        });
    }
};
