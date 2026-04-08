<?php

$dir = 'd:/Bilkheyr/app/Http/Controllers';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$count = 0;

foreach ($files as $file) {
    if ($file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        
        // Search for ->where(function or ->orWhere(function
        // and add /** @disregard P0406 */ above the line if not already there
        
        $lines = explode("\n", $content);
        $newLines = [];
        $changed = false;
        
        foreach ($lines as $i => $line) {
            // Check if current line contains where(function or orWhere(function
            if (preg_match('/->(?:where|orWhere|when)\s*\(\s*(?:function|fn)\s*\(/i', $line)) {
                
                // Ensure the previous line wasn't already a disregard
                $prev = $i > 0 ? trim($lines[$i - 1]) : '';
                if (strpos($prev, '@disregard P0406') === false && strpos($prev, '@disregard') === false) {
                    
                    // calculate indentation
                    preg_match('/^(\s*)/', $line, $matches);
                    $indent = $matches[1] ?? '';
                    
                    $newLines[] = $indent . '/** @disregard P0406 */';
                    $changed = true;
                    $count++;
                }
            }
            $newLines[] = $line;
        }
        
        if ($changed) {
            file_put_contents($path, implode("\n", $newLines));
            echo "Patched: " . basename($path) . "\n";
        }
    }
}

echo "Total suppressions added: $count\n";
