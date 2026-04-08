<?php

$file = 'resources/views/frontend/report/Parties_statement_pdf_reports.blade.php';
$content = file_get_contents($file);

preg_match('/<style>(.*?)<\/style>/s', $content, $styleMatch);
$css = $styleMatch[1] ?? '';

// We just filter out the CSS for sidebar, header, user
$filteredCss = "";
$lines = explode("\n", $css);
foreach ($lines as $line) {
    if (
        strpos($line, '.sidebar') === false && 
        strpos($line, '.header') === false && 
        strpos($line, '.user') === false && 
        strpos($line, '.main-content') === false && 
        strpos($line, '@media (max-width') === false
    ) {
        $filteredCss .= $line . "\n";
    }
}

// Extract main content
preg_match('/<!-- Page Header -->(.*?)<\/main>/s', $content, $mainMatch);
$mainContent = rtrim($mainMatch[1] ?? '');

// Strip the buttons from the page header that we don't need in a PDF!
$mainContent = preg_replace('/<div class="d-flex gap-2 flex-wrap no-print">.*?<\/div>/s', '', $mainContent);
// Strip the filter section from the PDF completely
$mainContent = preg_replace('/<!-- Filter Section -->.*?<!-- Statement Table -->/s', '<!-- Statement Table -->', $mainContent);
// Strip the print button columns
$mainContent = preg_replace('/<th class="text-center">\s*PRINT\s*<\/th>/s', '', $mainContent);
$mainContent = preg_replace('/<td class="text-center">\s*<button.*?<\/td>/s', '', $mainContent);
// remove the extra empty td in footer
$mainContent = preg_replace('/<td><\/td>\s*<\/tr>\s*<\/tfoot>/s', "</tr>\n                        </tfoot>", $mainContent);

$pdfContent = <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Party Statement PDF - Bilkheyr POS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    $filteredCss
    
    body {
        background-color: white !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #004161;
        margin-bottom: 0.2rem;
    }
    .page-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
    }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Page Header -->
        $mainContent
    </div>
</body>
</html>
EOD;

file_put_contents('resources/views/frontend/report/Parties_statement_pdf_reports.blade.php', $pdfContent);
echo "PDF Transformation complete.\n";
