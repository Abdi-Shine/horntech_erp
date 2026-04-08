<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AuditLog;

$logs = AuditLog::all();

foreach ($logs as $log) {
    if (!$log->user_agent) {
        $log->update(['browser' => 'System', 'os' => 'System', 'device' => 'Server']);
        continue;
    }

    $userAgent = $log->user_agent;
    
    // Browser
    $browser = 'Unknown';
    if (str_contains($userAgent, 'MSIE') || str_contains($userAgent, 'Trident')) $browser = 'Internet Explorer';
    elseif (str_contains($userAgent, 'Edge')) $browser = 'Edge';
    elseif (str_contains($userAgent, 'Firefox')) $browser = 'Firefox';
    elseif (str_contains($userAgent, 'Chrome')) $browser = 'Chrome';
    elseif (str_contains($userAgent, 'Safari')) $browser = 'Safari';
    elseif (str_contains($userAgent, 'Opera') || str_contains($userAgent, 'OPR')) $browser = 'Opera';

    // OS
    $os = 'Unknown';
    if (str_contains($userAgent, 'Windows')) $os = 'Windows';
    elseif (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) $os = 'iOS';
    elseif (str_contains($userAgent, 'Android')) $os = 'Android';
    elseif (str_contains($userAgent, 'Macintosh')) $os = 'macOS';
    elseif (str_contains($userAgent, 'Linux')) $os = 'Linux';

    // Device
    $device = 'Desktop';
    if (str_contains($userAgent, 'Mobi')) $device = 'Mobile';
    elseif (str_contains($userAgent, 'Tablet') || str_contains($userAgent, 'iPad')) $device = 'Tablet';
    
    $log->update([
        'browser' => $browser,
        'os' => $os,
        'device' => $device
    ]);
}

echo "Backfill completed for " . $logs->count() . " logs.\n";
