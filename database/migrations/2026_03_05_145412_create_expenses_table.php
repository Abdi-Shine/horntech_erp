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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->unsignedBigInteger('expense_account_id')->nullable();
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
      
            
            $table->string('expense_name');
            $table->text('description')->nullable();
            $table->string('reference_no')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            
            $table->date('expense_date')->nullable();
            $table->string('status')->default('Paid');
            $table->string('receipt')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
