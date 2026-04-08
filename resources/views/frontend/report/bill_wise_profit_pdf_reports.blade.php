<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill-Wise Profit Report — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 landscape; margin: 8mm 10mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 8px; color: #1e293b; background: #fff; }

        .header { padding: 12px 15px; border-bottom: 3px solid #004161; display: table; width: 100%; vertical-align: middle; }
        .header-cell { display: table-cell; vertical-align: middle; }
        .company-name { font-size: 16px; font-weight: 800; color: #004161; }
        .report-title { font-size: 10px; font-weight: 700; color: #99CC33; text-transform: uppercase; margin-top: 2px; letter-spacing: 0.1em; }
        .report-meta { text-align: right; }
        .report-meta p { font-size: 8px; color: #64748b; margin-top: 2px; }

        .summary-row { display: table; width: 100%; border-collapse: separate; border-spacing: 8px 0; margin: 15px 0; }
        .summary-item { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 8px; width: 20%; border-left: 4px solid #004161; }
        .summary-label { font-size: 6px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 0.05em; }
        .summary-val { font-size: 13px; font-weight: 900; color: #004161; }
        .profit-val { color: #99CC33 !important; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #f8fafc; padding: 10px 8px; text-align: left; font-size: 7px; font-weight: 900; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; letter-spacing: 0.05em; }
        th.right { text-align: right; }
        
        td { padding: 10px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; text-align: right; font-size: 9px; }
        td.left { text-align: left; }
        td.bold { font-weight: 800; color: #004161; }
        td.profit { font-weight: 900; color: #99CC33; }
        td.cost { color: #94a3b8; font-weight: 600; }
        
        .grade-pill {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 6px;
            font-weight: 900;
            display: inline-block;
            text-transform: uppercase;
        }
        .grade-high   { background: #dcfce7; color: #16a34a; }
        .grade-medium { background: #fef9c3; color: #ca8a04; }
        .grade-low    { background: #fee2e2; color: #ef4444; }

        .total-row { background: #f8fafc; font-weight: 900; border-top: 2px solid #004161; }
        .total-row td { font-size: 10px; padding: 15px 8px; color: #004161; }

        .logo-wrap { display: inline-block; vertical-align: middle; margin-right: 12px; }
        .logo-img  { height: 40px; width: 40px; border-radius: 6px; }
        .logo-initial { width: 40px; height: 40px; border-radius: 6px; background: #004161; color: #fff; font-size: 18px; font-weight: 900; text-align: center; line-height: 40px; display: inline-block; }
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
                <div class="report-title">Bill-Wise Profitability Report</div>
            </div>
        </div>
        <div class="header-cell report-meta">
            <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($filters['from_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($filters['to_date'])->format('d M Y') }}</p>
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    @php
        function formatK($num) {
            if($num >= 1000000) return number_format($num/1000000, 1) . 'M';
            if($num >= 1000) return number_format($num/1000, 0) . 'K';
            return number_format($num, 0);
        }
    @endphp

    <!-- Summary Box -->
    <div class="summary-row">
        <div class="summary-item">
            <div class="summary-label">Total Revenue</div>
            <div class="summary-val">{{ $company->currency ?? 'SAR' }} {{ number_format($totals->revenue, 0) }}</div>
        </div>
        <div class="summary-item" style="border-left-color: #64748b;">
            <div class="summary-label">Total Cost</div>
            <div class="summary-val" style="color: #64748b;">{{ $company->currency ?? 'SAR' }} {{ number_format($totals->cost, 0) }}</div>
        </div>
        <div class="summary-item" style="border-left-color: #99CC33;">
            <div class="summary-label">Net Profit</div>
            <div class="summary-val profit-val">{{ $company->currency ?? 'SAR' }} {{ number_format($totals->profit, 0) }}</div>
        </div>
        <div class="summary-item" style="border-left-color: #3b82f6;">
            <div class="summary-label">Avg Margin</div>
            <div class="summary-val" style="color: #3b82f6;">{{ number_format($totals->avgMargin, 1) }}%</div>
        </div>
        <div class="summary-item" style="border-left-color: #8b5cf6;">
            <div class="summary-label">Records</div>
            <div class="summary-val" style="color: #8b5cf6;">{{ $totals->totalInvoices }} Bills</div>
        </div>
    </div>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 8%">Date</th>
                <th style="width: 10%">Invoice #</th>
                <th>Customer Name</th>
                <th class="right" style="width: 11%">Revenue</th>
                <th class="right" style="width: 11%">Cost</th>
                <th class="right" style="width: 10%">Expenses</th>
                <th class="right" style="width: 11%">Profit</th>
                <th class="right" style="width: 8%">Margin %</th>
                <th style="text-align: center; width: 8%">Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $row)
            <tr>
                <td class="left" style="color: #64748b;">{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</td>
                <td class="left bold">{{ $row->invoice_no }}</td>
                <td class="left" style="font-weight: 700;">{{ $row->customer }}</td>
                <td class="bold">{{ number_format($row->revenue, 2) }}</td>
                <td class="cost">{{ number_format($row->cost, 2) }}</td>
                <td class="cost" style="color: #cbd5e1;">{{ number_format($row->expenses, 2) }}</td>
                <td class="profit">{{ number_format($row->profit, 2) }}</td>
                <td class="bold">{{ number_format($row->margin, 1) }}%</td>
                <td style="text-align: center;">
                    <span class="grade-pill grade-{{ strtolower($row->grade) }}">{{ $row->grade }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">SUMMARY TOTALS</td>
                <td style="text-align: right;">{{ number_format($totals->revenue, 2) }}</td>
                <td style="text-align: right;">{{ number_format($totals->cost, 2) }}</td>
                <td style="text-align: right; color: #cbd5e1;">{{ number_format($totals->expenses, 2) }}</td>
                <td style="text-align: right; color: #99CC33;">{{ number_format($totals->profit, 2) }}</td>
                <td style="text-align: right;">{{ number_format($totals->avgMargin, 1) }}%</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; text-align: center; color: #94a3b8; font-size: 7px; font-style: italic;">
        {{ $company->name ?? 'Company' }} — Bill-Wise Profitability Analytical Report — Confidential
    </div>

</body>
</html>

