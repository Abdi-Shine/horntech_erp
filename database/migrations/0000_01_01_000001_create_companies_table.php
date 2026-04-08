<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_type')->nullable();
            $table->string('legal_form')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('logo')->nullable();
            $table->string('establishing_year')->nullable();
            $table->string('registered_office')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('postal_box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_page')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->decimal('total_share_capital', 15, 2)->default(0);
            $table->decimal('par_value', 10, 2)->default(10);
            $table->string('currency')->default('$');
            $table->string('tagline')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('license_number')->nullable();
            $table->string('industry')->nullable();
            $table->string('employee_count')->nullable();
            // Financial Settings
            $table->string('base_currency')->nullable();
            $table->string('exchange_rate_method')->nullable();
            $table->boolean('auto_exchange_rate')->default(false);
            $table->string('fiscal_year_start')->nullable();
            $table->string('fiscal_year_end')->nullable();
            $table->string('default_payment_method')->nullable();
            $table->string('default_bank_account')->nullable();
            $table->boolean('multiple_payment_methods')->default(true);
            $table->decimal('max_discount_percent', 5, 2)->default(100.00);
            $table->string('rounding_method')->nullable();
            $table->boolean('enable_discount')->default(true);
            $table->boolean('round_invoice')->default(false);
            // Advanced Settings
            $table->boolean('allow_negative_inventory')->default(false);
            $table->boolean('track_expiry')->default(true);
            $table->string('costing_method')->default('FIFO');
            $table->string('default_uom_id')->nullable();
            $table->string('barcode_type')->default('CODE128');
            $table->boolean('enable_barcode')->default(true);
            $table->boolean('force_2fa')->default(false);
            $table->boolean('log_overrides')->default(true);
            $table->boolean('maintenance_mode')->default(false);
            $table->boolean('enable_api')->default(false);
            // Backup settings
            $table->boolean('auto_backup_enabled')->default(true);
            $table->integer('backup_retention')->default(30);
            $table->string('backup_time')->default('02:00');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
