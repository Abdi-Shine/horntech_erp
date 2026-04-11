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
        // Use raw ALTER TABLE to avoid doctrine/dbal issues on shared hosting
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('demo_requests');
        $nullable = ['job_title', 'industry', 'company_size', 'country', 'preferred_date', 'preferred_time', 'message', 'notes'];
        foreach ($nullable as $col) {
            if (in_array($col, $columns)) {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE `demo_requests` MODIFY `{$col}` TEXT NULL DEFAULT NULL");
            }
        }
    }

    public function down(): void
    {
        // intentionally left blank — reverting nullable is not safe
    }
};
