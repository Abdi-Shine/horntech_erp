<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property float $share_amount
 * @property float $ownership_percentage
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereOwnershipPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereShareAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shareholder extends Model
{
    use BelongsToTenant;

    protected $fillable = ['company_id', 'name', 'phone', 'email', 'address', 'share_amount', 'ownership_percentage', 'status'];
}
