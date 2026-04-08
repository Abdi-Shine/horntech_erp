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
        Schema::create('payrolls', function (Blueprint $col) {
            $col->id();
            $col->unsignedBigInteger('company_id')->nullable();
            $col->unsignedBigInteger('branch_id')->nullable();
            $col->string('month_year'); // e.g., 'March 2026'
            $col->integer('total_employees')->default(0);
            $col->decimal('total_gross', 15, 2)->default(0);
            $col->decimal('total_deductions', 15, 2)->default(0);
            $col->decimal('total_net', 15, 2)->default(0);
            $col->string('status')->default('Draft'); // Draft, Approved, Paid, Rejected
            $col->unsignedBigInteger('approved_by')->nullable();
            $col->date('paid_date')->nullable();
            $col->timestamps();

            // Foreign keys
            $col->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $col->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $col->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
