<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>P&L Statement — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 portrait; margin: 10mm 15mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; background: #fff; }

        .header { padding: 14px 20px 12px; border-bottom: 3px solid #004161; display: table; width: 100%; }
        .header-cell { display: table-cell; vertical-align: top; }
        .company-name { font-size: 18px; font-weight: 800; color: #004161; margin-bottom: 2px; }
        .report-title { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        .report-meta { text-align: right; }
        .report-meta p { font-size: 10px; color: #64748b; margin-top: 3px; }

        .summary-boxes { display: table; width: 100%; border-spacing: 10px; margin: 15px -10px; }
        .summary-box { display: table-cell; background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid #004161; padding: 12px; border-radius: 4px; width: 25%; }
        .summary-label { font-size: 8px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
        .summary-val { font-size: 13px; font-weight: 900; color: #004161; }
        .box-lime { border-left-color: #99CC33 !important; }
        .box-red { border-left-color: #dc2626 !important; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f1f5f9; padding: 10px 12px; text-align: left; font-size: 10px; font-weight: 800; color: #475569; text-transform: uppercase; border-bottom: 2px solid #cbd5e1; }
        td { padding: 9px 12px; border-bottom: 1px solid #f1f5f9; }
        .text-right { text-align: right; }
        .indent { padding-left: 25px; }

        .category-header { background: #f8fafc; font-weight: 800; color: #004161; }
        .subtotal { font-weight: 700; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
        .gross-profit { background: #f0fdf4; color: #166534; font-weight: 800; font-size: 12px; }
        .net-profit { background: #f8fafc; color: #004161; border-top: 2px solid #004161; font-weight: 900; font-size: 13px; }
        
        .logo-wrap { display: inline-block; vertical-align: middle; margin-right: 12px; }
        .logo-img  { height: 48px; width: 48px; border-radius: 8px; object-fit: contain; }
        .logo-initial { width: 48px; height: 48px; border-radius: 8px; background: #004161; color: #fff; font-size: 20px; font-weight: 900; text-align: center; line-height: 48px; display: inline-block; vertical-align: middle; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-cell">
            @php
                $logoBase64 = null;
                if ($company && $company->logo) {
                    $logoPath = $company->logo;
                    if (!str_starts_with($logoPath, 'uploads/')) $logoPath = 'uploads/company/' . $logoPath;
                    $fullLogoPath = public_path($logoPath);
                    if (file_exists($fullLogoPath)) {
                        $ext = pathinfo($fullLogoPath, PATHINFO_EXTENSION);
                        $logoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($fullLogoPath));
                    }
                }
            @endphp
            @if($logoBase64)
                <span class="logo-wrap"><img src="{{ $logoBase64 }}" class="logo-img" alt="Logo"></span>
            @else
                <span class="logo-initial">{{ strtoupper(substr($company->name ?? 'C', 0, 1)) }}</span>
            @endif
            <div style="display:inline-block; vertical-align: middle;">
                <div class="company-name">{{ $company->name ?? 'Company Name' }}</div>
                <div class="report-title">Profit & Loss Statement</div>
            </div>
        </div>
        <div class="header-cell report-meta">
            <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($filters['from_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($filters['to_date'])->format('d M Y') }}</p>
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    <div class="summary-boxes">
        <div class="summary-box">
            <div class="summary-label">Revenue</div>
            <div class="summary-val">{{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="summary-box box-lime">
            <div class="summary-label">Gross Profit</div>
            <div class="summary-val" style="color: #16a34a;">{{ number_format($grossProfit, 2) }}</div>
        </div>
        <div class="summary-box box-red">
            <div class="summary-label">Expenses</div>
            <div class="summary-val" style="color: #dc2626;">{{ number_format($totalExpenses, 2) }}</div>
        </div>
        <div class="summary-box">
            <div class="summary-label">Net Profit</div>
            <div class="summary-val" style="color: #004161;">{{ number_format($netProfit, 2) }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 60%">Account</th>
                <th class="text-right">Amount ({{ $company->currency ?? 'SAR' }})</th>
                <th class="text-right">% Revenue</th>
            </tr>
        </thead>
        <tbody>
            <!-- REVENUE -->
            <tr class="category-header">
                <td>REVENUE</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td class="indent">Sales Revenue</td>
                <td class="text-right">{{ number_format($totalRevenue, 2) }}</td>
                <td class="text-right">100.0%</td>
            </tr>
            <tr class="subtotal">
                <td>Total Revenue</td>
                <td class="text-right">{{ number_format($totalRevenue, 2) }}</td>
                <td class="text-right">100.0%</td>
            </tr>

            <!-- COGS -->
            <tr class="category-header">
                <td>COST OF GOODS SOLD</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td class="indent">Purchases</td>
                <td class="text-right">{{ number_format($totalCogs, 2) }}</td>
                <td class="text-right">{{ $totalRevenue > 0 ? number_format(($totalCogs/$totalRevenue)*100, 1) : 0 }}%</td>
            </tr>
            <tr class="subtotal">
                <td>Total COGS</td>
                <td class="text-right">{{ number_format($totalCogs, 2) }}</td>
                <td class="text-right">{{ $totalRevenue > 0 ? number_format(($totalCogs/$totalRevenue)*100, 1) : 0 }}%</td>
            </tr>

            <!-- GROSS PROFIT -->
            <tr class="gross-profit">
                <td>GROSS PROFIT</td>
                <td class="text-right">{{ number_format($grossProfit, 2) }}</td>
                <td class="text-right">{{ $totalRevenue > 0 ? number_format(($grossProfit/$totalRevenue)*100, 1) : 0 }}%</td>
            </tr>

            <!-- EXPENSES -->
            <tr class="category-header">
                <td>OPERATING EXPENSES</td>
                <td colspan="2"></td>
            </tr>
            @foreach($expenseDetails as $exp)
            <tr>
                <td class="indent">{{ $exp->name }}</td>
                <td class="text-right">{{ number_format($exp->amount, 2) }}</td>
                <td class="text-right">{{ number_format($exp->percent, 1) }}%</td>
            </tr>
            @endforeach
            <tr class="subtotal">
                <td>Total Operating Expenses</td>
                <td class="text-right">{{ number_format($totalExpenses, 2) }}</td>
                <td class="text-right">{{ $totalRevenue > 0 ? number_format(($totalExpenses/$totalRevenue)*100, 1) : 0 }}%</td>
            </tr>

            <!-- NET PROFIT -->
            <tr class="net-profit">
                <td>NET PROFIT / (LOSS)</td>
                <td class="text-right">{{ number_format($netProfit, 2) }}</td>
                <td class="text-right">{{ $totalRevenue > 0 ? number_format(($netProfit/$totalRevenue)*100, 1) : 0 }}%</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; color: #94a3b8; font-size: 9px;">
        {{ $company->name ?? 'Company' }} — Financial Reports Hub — Confidential
    </div>

</body>
</html>

