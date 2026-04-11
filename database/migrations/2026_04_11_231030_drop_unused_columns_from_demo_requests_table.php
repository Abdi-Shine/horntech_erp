<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = Schema::getColumnListing('demo_requests');

        $drop = ['job_title', 'industry', 'company_size', 'country', 'preferred_date', 'preferred_time', 'areas_of_interest', 'notes'];

        foreach ($drop as $col) {
            if (in_array($col, $columns)) {
                DB::unprepared("ALTER TABLE `demo_requests` DROP COLUMN `{$col}`");
            }
        }
    }

    public function down(): void
    {
        // intentionally left blank — columns are not needed
    }
};
