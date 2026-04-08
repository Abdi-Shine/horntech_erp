<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $category
 * @property string $type
 * @property string|null $bank_name
 * @property string|null $branch_name
 * @property string|null $account_number
 * @property string|null $iban
 * @property string|null $swift_code
 * @property string $currency
 * @property int|null $branch_id
 * @property int|null $parent_id
 * @property numeric $balance
 * @property string|null $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\Branch|null $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JournalItem> $journalItems
 * @property-read int|null $journal_items_count
 * @property-read Account|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereSwiftCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'chart_of_accounts';
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function journalItems()
    {
        return $this->hasMany(JournalItem::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


}
