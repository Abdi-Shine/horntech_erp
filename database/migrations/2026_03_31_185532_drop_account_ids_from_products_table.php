<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['inventory_account_id']);
            $table->dropForeign(['Sales_Revenue_id']);
            $table->dropForeign(['cogs_account_id']);
            $table->dropColumn(['inventory_account_id', 'Sales_Revenue_id', 'cogs_account_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('inventory_account_id')->nullable()->constrained('chart_of_accounts')->onDelete('set null');
            $table->foreignId('Sales_Revenue_id')->nullable()->constrained('chart_of_accounts')->onDelete('set null');
            $table->foreignId('cogs_account_id')->nullable()->constrained('chart_of_accounts')->onDelete('set null');
        });
    }
};
