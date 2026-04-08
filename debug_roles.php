<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- CHECKING STOREKEEPER ROLE ---\n";
$roles = \App\Models\Role::all();
foreach ($roles as $r) {
    if (stripos($r->name, 'storekeeper') !== false) {
        echo "ROLE FOUND: ID=" . $r->id . " Name=[" . $r->name . "]\n";
        foreach ($r->permissions as $mod => $actions) {
            echo "Module: [" . $mod . "] | Actions: [" . implode(',', $actions) . "]\n";
        }
    }
}

echo "\n--- ALL USERS ---\n";
foreach (\App\Models\User::all() as $u) {
    echo "UID: " . $u->id . " | NAME: " . $u->name . " | ROLE: [" . $u->role . "]\n";
}
