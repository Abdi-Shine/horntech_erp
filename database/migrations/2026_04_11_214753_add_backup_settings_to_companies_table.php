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
            $table->boolean('auto_backup_enabled')->default(false);
            $table->string('backup_time', 5)->default('02:00');
            $table->unsignedSmallInteger('backup_retention')->default(30);
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['auto_backup_enabled', 'backup_time', 'backup_retention']);
        });
    }
};
