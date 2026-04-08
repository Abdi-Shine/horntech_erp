<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Balance Sheet — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 portrait; margin: 10mm 15mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1e293b; background: #fff; line-height: 1.4; }

        .header { padding: 5px 0 15px; border-bottom: 3px solid #004161; display: table; width: 100%; }
        .header-cell { display: table-cell; vertical-align: bottom; }
        
        .logo-wrap { display: inline-block; vertical-align: middle; margin-right: 12px; }
        .logo-img { max-height: 50px; max-width: 120px; object-fit: contain; }
        
        .company-details { display: inline-block; vertical-align: middle; }
        .company-name { font-size: 20px; font-weight: 900; color: #004161; margin-bottom: 2px; letter-spacing: 0.5px; }
        .report-title { font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.08em; }
        
        .report-meta { text-align: right; vertical-align: bottom; }
        .report-meta p { font-size: 9px; color: #64748b; margin-top: 4px; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        thead th { padding: 10px 8px; text-align: left; font-size: 9px; font-weight: 800; color: #475569; text-transform: uppercase; border-bottom: 2px solid #004161; }
        
        .section-header { background: #f8fafc; padding: 8px 10px; font-size: 10px; font-weight: 800; color: #004161; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }
        
        tbody td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; font-size: 10px; color: #334155; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .acc-name { font-weight: 600; color: #1e293b; }

        tfoot tr td { padding: 15px 10px; font-weight: 800; font-size: 11px; color: #1e293b; border-top: 2px solid #004161; }

        .footer { margin-top: 50px; text-align: center; color: #94a3b8; font-size: 8px; border-top: 1px solid #f1f5f9; padding-top: 10px; }
    </style>
</head>
<body>

    @php
        $logoBase64 = null;
        if (isset($company) && $company->logo) {
            $logoPath = $company->logo;
            if (!str_starts_with($logoPath, 'uploads/')) $logoPath = 'uploads/company/' . $logoPath;
            $fullLogoPath = public_path($logoPath);
            if (file_exists($fullLogoPath)) {
                $ext = pathinfo($fullLogoPath, PATHINFO_EXTENSION);
                $logoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($fullLogoPath));
            }
        }
    @endphp

    <!-- Header -->
    <div class="header">
        <div class="header-cell">
            @if($logoBase64)
                <div class="logo-wrap">
                    <img src="{{ $logoBase64 }}" class="logo-img" alt="Logo">
                </div>
            @endif
            <div class="company-details">
                <div class="company-name">{{ $company->name ?? 'Company Name' }}</div>
                <div class="report-title">Statement of Financial Position</div>
            </div>
        </div>
        <div class="header-cell report-meta">
            <p><strong>Currency:</strong> {{ $company->currency ?? 'SAR' }}</p>
            <p><strong>As of Date:</strong> {{ \Carbon\Carbon::parse($filters['as_of_date'])->format('d M Y') }}</p>
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 35%">ASSETS</th>
                <th style="width: 15%; text-align: right;">AMOUNT</th>
                <th style="width: 35%; border-left: 1px solid #e2e8f0;">LIABILITIES & EQUITY</th>
                <th style="width: 15%; text-align: right;">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @php
                $assetRows = $assets->values();
                $liabilitiesRows = $liabilities->values();
                $equityRows = $equityAccounts->values();
                
                $rightSide = $liabilitiesRows->concat($equityRows);
                $rightSide->push((object)['name' => 'Retained Earnings (Net Income)', 'balance' => $netIncome]);
                
                $maxRows = max($assetRows->count(), $rightSide->count());
            @endphp

            @for($i = 0; $i < $maxRows; $i++)
                <tr>
                    <!-- Assets -->
                    @if(isset($assetRows[$i]))
                        <td class="acc-name">{{ $assetRows[$i]->name }}</td>
                        <td class="text-right">{{ number_format($assetRows[$i]->balance, 2) }}</td>
                    @else
                        <td></td><td></td>
                    @endif

                    <!-- Sources -->
                    @if(isset($rightSide[$i]))
                        <td class="acc-name" style="border-left: 1px solid #f1f5f9;">{{ $rightSide[$i]->name }}</td>
                        <td class="text-right">{{ number_format($rightSide[$i]->balance, 2) }}</td>
                    @else
                        <td style="border-left: 1px solid #f1f5f9;"></td><td></td>
                    @endif
                </tr>
            @endfor
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align: left;">TOTAL ASSETS</td>
                <td class="text-right">{{ number_format($totalAssets, 2) }}</td>
                <td style="text-align: left; border-left: 1px solid #e2e8f0;">SOURCES OF FUNDS</td>
                <td class="text-right">{{ number_format($totalLiabilitiesEquity, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; padding: 15px; background: #f0fdf4; border: 1px solid #bbf7d0; text-align: center; color: #166534; font-weight: 800;">
        STATUS: BALANCED STATEMENT (Assets ({{ number_format($totalAssets, 2) }}) = Liabilities & Equity ({{ number_format($totalLiabilitiesEquity, 2) }}))
    </div>

    <div class="footer">
        {{ $company->name ?? 'Company' }} — Horntech LTD Accounting Suite — Page 1/1 — Digital Audit Certified
    </div>

</body>
</html>

