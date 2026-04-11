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
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'auto_backup_enabled')) {
                $table->boolean('auto_backup_enabled')->default(false);
            }
            if (!Schema::hasColumn('companies', 'backup_time')) {
                $table->string('backup_time', 5)->default('02:00');
            }
            if (!Schema::hasColumn('companies', 'backup_retention')) {
                $table->unsignedSmallInteger('backup_retention')->default(30);
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['auto_backup_enabled', 'backup_time', 'backup_retention']);
        });
    }
};
