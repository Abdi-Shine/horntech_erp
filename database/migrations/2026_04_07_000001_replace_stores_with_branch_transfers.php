<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop store-dependent tables first (FK order)
        Schema::dropIfExists('store_transfers');

        // Create branch_transfers table
        if (!Schema::hasTable('branch_transfers')) {
            Schema::create('branch_transfers', function (Blueprint $table) {
                $table->id();
                $table->string('transfer_no')->unique();
                $table->unsignedBigInteger('company_id');
                $table->foreignId('from_branch_id')->constrained('branches')->onDelete('cascade');
                $table->foreignId('to_branch_id')->constrained('branches')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->integer('quantity');
                $table->enum('status', ['pending', 'completed', 'rejected'])->default('pending');
                $table->unsignedBigInteger('requested_by')->nullable();
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->text('remarks')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();

                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            });
        }

        // Helper: drop FK if it exists (MySQL INFORMATION_SCHEMA check)
        $dropFKIfExists = function (string $table, string $column) {
            $fk = DB::selectOne("
                SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = ?
                  AND COLUMN_NAME = ?
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$table, $column]);
            if ($fk) {
                DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
            }
        };

        // Tables that had store_id columns
        $tables = ['product_stocks', 'sales_orders', 'purchase_orders', 'purchase_bills', 'purchase_returns', 'stock_movements'];

        foreach ($tables as $tbl) {
            if (Schema::hasColumn($tbl, 'store_id')) {
                $dropFKIfExists($tbl, 'store_id');
                DB::statement("ALTER TABLE `{$tbl}` DROP COLUMN `store_id`");
            }
        }

        // Drop stores table last (disable FK checks in case anything still references it)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('stores');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_transfers');
    }
};
