<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $return_number
 * @property int $purchase_bill_id
 * @property int $supplier_id
 * @property int $branch_id
 * @property int|null $store_id
 * @property string $return_date
 * @property string|null $reason
 * @property numeric $subtotal
 * @property numeric $tax
 * @property numeric $total_amount
 * @property string $status
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PurchaseBill $bill
 * @property-read \App\Models\Branch $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseReturnItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Store|null $store
 * @property-read \App\Models\Supplier $supplier
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn wherePurchaseBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReturnNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchaseReturn extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function bill()
    {
        return $this->belongsTo(PurchaseBill::class, 'purchase_bill_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseReturnItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
