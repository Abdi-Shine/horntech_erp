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
        Schema::create('store_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->string('transfer_no')->unique();
            $table->string('type')->default('inter-store');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('from_store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('to_store_id')->constrained('stores')->onDelete('cascade');
            $table->integer('quantity');
            $table->enum('status', ['pending', 'approved', 'completed', 'rejected'])->default('pending');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_transfers');
    }
};
