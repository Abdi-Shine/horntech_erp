<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $filename
 * @property string $path
 * @property string|null $size
 * @property string $type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Backup extends Model
{
    use BelongsToTenant;

    protected $guarded = [];
}
