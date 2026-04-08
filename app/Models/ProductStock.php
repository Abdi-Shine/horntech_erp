<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property int|null $branch_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductStock extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


}
