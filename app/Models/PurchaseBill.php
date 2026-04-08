<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $company_id
 * @property string $bill_number
 * @property string|null $supplier_invoice_no
 * @property int $supplier_id
 * @property int|null $payment_account_id
 * @property int|null $branch_id
 * @property int|null $store_id
 * @property string $bill_date
 * @property string|null $due_date
 * @property string|null $payment_terms
 * @property numeric $subtotal
 * @property numeric $vat
 * @property numeric $total_amount
 * @property numeric $paid_amount
 * @property numeric $balance_amount
 * @property string|null $notes
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseBillItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupplierPaymentDetail> $paymentDetails
 * @property-read int|null $payment_details_count
 * @property-read \App\Models\Store|null $store
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereBalanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereBillDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereBillNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill wherePaymentAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereSupplierInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereVat($value)
 * @mixin \Eloquent
 */
class PurchaseBill extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseBillItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function paymentDetails()
    {
        return $this->hasMany(SupplierPaymentDetail::class);
    }
}
