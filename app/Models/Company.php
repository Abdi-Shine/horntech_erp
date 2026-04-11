<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $registration_number
 * @property string|null $logo
 * @property string|null $address
 * @property string|null $country
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property numeric $par_value
 * @property string $currency
 * @property string|null $tax_id
 * @property string|null $industry
 * @property string|null $base_currency
 * @property string|null $fiscal_year_start
 * @property string|null $fiscal_year_end
 * @property numeric $max_discount_percent
 * @property int $round_invoice
 * @property int $allow_negative_inventory
 * @property int $track_expiry
 * @property string $costing_method
 * @property string|null $default_uom_id
 * @property string $barcode_type
 * @property int $enable_barcode
 * @property int $force_2fa
 * @property int $log_overrides
 * @property int $maintenance_mode
 * @property int $enable_api
 * @property int $auto_backup_enabled
 * @property int $backup_retention
 * @property string $backup_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Branch> $branches
 * @property-read int|null $branches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shareholder> $shareholders
 * @property-read int|null $shareholders_count
 * @property-read \App\Models\Subscription|null $subscription
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
