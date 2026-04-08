<?php

namespace App\Models;

use App\Models\Account;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $journal_entry_id
 * @property int $account_id
 * @property string|null $description
 * @property numeric $debit
 * @property numeric $credit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Account $account
 * @property-read \App\Models\JournalEntry $entry
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereJournalEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JournalItem extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            $item->modifyAccountBalance($item->account_id, $item->debit, $item->credit, 'add');
        });

        static::updated(function ($item) {
            // If account_id changed, subtract from the OLD account and add to the NEW one
            if ($item->isDirty('account_id')) {
                $item->modifyAccountBalance($item->getOriginal('account_id'), $item->getOriginal('debit'), $item->getOriginal('credit'), 'subtract');
                $item->modifyAccountBalance($item->account_id, $item->debit, $item->credit, 'add');
            } else {
                // Same account, just update the difference
                $item->modifyAccountBalance($item->account_id, $item->getOriginal('debit'), $item->getOriginal('credit'), 'subtract');
                $item->modifyAccountBalance($item->account_id, $item->debit, $item->credit, 'add');
            }
        });

        static::deleted(function ($item) {
            $item->modifyAccountBalance($item->account_id, $item->debit, $item->credit, 'subtract');
        });
    }

    protected function modifyAccountBalance($accountId, $debit, $credit, $action)
    {
        $account = Account::find($accountId);
        if (!$account) return;

        // Normal balance rules:
        //   Assets / Expenses / Contra-Revenue  → debit increases, credit decreases
        //   Liabilities / Equity / Revenue       → credit increases, debit decreases
        $normalDebit = in_array($account->category, ['assets', 'expenses'])
                    || $account->type === 'contra_revenue';

        $amount = $normalDebit ? ($debit - $credit) : ($credit - $debit);

        if ($action === 'add') {
            $account->balance += $amount;
        } else {
            $account->balance -= $amount;
        }
        
        $account->save();
    }

    public function entry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
