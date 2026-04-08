<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (\App\Models\FeatureSetting::all() as $f) {
    echo $f->feature_key . '|' . $f->title . '|' . $f->category . '|' . ($f->is_enabled ? '1' : '0') . PHP_EOL;
}
