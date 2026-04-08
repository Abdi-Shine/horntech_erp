<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Management — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 portrait; margin: 12mm 15mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; background: #fff; }

        .header { padding: 15px 20px; border-bottom: 4px solid #004161; display: table; width: 100%; }
        .header-cell { display: table-cell; vertical-align: top; }
        .company-name { font-size: 20px; font-weight: 800; color: #004161; margin-bottom: 4px; }
        .report-title { font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        .report-meta { text-align: right; }
        .report-meta p { font-size: 9.5px; color: #64748b; margin-top: 4px; }

        .summary-row { display: table; width: 100%; border-spacing: 10px; margin: 15px -10px; }
        .summary-card { display: table-cell; background: #fff; border: 1px solid #e2e8f0; border-top: 4px solid #004161; padding: 12px; border-radius: 4px; width: 25%; text-align: left; vertical-align: top; }
        .summary-label { font-size: 7px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
        .summary-val { font-size: 13px; font-weight: 900; color: #1e293b; margin-bottom: 4px; }
        .summary-footer { font-size: 7px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.02em; }
        .text-accent { color: #10b981; }
        .text-danger { color: #ef4444; }
        .text-primary { color: #004161; }
        .text-orange { color: #f97316; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        thead tr { background: #f8fafc; }
        thead th { padding: 10px 12px; text-align: left; font-size: 9px; font-weight: 800; color: #475569; text-transform: uppercase; border-bottom: 2px solid #cbd5e1; }
        tbody td { padding: 9px 12px; border-bottom: 1px solid #f1f5f9; font-size: 10px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .acc-name { color: #004161; font-weight: 700; }
        .badge { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 7px; font-weight: 800; text-transform: uppercase; color: #64748b; background: #f1f5f9; }

        .logo-wrap { display: inline-block; vertical-align: middle; margin-right: 15px; }
        .logo-img  { height: 50px; width: 50px; border-radius: 8px; object-fit: contain; }
        .logo-initial { width: 50px; height: 50px; border-radius: 8px; background: #004161; color: #fff; font-size: 20px; font-weight: 900; text-align: center; line-height: 50px; display: inline-block; vertical-align: middle; }
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
                <div class="report-title">Cash & Bank Position</div>
            </div>
        </div>
        <div class="header-cell report-meta">
            <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($filters['from_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($filters['to_date'])->format('d M Y') }}</p>
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    @php
        $totalIn   = $reportData->sum('inflow');
        $totalOut  = $reportData->sum('outflow');
        $netFlow   = $totalIn - $totalOut;
        $totalNet  = $reportData->sum('closing_balance');
    @endphp

    <div class="summary-row">
        <div class="summary-card" style="border-top-color: #10b981;">
            <div class="summary-label">Total Cash In</div>
            <div class="summary-val text-accent">{{ number_format($totalIn, 2) }}</div>
            <div class="summary-footer">Receipts</div>
        </div>
        <div class="summary-card" style="border-top-color: #ef4444;">
            <div class="summary-label">Total Cash Out</div>
            <div class="summary-val text-danger">{{ number_format($totalOut, 2) }}</div>
            <div class="summary-footer">Payments</div>
        </div>
        <div class="summary-card" style="border-top-color: {{ $netFlow >= 0 ? '#004161' : '#f97316' }};">
            <div class="summary-label">Net Cash Flow</div>
            <div class="summary-val {{ $netFlow >= 0 ? 'text-primary' : 'text-orange' }}">{{ number_format($netFlow, 2) }}</div>
            <div class="summary-footer">{{ $netFlow >= 0 ? 'Positive flow' : 'Negative flow' }}</div>
        </div>
        <div class="summary-card" style="border-top-color: #004161;">
            <div class="summary-label">Cash on Hand</div>
            <div class="summary-val text-primary">{{ number_format($totalNet, 2) }}</div>
            <div class="summary-footer">Closing balance</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40%">Account Source</th>
                <th class="text-center">Type</th>
                <th class="text-right">Opening</th>
                <th class="text-right">Inflow (+)</th>
                <th class="text-right">Outflow (-)</th>
                <th class="text-right">Closing</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $data)
            <tr>
                <td class="acc-name">{{ $data->name }}</td>
                <td class="text-center"><span class="badge">{{ $data->type }}</span></td>
                <td class="text-right">{{ number_format($data->opening_balance, 2) }}</td>
                <td class="text-right text-accent">+{{ number_format($data->inflow, 2) }}</td>
                <td class="text-right text-danger">-{{ number_format($data->outflow, 2) }}</td>
                <td class="text-right bold">{{ number_format($data->closing_balance, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #f8fafc; color: #004161; border-top: 2px solid #004161;">
                <td colspan="2" style="font-weight: 800; padding: 12px;">VERTICAL CONSOLIDATION</td>
                <td class="text-right" style="font-weight: 800;">{{ number_format($reportData->sum('opening_balance'), 2) }}</td>
                <td class="text-right" style="font-weight: 900; color: #10b981;">+{{ number_format($totalIn, 2) }}</td>
                <td class="text-right" style="font-weight: 900; color: #ef4444;">-{{ number_format($totalOut, 2) }}</td>
                <td class="text-right" style="font-weight: 900;">{{ number_format($totalNet, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 50px; text-align: center; color: #94a3b8; font-size: 8px;">
        {{ $company->name ?? 'Company' }} — Security Matrix Protocol — Confidential
    </div>

</body>
</html>

