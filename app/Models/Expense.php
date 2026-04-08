<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

/**
 * @property int $id
 * @property int|null $company_id
 * @property int|null $expense_account_id
 * @property int|null $bank_account_id
 * @property int|null $branch_id
 * @property int|null $supplier_id
 * @property string $expense_name
 * @property string|null $description
 * @property string|null $reference_no
 * @property string|null $payment_method
 * @property numeric $amount
 * @property string|null $expense_date
 * @property string $status
 * @property string|null $receipt
 * @property int|null $created_by
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Account|null $bankAccount
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereExpenseAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereExpenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereExpenseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereReferenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Expense extends Model
{
    use BelongsToTenant;
    protected $guarded = [];
    public function account()
    {
        return $this->belongsTo(Account::class, 'expense_account_id', 'id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(Account::class, 'bank_account_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
