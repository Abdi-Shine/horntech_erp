<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $transfer_no
 * @property string $type
 * @property int $product_id
 * @property int $from_store_id
 * @property int $to_store_id
 * @property int $quantity
 * @property string $status
 * @property int $requested_by
 * @property int|null $approved_by
 * @property string|null $remarks
 * @property string|null $approved_at
 * @property string|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\User|null $approver
 * @property-read \App\Models\Store $fromStore
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $requester
 * @property-read \App\Models\Store $toStore
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereFromStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereToStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereTransferNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StoreTransfer extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function fromStore()
    {
        return $this->belongsTo(Store::class, 'from_store_id');
    }

    public function toStore()
    {
        return $this->belongsTo(Store::class, 'to_store_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
