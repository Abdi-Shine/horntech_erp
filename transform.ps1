$content = Get-Content -Raw "resources\views\frontend\report\Parties_Statement_reports_bak.blade.php"

# Extract CSS
$css = ""
if ($content -match '(?s)<style>(.*?)</style>') {
    $css = $Matches[1]
}

$filteredCss = ""
$lines = $css -split "`r`n|`n"
foreach ($line in $lines) {
    if ($line -notmatch '\.sidebar' -and $line -notmatch '\.header' -and $line -notmatch '\.user' -and $line -notmatch '\.main-content' -and $line -notmatch '@media' -and $line -notmatch 'body \{' -and $line -notmatch '\* \{' -and $line -notmatch ':root \{') {
        $filteredCss += $line + "`n"
    }
}

# Adding root variables back that are useful just in case:
$filteredCss = @"
        :root {
            --primary-color: #004161;
            --secondary-color: #99CC33;
            --primary-dark: #002d47;
        }

"@ + $filteredCss

# Extract main content
$mainContent = ""
if ($content -match '(?s)<main class="main-content">(.*?)</main>') {
    $mainContent = $Matches[1]
}

$newContent = @"
@extends('admin.admin_master')

@push('css')
<style>
$filteredCss
</style>
@endpush

@section('admin')
<div class="page-content">
$mainContent
</div>
@endsection
"@

Set-Content -Path "resources\views\frontend\report\Parties_Statement_reports.blade.php" -Value $newContent -Encoding UTF8
