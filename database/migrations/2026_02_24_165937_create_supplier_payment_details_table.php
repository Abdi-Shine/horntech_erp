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
        Schema::create('supplier_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_payment_id');
            $table->unsignedBigInteger('purchase_bill_id');
            $table->decimal('amount', 15, 2);
            $table->timestamps();

            $table->foreign('supplier_payment_id')->references('id')->on('supplier_payments')->onDelete('cascade');
            $table->foreign('purchase_bill_id')->references('id')->on('purchase_bills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payment_details');
    }
};
