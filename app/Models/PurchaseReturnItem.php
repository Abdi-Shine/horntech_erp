<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $purchase_return_id
 * @property int $purchase_bill_item_id
 * @property int $product_id
 * @property numeric $quantity
 * @property numeric $unit_price
 * @property numeric $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\PurchaseReturn $purchaseReturn
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem wherePurchaseBillItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem wherePurchaseReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchaseReturnItem extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
