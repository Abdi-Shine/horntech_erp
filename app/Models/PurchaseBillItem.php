<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $purchase_bill_id
 * @property int|null $product_id
 * @property string|null $product_name
 * @property string|null $product_code
 * @property numeric $quantity
 * @property string|null $unit
 * @property numeric $unit_price
 * @property numeric $discount
 * @property numeric $total_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PurchaseBill $bill
 * @property-read \App\Models\Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseReturnItem> $returnItems
 * @property-read int|null $return_items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem wherePurchaseBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchaseBillItem extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'company_id',
        'purchase_bill_id',
        'product_id',
        'product_name',
        'product_code',
        'quantity',
        'unit',
        'unit_price',
        'discount',
        'total_amount',
    ];

    public function bill()
    {
        return $this->belongsTo(PurchaseBill::class, 'purchase_bill_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function returnItems()
    {
        return $this->hasMany(PurchaseReturnItem::class, 'purchase_bill_item_id');
    }
}
