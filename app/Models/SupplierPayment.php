<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $voucher_no
 * @property string $payment_date
 * @property int $supplier_id
 * @property int|null $bank_account_id
 * @property string $payment_method
 * @property numeric $amount
 * @property string|null $reference
 * @property string|null $notes
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $bankAccount
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupplierPaymentDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereVoucherNo($value)
 * @mixin \Eloquent
 */
class SupplierPayment extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(Account::class, 'bank_account_id');
    }

    public function details()
    {
        return $this->hasMany(SupplierPaymentDetail::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
