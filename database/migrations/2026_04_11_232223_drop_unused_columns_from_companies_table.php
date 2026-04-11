<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Columns not represented in the Company Settings form and unused in business logic
    private array $drop = [
        'business_type', 'legal_form', 'vat_number', 'establishing_year',
        'registered_office', 'region', 'postal_box', 'mobile_number',
        'facebook_page', 'whatsapp_number', 'tagline', 'license_number',
        'employee_count', 'exchange_rate_method', 'auto_exchange_rate',
        'default_payment_method', 'default_bank_account', 'multiple_payment_methods',
        'rounding_method', 'enable_discount', 'total_share_capital',
    ];

    public function up(): void
    {
        $existing = Schema::getColumnListing('companies');

        foreach ($this->drop as $col) {
            if (in_array($col, $existing)) {
                DB::unprepared("ALTER TABLE `companies` DROP COLUMN `{$col}`");
            }
        }
    }

    public function down(): void
    {
        // intentionally left blank — data was unused; restoration not needed
    }
};
