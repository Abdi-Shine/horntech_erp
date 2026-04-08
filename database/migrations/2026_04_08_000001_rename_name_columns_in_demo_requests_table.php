<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('demo_requests', function (Blueprint $table) {
            if (Schema::hasColumn('demo_requests', 'first_name')) {
                $table->renameColumn('first_name', 'full_name');
            }
            if (Schema::hasColumn('demo_requests', 'last_name')) {
                $table->dropColumn('last_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('demo_requests', function (Blueprint $table) {
            if (Schema::hasColumn('demo_requests', 'full_name')) {
                $table->renameColumn('full_name', 'first_name');
            }
            if (!Schema::hasColumn('demo_requests', 'last_name')) {
                $table->string('last_name')->after('first_name')->default('');
            }
        });
    }
};
