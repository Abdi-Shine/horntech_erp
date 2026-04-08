<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Balance — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 portrait; margin: 10mm 15mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1e293b; background: #fff; line-height: 1.4; }

        .header { padding: 15px 0 10px; border-bottom: 3px solid #004161; display: table; width: 100%; }
        .header-cell { display: table-cell; vertical-align: top; }
        .company-name { font-size: 18px; font-weight: 800; color: #004161; margin-bottom: 2px; }
        .report-title { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        .report-meta { text-align: right; }
        .report-meta p { font-size: 9px; color: #64748b; margin-top: 3px; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        thead th { padding: 10px 8px; text-align: left; font-size: 9px; font-weight: 800; color: #475569; text-transform: uppercase; border-bottom: 2px solid #004161; }
        
        .category-row { background: #f8fafc; }
        .category-row td { padding: 8px 10px; font-size: 10px; font-weight: 800; color: #004161; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }
        
        tbody td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; font-size: 10px; color: #334155; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .acc-code { color: #94a3b8; font-weight: 700; }
        .acc-name { font-weight: 600; color: #1e293b; }

        tfoot tr td { padding: 15px 10px; font-weight: 800; font-size: 11px; color: #004161; border-top: 2px solid #004161; border-bottom: 2px solid #004161; }

        .footer { margin-top: 50px; text-align: center; color: #94a3b8; font-size: 8px; border-top: 1px solid #f1f5f9; padding-top: 10px; }

        .image-initial { width: 45px; height: 45px; border-radius: 6px; background: #004161; color: #fff; font-size: 18px; font-weight: 900; text-align: center; line-height: 45px; display: inline-block; vertical-align: middle; margin-right: 10px; }
        .logo-img { height: 45px; width: 45px; border-radius: 6px; object-fit: contain; margin-right: 10px; vertical-align: middle; }
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
                <img src="{{ $logoBase64 }}" class="logo-img" alt="Logo">
            @else
                <span class="image-initial">{{ strtoupper(substr($company->name ?? 'C', 0, 1)) }}</span>
            @endif
            <div style="display:inline-block; vertical-align: middle;">
                <div class="company-name">{{ $company->name ?? 'Company Name' }}</div>
                <div class="report-title">Trial Balance Statement</div>
            </div>
        </div>
        <div class="header-cell report-meta">
            <p><strong>Currency:</strong> {{ $company->currency ?? 'SAR' }}</p>
            <p><strong>As of Date:</strong> {{ \Carbon\Carbon::parse($filters['to_date'])->format('d M Y') }}</p>
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    @php
        $grandTotalDebit = 0;
        $grandTotalCredit = 0;
        $categories = ['assets', 'liabilities', 'equity', 'revenue', 'expenses'];
    @endphp

    <table>
        <thead>
            <tr>
                <th style="width: 15%">Account Code</th>
                <th style="width: 45%">Account Name</th>
                <th style="width: 20%; text-align: right;">Debit Balance</th>
                <th style="width: 20%; text-align: right;">Credit Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
                @php
                    $catItems = $reportData->where('category', $cat);
                @endphp
                
                @if($catItems->count() > 0)
                    <tr class="category-row">
                        <td colspan="4">{{ strtoupper($cat) }}</td>
                    </tr>
                    
                    @foreach($catItems as $data)
                        @php
                            $debitVal = 0;
                            $creditVal = 0;
                            
                            if (in_array($cat, ['assets', 'expenses'])) {
                                if ($data->closing_balance >= 0) $debitVal = $data->closing_balance;
                                else $creditVal = abs($data->closing_balance);
                            } else {
                                if ($data->closing_balance >= 0) $creditVal = $data->closing_balance;
                                else $debitVal = abs($data->closing_balance);
                            }
                            
                            $grandTotalDebit += $debitVal;
                            $grandTotalCredit += $creditVal;
                        @endphp
                        <tr>
                            <td class="acc-code">{{ $data->code }}</td>
                            <td class="acc-name">{{ $data->name }}</td>
                            <td class="text-right">
                                {{ $debitVal > 0 ? number_format($debitVal, 2) : '—' }}
                            </td>
                            <td class="text-right">
                                {{ $creditVal > 0 ? number_format($creditVal, 2) : '—' }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: left; padding-left: 10px;">TOTAL BALANCE</td>
                <td class="text-right">{{ number_format($grandTotalDebit, 2) }}</td>
                <td class="text-right">{{ number_format($grandTotalCredit, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        {{ $company->name ?? 'Company' }} — Horntech LTD Accounting Suite — Confidential — Digital Audit Certified
    </div>

</body>
</html>

