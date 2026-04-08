<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

/**
 * @property int $id
 * @property int|null $company_id
 * @property int|null $user_id
 * @property int|null $branch_id
 * @property string $module
 * @property string $action
 * @property string|null $description
 * @property string|null $record_type
 * @property int|null $record_id
 * @property array<array-key, mixed>|null $old_values
 * @property array<array-key, mixed>|null $new_values
 * @property string|null $ip_address
 * @property string|null $device
 * @property string|null $mac
 * @property string|null $os
 * @property string|null $browser
 * @property string|null $isp
 * @property string|null $city
 * @property string|null $country
 * @property string|null $user_agent
 * @property string|null $url
 * @property string|null $method
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereIsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereMac($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereRecordType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserId($value)
 * @mixin \Eloquent
 */
class AuditLog extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'company_id',
        'user_id',
        'branch_id',
        'module',
        'action',
        'description',
        'record_type',
        'record_id',
        'old_values',
        'new_values',
        'ip_address',
        'device',
        'mac',
        'os',
        'browser',
        'isp',
        'city',
        'country',
        'user_agent',
        'url',
        'method',
        'status'
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public static function log($module, $description, $action = 'UPDATE', $status = 'success', $details = [])
    {
        $user = auth()->user();
        $userAgent = request()->userAgent();
        
        // Simple User Agent Parsing
        $browser = 'Unknown';
        if (str_contains($userAgent, 'MSIE') || str_contains($userAgent, 'Trident')) $browser = 'Internet Explorer';
        elseif (str_contains($userAgent, 'Edge')) $browser = 'Edge';
        elseif (str_contains($userAgent, 'Firefox')) $browser = 'Firefox';
        elseif (str_contains($userAgent, 'Chrome')) $browser = 'Chrome';
        elseif (str_contains($userAgent, 'Safari')) $browser = 'Safari';
        elseif (str_contains($userAgent, 'Opera') || str_contains($userAgent, 'OPR')) $browser = 'Opera';

        $os = 'Unknown';
        if (str_contains($userAgent, 'Windows')) $os = 'Windows';
        elseif (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) $os = 'iOS';
        elseif (str_contains($userAgent, 'Android')) $os = 'Android';
        elseif (str_contains($userAgent, 'Macintosh')) $os = 'macOS';
        elseif (str_contains($userAgent, 'Linux')) $os = 'Linux';

        $device = 'Desktop';
        if (str_contains($userAgent, 'Mobi')) $device = 'Mobile';
        elseif (str_contains($userAgent, 'Tablet') || str_contains($userAgent, 'iPad')) $device = 'Tablet';

        $ip = request()->ip();
        $city = 'Unknown';
        $country = 'Unknown';
        $isp = 'Unknown';

        if ($ip == '127.0.0.1' || $ip == '::1') {
            $city = 'Local';
            $country = 'Local';
            $isp = 'Localhost';
        }

        return self::create([
            'company_id' => $user?->company_id ?? (\App\Models\Company::first()?->id),
            'user_id' => $user?->id,
            'branch_id' => $user?->branch_id ?? session('branch_id'),
            'module' => $module,
            'description' => $description,
            'action' => $action,
            'status' => $status,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'browser' => $browser,
            'os' => $os,
            'device' => $device,
            'city' => $city,
            'country' => $country,
            'isp' => $isp,
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'record_type' => $details['record_type'] ?? null,
            'record_id' => $details['record_id'] ?? null,
            'old_values' => $details['old_values'] ?? null,
            'new_values' => $details['new_values'] ?? null,
        ]);
    }
}
