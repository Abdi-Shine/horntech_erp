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
        Schema::table('demo_requests', function (Blueprint $table) {
            $table->string('job_title')->nullable()->default(null)->change();
            $table->string('industry')->nullable()->default(null)->change();
            $table->string('company_size')->nullable()->default(null)->change();
            $table->string('country')->nullable()->default(null)->change();
            $table->date('preferred_date')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('demo_requests', function (Blueprint $table) {
            $table->string('job_title')->nullable(false)->change();
            $table->string('industry')->nullable(false)->change();
            $table->string('company_size')->nullable(false)->change();
            $table->string('country')->nullable(false)->change();
            $table->date('preferred_date')->nullable(false)->change();
        });
    }
};
