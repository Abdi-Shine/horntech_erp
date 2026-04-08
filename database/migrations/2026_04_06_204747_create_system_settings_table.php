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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed defaults
        $defaults = [
            'platform_name'       => 'Horntech LTD',
            'support_email'       => 'support@horntech.com',
            'trial_days'          => '14',
            'default_currency'    => 'USD',
            'evc_merchant_number' => '',
            'bank_name'           => '',
            'bank_account_name'   => '',
            'bank_account_number' => '',
            'bank_swift_code'     => '',
        ];
        foreach ($defaults as $key => $value) {
            \Illuminate\Support\Facades\DB::table('system_settings')->insert([
                'key'        => $key,
                'value'      => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
