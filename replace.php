<?php
$files = [
    'resources/views/frontend/parties/pdf_vender_statement.blade.php',
    'resources/views/frontend/parties/vender_statement.blade.php'
];

foreach ($files as $f) {
    if (!file_exists($f)) continue;
    $c = file_get_contents($f);

    $c = str_replace('$customer', '$vendor', $c);
    $c = str_replace('Customer Statement', 'Vendor Statement', $c);
    $c = str_replace('Customer Details', 'Vendor Details', $c);
    $c = str_replace('CUS-', 'VEN-', $c);
    $c = str_replace('customer-card', 'vendor-card', $c);
    $c = str_replace('customer-name', 'vendor-name', $c);
    $c = str_replace('->orders', '->purchases', $c);
    $c = str_replace("route('email.statement.customer'", "route('email.statement.vendor'", $c);
    $c = str_replace("route('download.statement.customer'", "route('download.statement.vendor'", $c);
    $c = str_replace("route('customer.index'", "route('vendor.index'", $c);

    file_put_contents($f, $c);
    echo "Replaced in $f\n";
}
