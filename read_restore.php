<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Backups Table - Restore Status ===\n\n";
$backups = \App\Models\Backup::latest()->get();
foreach ($backups as $b) {
    echo "ID: {$b->id} | restore_status: [" . ($b->restore_status ?? 'NULL') . "] | restored_at: [" . ($b->restored_at ?? 'NULL') . "] | filename: {$b->filename}\n";
}

echo "\n=== Marker File ===\n";
$marker = storage_path('app/last_restore.json');
echo file_exists($marker) ? file_get_contents($marker) : "No marker file found.\n";
