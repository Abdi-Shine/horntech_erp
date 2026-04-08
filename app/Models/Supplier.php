<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $company_id
 * @property string $supplier_code
 * @property string $supplier_type
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property int|null $account_id
 * @property string|null $account_type
 * @property string|null $account_code
 * @property string $opening_balance_type
 * @property numeric $amount_balance
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseBill> $purchaseBills
 * @property-read int|null $purchase_bills_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupplierPayment> $supplierPayments
 * @property-read int|null $supplier_payments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAmountBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereOpeningBalanceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereSupplierCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereSupplierType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Supplier extends Model
{
    use BelongsToTenant;

    protected $table = 'suppliers';
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function purchaseBills()
    {
        return $this->hasMany(PurchaseBill::class);
    }

    public function supplierPayments()
    {
        return $this->hasMany(SupplierPayment::class);
    }
}
