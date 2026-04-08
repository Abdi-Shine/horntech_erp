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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->string('loan_id')->unique()->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('type')->default('personal');
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('recovered', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->integer('duration')->nullable(); // months
            $table->text('reason')->nullable();
            $table->string('status')->default('pending'); // pending, active, settled, rejected
            $table->text('repayment_schedule')->nullable(); // Can store the next due date and payments as json if needed, or simply let logic compute.
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
