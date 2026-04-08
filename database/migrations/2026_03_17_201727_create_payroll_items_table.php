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
        Schema::create('payroll_items', function (Blueprint $col) {
            $col->id();
            $col->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $col->unsignedBigInteger('payroll_id');
            $col->unsignedBigInteger('employee_id');
            $col->decimal('basic_salary', 15, 2)->default(0);
            $col->decimal('bonus', 15, 2)->default(0);
            $col->decimal('overtime', 15, 2)->default(0);
            $col->decimal('deductions', 15, 2)->default(0);
            $col->decimal('gross_salary', 15, 2)->default(0);
            $col->decimal('net_salary', 15, 2)->default(0);
            $col->string('status')->default('Unpaid'); // Unpaid, Paid
            $col->date('payment_date')->nullable();
            $col->timestamps();

            // Foreign keys
            $col->foreign('payroll_id')->references('id')->on('payrolls')->onDelete('cascade');
            $col->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_items');
    }
};
