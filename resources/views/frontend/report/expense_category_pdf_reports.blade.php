<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Category Report — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 portrait; margin: 10mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; background: #fff; }

        .header { padding: 15px 20px; border-bottom: 2px solid #004161; margin-bottom: 15px; }
        .company-name { font-size: 16px; font-weight: 800; color: #004161; }
        .report-title { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 2px; }
        .report-meta { float: right; text-align: right; }
        .report-meta p { font-size: 8px; color: #64748b; margin-top: 1px; }

        .clear { clear: both; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        thead tr { background: #004161; }
        thead th { padding: 8px; text-align: left; font-size: 8px; font-weight: 800; color: #fff; text-transform: uppercase; }
        thead th.right { text-align: right; }
        thead th.center { text-align: center; }

        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 8px; font-size: 9px; color: #334155; }
        tbody td.right { text-align: right; }
        tbody td.bold { font-weight: 700; color: #004161; }
        tbody td.red { color: #dc2626; font-weight: 700; }

        tfoot tr { background: #f1f5f9; border-top: 2px solid #004161; }
        tfoot td { padding: 10px 8px; font-size: 10px; font-weight: 800; color: #004161; }

        .footer { position: fixed; bottom: 0; width: 100%; padding: 10px 0; border-top: 1px solid #e2e8f0; font-size: 7px; color: #94a3b8; text-align: center; }

        .logo-wrap { float: left; margin-right: 12px; }
        .logo-img { height: 40px; width: 40px; border-radius: 4px; }
        .logo-initial { width: 40px; height: 40px; border-radius: 4px; background: #004161; color: #fff; font-size: 20px; font-weight: 900; text-align: center; line-height: 40px; display: inline-block; }
    </style>
</head>
<body>

    <div class="header">
        <div class="report-meta">
            <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($filters['from_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($filters['to_date'])->format('d M Y') }}</p>
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
        </div>
        <div>
            @php
                $logoBase64 = null;
                if ($company && $company->logo) {
                    $logoPath = public_path('uploads/company/' . $company->logo);
                    if (file_exists($logoPath)) {
                        $ext = pathinfo($logoPath, PATHINFO_EXTENSION);
                        $logoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($logoPath));
                    }
                }
            @endphp
            @if($logoBase64)
                <div class="logo-wrap"><img src="{{ $logoBase64 }}" class="logo-img"></div>
            @else
                <div class="logo-initial">{{ strtoupper(substr($company->name ?? 'C', 0, 1)) }}</div>
            @endif
            <div style="float: left;">
                <div class="company-name">{{ $company->name ?? 'Company Name' }}</div>
                <div class="report-title">Expense Category Report</div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;" class="center">#</th>
                <th>Category Name</th>
                <th>Code</th>
                <th class="center">Transactions</th>
                <th class="right">Total Amount</th>
                <th class="right">Share %</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $index => $row)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="bold">{{ $row->category_name }}</td>
                <td>{{ $row->category_code }}</td>
                <td class="center">{{ $row->transaction_count }}</td>
                <td class="right red">{{ number_format($row->total_amount, 2) }}</td>
                <td class="right">
                    {{ $totalExpense > 0 ? number_format(($row->total_amount / $totalExpense) * 100, 1) : 0 }}%
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">SUMMARY TOTALS</td>
                <td class="center">{{ number_format($reportData->sum('transaction_count')) }}</td>
                <td style="text-align: right; color: #dc2626;">{{ number_format($totalExpense, 2) }}</td>
                <td style="text-align: right;">100%</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        {{ $company->name ?? 'Company' }} — Expense Category Analysis — Confidential
    </div>

</body>
</html>

