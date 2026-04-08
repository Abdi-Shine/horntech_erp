<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $business_type
 * @property string|null $legal_form
 * @property string|null $registration_number
 * @property string|null $vat_number
 * @property string|null $logo
 * @property string|null $establishing_year
 * @property string|null $registered_office
 * @property string|null $address
 * @property string|null $country
 * @property string|null $city
 * @property string|null $region
 * @property string|null $postal_box
 * @property string|null $postal_code
 * @property string|null $phone
 * @property string|null $mobile_number
 * @property string|null $email
 * @property string|null $website
 * @property string|null $facebook_page
 * @property string|null $whatsapp_number
 * @property numeric $total_share_capital
 * @property numeric $par_value
 * @property string $currency
 * @property string|null $tagline
 * @property string|null $tax_id
 * @property string|null $license_number
 * @property string|null $industry
 * @property int|null $employee_count
 * @property string|null $base_currency
 * @property string|null $exchange_rate_method
 * @property int $auto_exchange_rate
 * @property string|null $fiscal_year_start
 * @property string|null $fiscal_year_end
 * @property string|null $default_payment_method
 * @property string|null $default_bank_account
 * @property int $multiple_payment_methods
 * @property numeric $max_discount_percent
 * @property string|null $rounding_method
 * @property int $enable_discount
 * @property int $round_invoice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Branch> $branches
 * @property-read int|null $branches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shareholder> $shareholders
 * @property-read int|null $shareholders_count
 * @property-read \App\Models\Subscription|null $subscription
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAutoExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBaseCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDefaultBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDefaultPaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEmployeeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEnableDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEstablishingYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereExchangeRateMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFacebookPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFiscalYearEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFiscalYearStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLegalForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMaxDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMultiplePaymentMethods($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereParValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePostalBox($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRegisteredOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRoundInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRoundingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTagline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTotalShareCapital($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereVatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWhatsappNumber($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function shareholders(): HasMany
    {
        return $this->hasMany(Shareholder::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
