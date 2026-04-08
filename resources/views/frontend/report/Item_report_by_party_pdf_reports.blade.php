<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Report by Party PDF — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 landscape; margin: 10mm 12mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; background: #fff; }

        .header { padding: 14px 20px 12px; border-bottom: 2px solid #004161; margin-bottom: 10px; }
        .logo-wrap { display: inline-block; vertical-align: middle; margin-right: 10px; }
        .logo-img { height: 45px; width: 45px; border-radius: 6px; object-fit: contain; vertical-align: middle; }
        .logo-initial { width: 45px; height: 45px; border-radius: 6px; background: #004161; color: #fff; font-size: 20px; font-weight: 900; text-align: center; line-height: 45px; display: inline-block; vertical-align: middle; }
        .company-name { font-size: 16px; font-weight: 800; color: #004161; display: inline-block; vertical-align: middle; }
        .report-title { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-top: 2px; padding-left: 55px; }
        .report-meta { float: right; text-align: right; }
        .report-meta p { font-size: 9px; color: #64748b; margin-top: 2px; }

        .party-bar { padding: 8px 20px; background: #004161; color: #fff; font-size: 10px; font-weight: 700; margin-bottom: 10px; }
        .party-bar span { opacity: 0.7; font-weight: 400; margin-left: 8px; }

        .stats-bar { padding: 8px 20px; background: #f1f5f9; border-bottom: 1px solid #e2e8f0; font-size: 9px; margin-bottom: 15px; }
        .stats-bar span { font-weight: 700; color: #004161; margin-right: 15px; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #004161; }
        thead th { padding: 8px 10px; text-align: left; font-size: 8px; font-weight: 800; color: #fff; text-transform: uppercase; }
        thead th.right { text-align: right; }

        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 8px 10px; font-size: 9px; }
        tbody td.right { text-align: right; }
        tbody td.bold  { font-weight: 700; color: #004161; }
        tbody td.green { color: #10b981; font-weight: 700; }
        tbody td.red   { color: #ef4444; font-weight: 700; }
        tbody td.muted { color: #94a3b8; }

        tfoot tr { background: #d1fae5; border-top: 2px solid #10b981; }
        tfoot td { padding: 8px 10px; font-size: 10px; font-weight: 800; color: #004161; }
        tfoot td.right { text-align: right; }

        .footer { position: fixed; bottom: 0; width: 100%; padding: 10px 20px; font-size: 8px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .clearfix::after { content: ""; clear: both; display: table; }
        .no-data { text-align: center; padding: 30px; color: #94a3b8; font-size: 11px; }
    </style>
</head>
<body>
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
        $partyName = $selectedParty
            ? ($partyType === 'customer'
                ? ($selectedParty->first_name . ' ' . $selectedParty->last_name)
                : $selectedParty->name)
            : 'N/A';
        $partyPhone = $selectedParty?->phone ?? '';
    @endphp

    <div class="header clearfix">
        <div style="float: left;">
            @if($logoBase64)
                <span class="logo-wrap"><img src="{{ $logoBase64 }}" class="logo-img" alt="Logo"></span>
            @else
                <span class="logo-initial">{{ strtoupper(substr($company->name ?? 'C', 0, 1)) }}</span>
            @endif
            <span class="company-name">{{ $company->name ?? 'Company' }}</span>
            <span class="report-title">Item Report by Party</span>
        </div>
        <div class="report-meta">
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
            <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</p>
            <p><strong>Currency:</strong> {{ $company->currency ?? 'SAR' }}</p>
        </div>
    </div>

    <div class="party-bar">
        Party: {{ $partyName }}
        <span>{{ ucfirst($partyType ?? '') }}{{ $partyPhone ? ' · ' . $partyPhone : '' }}</span>
    </div>

    <div class="stats-bar clearfix">
        Total Sale Qty: <span>{{ number_format($totalSaleQty) }}</span>
        Total Sale Amount: <span>{{ ($company->currency ?? 'SAR') . ' ' . number_format($totalSaleAmt, 2) }}</span>
        Total Purchase Qty: <span>{{ number_format($totalPurchQty) }}</span>
        Total Purchase Amount: <span>{{ ($company->currency ?? 'SAR') . ' ' . number_format($totalPurchAmt, 2) }}</span>
    </div>

    @if($items->isEmpty())
        <div class="no-data">No transactions found for the selected party and date range.</div>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:35px;">#</th>
                <th>Item Name</th>
                <th class="right">Sale Qty</th>
                <th class="right">Sale Amount</th>
                <th class="right">Purchase Qty</th>
                <th class="right">Purchase Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                <td class="bold">{{ $item->name }}</td>
                <td class="right {{ $item->saleQty > 0 ? '' : 'muted' }}">
                    {{ $item->saleQty > 0 ? number_format($item->saleQty) : '---' }}
                </td>
                <td class="right {{ $item->saleAmount > 0 ? 'green' : 'muted' }}">
                    {{ $item->saleAmount > 0 ? number_format($item->saleAmount, 2) : '---' }}
                </td>
                <td class="right {{ $item->purchaseQty > 0 ? '' : 'muted' }}">
                    {{ $item->purchaseQty > 0 ? number_format($item->purchaseQty) : '---' }}
                </td>
                <td class="right {{ $item->purchaseAmount > 0 ? 'red' : 'muted' }}">
                    {{ $item->purchaseAmount > 0 ? number_format($item->purchaseAmount, 2) : '---' }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTALS ({{ $company->currency ?? 'SAR' }})</td>
                <td class="right">{{ number_format($totalSaleQty) }}</td>
                <td class="right">{{ number_format($totalSaleAmt, 2) }}</td>
                <td class="right">{{ number_format($totalPurchQty) }}</td>
                <td class="right">{{ number_format($totalPurchAmt, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    @endif

    <div class="footer clearfix">
        <span style="float: left;">{{ $company->name ?? 'Company' }} — Item Report by Party ({{ $partyName }})</span>
        <span style="float: right;">Page 1 of 1</span>
    </div>
</body>
</html>

