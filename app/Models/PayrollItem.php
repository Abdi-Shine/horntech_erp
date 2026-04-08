<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $payroll_id
 * @property int $employee_id
 * @property numeric $basic_salary
 * @property numeric $bonus
 * @property numeric $overtime
 * @property numeric $deductions
 * @property numeric $gross_salary
 * @property numeric $net_salary
 * @property string $status
 * @property string|null $payment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Payroll $payroll
 * @property-read \App\Models\Employee $employee
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollItem query()
 * @mixin \Eloquent
 */
class PayrollItem extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
