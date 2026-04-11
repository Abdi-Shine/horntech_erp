<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = Schema::getColumnListing('demo_requests');

        $targets = [
            'job_title'      => 'TEXT',
            'industry'       => 'TEXT',
            'company_size'   => 'TEXT',
            'country'        => 'TEXT',
            'preferred_date' => 'TEXT',
            'preferred_time' => 'VARCHAR(50)',
            'message'        => 'TEXT',
            'notes'          => 'TEXT',
        ];

        foreach ($targets as $col => $type) {
            if (in_array($col, $columns)) {
                DB::unprepared("ALTER TABLE `demo_requests` MODIFY `{$col}` {$type} NULL DEFAULT NULL");
            }
        }
    }

    public function down(): void
    {
        // intentionally left blank
    }
};
