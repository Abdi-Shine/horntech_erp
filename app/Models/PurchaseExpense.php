<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $company_id
 * @property int $purchase_id
 * @property int $expense_account_id
 * @property string $expense_name
 * @property string|null $description
 * @property numeric $amount
 * @property int|null $supplier_id
 * @property int|null $branch_id
 * @property int|null $bank_account_id
 * @property string|null $expense_date
 * @property int|null $created_by
 * @property int|null $approved_by
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\User|null $approver
 * @property-read \App\Models\Account|null $bankAccount
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\PurchaseBill $purchase
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereExpenseAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereExpenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereExpenseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchaseExpense extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function purchase()
    {
        // Assuming there might be a Purchase model, or it might link to PurchaseBill
        // For now, defining it generically or you can map it to PurchaseBill if that's the intention
        return $this->belongsTo(PurchaseBill::class, 'purchase_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'expense_account_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(Account::class, 'bank_account_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
