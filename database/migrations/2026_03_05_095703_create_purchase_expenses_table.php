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
     Schema::create('purchase_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id'); // Link to purchases
            $table->unsignedBigInteger('expense_account_id'); // Chart of account
            $table->string('expense_name');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->date('expense_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['paid'])->default('paid');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('purchase_id')->references('id')->on('purchase_bills')->onDelete('cascade');
            $table->foreign('expense_account_id')->references('id')->on('chart_of_accounts');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
            $table->foreign('bank_account_id')->references('id')->on('chart_of_accounts')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_expenses');
    }
};
