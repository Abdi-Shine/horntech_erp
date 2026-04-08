<?php

$files = [
    'd:/Bilkheyr/_ide_helper.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // We will look for where( function and add \Closure| to its first argument if it isn't there.
        // E.g., @param \Illuminate\Contracts\Database\Query\Expression|string $column
        // to @param \Closure|\Illuminate\Contracts\Database\Query\Expression|string $column
        
        $content = preg_replace('/@param\s+([^\s]+)\s+\$column/', '@param \Closure|array|$1 $column', $content);
        
        // Also look for method signature: public static function where($column
        $content = str_replace('public static function where($column', 'public static function where(\Closure|array|string $column', $content);
        $content = str_replace('public function where($column', 'public function where(\Closure|array|string $column', $content);
        
        file_put_contents($file, $content);
        echo "Patched $file\n";
    }
}
