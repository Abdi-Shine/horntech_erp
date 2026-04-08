<?php
$dir = 'd:\Bilkheyr\app\Http\Controllers';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($files as $file) {
    if ($file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        
        if (preg_match_all('/\\\\App\\\\Models\\\\([a-zA-Z0-9_]+)/', $content, $matches)) {
            $classes = array_unique($matches[1]);
            
            // Replace \App\Models\ClassName with ClassName
            $newContent = preg_replace('/\\\\App\\\\Models\\\\([a-zA-Z0-9_]+)/', '$1', $content);
            
            // Ensure use statement exists
            foreach ($classes as $class) {
                if (!preg_match("/use\s+App\\\\Models\\\\$class;/", $newContent)) {
                    // Inject after namespace
                    $newContent = preg_replace(
                        '/(namespace\s+[A-Za-z0-9_\\\\]+;)/', 
                        "$1\nuse App\\Models\\$class;", 
                        $newContent,
                        1
                    );
                }
            }
            
            if ($content !== $newContent) {
                file_put_contents($path, $newContent);
                echo "Processed: $path\n";
            }
        }
    }
}
