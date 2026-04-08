<?php

$file = 'resources/views/frontend/report/party_wise_profit_Loss_reports.blade.php';
$content = file_get_contents($file);

preg_match('/<style>(.*?)<\/style>/s', $content, $styleMatch);
$css = $styleMatch[1] ?? '';

// We need to keep only targeted classes to avoid ruining other pages.
$allowedCssNames = [
    'stat-card', 'stat-icon', 'stat-value', 'stat-label',
    'filter-icon', 'profit-positive', 'profit-negative', 'badge',
    'report-footer', 'footer-item', 'footer-label', 'footer-value',
];

$finalCss = "";

// Simple css extraction block by block
preg_match_all('/([^{]+)\s*\{([^}]+)\}/s', $css, $cssBlocks, PREG_SET_ORDER);
foreach ($cssBlocks as $block) {
    $selector = trim($block[1]);
    $rules = trim($block[2]);

    $keep = false;
    foreach ($allowedCssNames as $allowed) {
        if (strpos($selector, '.' . $allowed) !== false) {
            $keep = true;
            break;
        }
    }

    if ($keep) {
        $finalCss .= "$selector {\n    $rules\n}\n\n";
    }
}

// Add variables to final CSS since they are used
$finalCss = ":root {\n    --primary-color: #004161;\n    --secondary-color: #99CC33;\n    --primary-dark: #002d47;\n}\n\n" . $finalCss;

preg_match('/<main class="main-content">(.*?)<\/main>/s', $content, $mainMatch);
$mainContent = rtrim($mainMatch[1] ?? '');

$bladeContent = <<<EOD
@extends('admin.admin_master')

@push('css')
<style>
$finalCss
</style>
@endpush

@section('admin')
<div class="page-content">
$mainContent
</div>
@endsection

EOD;

file_put_contents('resources/views/frontend/report/party_wise_profit_Loss_reports.blade.php', $bladeContent);
echo "Transformation complete.\n";
