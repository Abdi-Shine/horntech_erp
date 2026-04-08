<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $supplier_payment_id
 * @property int $purchase_bill_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PurchaseBill $bill
 * @property-read \App\Models\SupplierPayment $payment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail wherePurchaseBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereSupplierPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SupplierPaymentDetail extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function payment()
    {
        return $this->belongsTo(SupplierPayment::class, 'supplier_payment_id');
    }

    public function bill()
    {
        return $this->belongsTo(PurchaseBill::class, 'purchase_bill_id');
    }
}
