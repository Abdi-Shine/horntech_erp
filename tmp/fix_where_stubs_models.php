<?php

$files = [
    'd:/Bilkheyr/_ide_helper.php',
    'd:/Bilkheyr/_ide_helper_models.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        $content = preg_replace('/@param\s+([^\n]+\$column)/m', '@param \Closure|array|string|\Illuminate\Contracts\Database\Query\Expression $column', $content);
        
        $content = str_replace('public static function where($column', 'public static function where(\Closure|array|string|\Illuminate\Contracts\Database\Query\Expression $column', $content);
        $content = str_replace('public function where($column', 'public function where(\Closure|array|string|\Illuminate\Contracts\Database\Query\Expression $column', $content);
        
        file_put_contents($file, $content);
        echo "Patched $file\n";
    }
}
