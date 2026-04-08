<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

/**
 * @property int $id
 * @property int|null $company_id
 * @property string $entry_number
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $reference
 * @property string|null $description
 * @property string $status
 * @property numeric $total_amount
 * @property int|null $branch_id
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JournalItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereEntryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JournalEntry extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];
    protected $casts = [
        'date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(JournalItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
