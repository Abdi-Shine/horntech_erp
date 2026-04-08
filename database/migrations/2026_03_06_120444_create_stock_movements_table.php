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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('store_id')->nullable()->constrained();
            $table->decimal('quantity', 15, 2); // Signed: + for in, - for out
            $table->string('type'); // purchase, sale, return, transfer, adjustment
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            $table->decimal('balance_after', 15, 2);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index(['reference_id', 'reference_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
