<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('backups', function (Blueprint $table) {
            $table->string('restore_status')->nullable()->after('status'); // e.g. 'restored', 'failed'
            $table->timestamp('restored_at')->nullable()->after('restore_status');
        });
    }

    public function down(): void
    {
        Schema::table('backups', function (Blueprint $table) {
            $table->dropColumn(['restore_status', 'restored_at']);
        });
    }
};
