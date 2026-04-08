<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;

/**
 * @property int $id
 * @property string $receipt_no
 * @property string $payment_date
 * @property int $customer_id
 * @property int|null $bank_account_id
 * @property string|null $invoice_no
 * @property string $payment_method
 * @property numeric $amount
 * @property string|null $notes
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\Account|null $bankAccount
 * @property-read User|null $creator
 * @property-read Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentIn extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bankAccount()
    {
        return $this->belongsTo(Account::class, 'bank_account_id');
    }
}
