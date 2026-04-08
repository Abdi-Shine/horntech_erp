<?php
$path = 'd:/Horntech/resources/views/admin/body/sidebar.blade.php';
$lines = file($path);
$newLines = [];
$skipCount = 0;
foreach ($lines as $i => $line) {
    if ($skipCount > 0) {
        $skipCount--;
        continue;
    }
    // Search for Company::first() around line 20
    if (strpos($line, 'Company::first()') !== false && isset($lines[$i-1]) && strpos($lines[$i-1], '@php') !== false) {
        // We found it. We need to remove the @php before, the line itself, and the @endphp after.
        array_pop($newLines); // remove @php
        $skipCount = 1; // skip @endphp
        continue;
    }
    $newLines[] = $line;
}
file_put_contents($path, implode('', $newLines));
echo "SUCCESS";
?>
