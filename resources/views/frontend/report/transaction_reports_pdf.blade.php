<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Report — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 landscape; margin: 10mm 12mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1e293b; background: #fff; }

        .header { padding: 14px 20px 12px; border-bottom: 2px solid #004161; display: flex; justify-content: space-between; align-items: flex-start; }
        .company-name { font-size: 16px; font-weight: 800; color: #004161; }
        .report-title { font-size: 11px; font-weight: 700; color: #004161; margin-top: 2px; text-transform: uppercase; letter-spacing: 0.05em; }
        .report-meta { text-align: right; }
        .report-meta p { font-size: 8px; color: #6b7280; margin-top: 2px; }

        .filters-bar { padding: 6px 20px; background: #faf5ff; border-bottom: 1px solid #e9d5ff; font-size: 8px; color: #7e22ce; }
        .filters-bar span { font-weight: 700; color: #9333ea; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead th { padding: 10px 8px; text-align: left; font-size: 8px; font-weight: 800; color: #9333ea; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e9d5ff; }
        thead th.right  { text-align: right; }

        tbody tr { border-bottom: 1px solid #f3f4f6; }
        tbody td { padding: 8px 8px; font-size: 9px; color: #374151; }
        tbody td.right  { text-align: right; white-space: nowrap; }
        tbody td.bold   { font-weight: 700; color: #1e293b; }
        tbody td.party  { font-weight: 700; color: #111827; }
        tbody td.debit  { color: #db2777; font-weight: 600; }
        tbody td.credit { color: #16a34a; font-weight: 600; }
        tbody td.amount { font-weight: 800; color: #111827; }

        /* Type pills */
        .pill { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 7px; font-weight: 800; text-transform: capitalize; border: 1px solid transparent; }
        .pill-receipt  { background: #f0f9ff; color: #0ea5e9; border-color: #bae6fd; }
        .pill-sale     { background: #f0fdf4; color: #22c55e; border-color: #dcfce7; }
        .pill-purchase { background: #fff1f2; color: #e11d48; border-color: #ffe4e6; }
        .pill-payment  { background: #f5f3ff; color: #7c3aed; border-color: #ddd6fe; }
        .pill-transfer { background: #ecfeff; color: #0891b2; border-color: #cffafe; }
        .pill-journal  { background: #fffbeb; color: #d97706; border-color: #fef3c7; }
        .pill-expense  { background: #fdf2f8; color: #db2777; border-color: #fce7f3; }

        .tfoot-row { background: #f5f3ff; }
        .tfoot-td { padding: 12px 8px; font-size: 11px; font-weight: 900; color: #6b21a8; text-transform: uppercase; border-top: 2px solid #ddd6fe; }
        .tfoot-val { font-size: 11px; font-weight: 900; color: #db2777; border-top: 2px solid #ddd6fe; text-align: right; }

        .footer { padding: 10px 20px; font-size: 8px; color: #9ca3af; text-align: center; margin-top: 20px; }
        .logo-wrap { display: inline-block; vertical-align: middle; margin-right: 12px; }
        .logo-img  { height: 40px; width: 40px; border-radius: 6px; }
        .logo-initial { width: 40px; height: 40px; border-radius: 6px; background: #004161; color: #fff; font-size: 18px; font-weight: 900; text-align: center; line-height: 40px; display: inline-block; }
        .header-left { display: inline-block; vertical-align: middle; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div>
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
            <span class="header-left">
                <div class="company-name">{{ $company->name ?? 'Company Name' }}</div>
                <div class="report-title">Transaction Report</div>
            </span>
        </div>
        <div class="report-meta">
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
            @if($filters['from_date'] ?? null)
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($filters['from_date'])->format('d M Y') }}
                @if(($filters['to_date'] ?? null) && $filters['to_date'] !== $filters['from_date'])
                 — {{ \Carbon\Carbon::parse($filters['to_date'])->format('d M Y') }}
                @endif
            </p>
            @endif
            <p><strong>Total Lines:</strong> {{ number_format(count($items)) }}</p>
        </div>
    </div>

    <!-- Filters -->
    @if(array_filter($filters))
    <div class="filters-bar">
        Filters:
        @if($filters['search'] ?? null) Search: <span>{{ $filters['search'] }}</span> &nbsp;|&nbsp; @endif
        @if($filters['from_date'] ?? null) From: <span>{{ $filters['from_date'] }}</span> @endif
        @if($filters['to_date'] ?? null) &nbsp;To: <span>{{ $filters['to_date'] }}</span> @endif
        @if($filters['status'] ?? null) &nbsp;| Status: <span>{{ ucfirst($filters['status']) }}</span> @endif
    </div>
    @endif

    @php
        $cols = collect(request('cols', ['type','ref_no','description','account','debit','credit','balance']));
    @endphp

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th style="width:70px">Date</th>
                @if($cols->contains('type'))        <th style="width:60px">Type</th>      @endif
                @if($cols->contains('ref_no'))      <th style="width:80px">Reference #</th> @endif
                @if($cols->contains('account'))     <th style="width:120px">Party</th>    @endif
                @if($cols->contains('description')) <th>Description</th>                  @endif
                @if($cols->contains('debit'))       <th class="right" style="width:80px">Debit</th> @endif
                @if($cols->contains('credit'))      <th class="right" style="width:80px">Credit</th> @endif
                @if($cols->contains('balance'))     <th class="right" style="width:80px">Amount</th> @endif
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
            @php
                $ref    = $item->entry_reference ?? $item->entry_number ?? '—';
                $refUp  = strtoupper($ref);
                $type   = match(true) {
                    str_starts_with($refUp, 'RCP') => 'Receipt',
                    str_starts_with($refUp, 'INV') => 'Sale',
                    str_starts_with($refUp, 'PAY') => 'Payment',
                    str_starts_with($refUp, 'PO')  => 'Purchase',
                    str_starts_with($refUp, 'EXP') => 'Expense',
                    str_starts_with($refUp, 'TRF') => 'Transfer',
                    default                         => 'Journal',
                };
                    $pillClass = match($type) {
                        'Receipt'  => 'pill-receipt',
                        'Sale'     => 'pill-sale',
                        'Payment'  => 'pill-payment',
                        'Purchase' => 'pill-purchase',
                        'Expense'  => 'pill-expense',
                        'Transfer' => 'pill-transfer',
                        default    => 'pill-journal',
                    };
                $party = $item->customer_name ?: ($item->supplier_name ?: ($item->account_name ?? '—'));
                $amount = max($item->debit, $item->credit);
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->entry_date)->format('M d, Y') }}</td>
                @if($cols->contains('type'))        <td class="center italic"><span class="pill {{ $pillClass }}">{{ $type }}</span></td> @endif
                @if($cols->contains('ref_no'))      <td class="bold" style="color: {{ $type == 'Sale' ? '#db2777' : ($type == 'Purchase' ? '#9333ea' : '#1e293b') }}">{{ $ref }}</td> @endif
                @if($cols->contains('account'))     <td class="party">{{ $item->account_name ?? '—' }}</td> @endif
                @if($cols->contains('description')) <td style="color:#6b7280;">{{ Str::limit($item->item_description ?: ($item->entry_description ?? '—'), 40) }}</td> @endif
                @if($cols->contains('debit'))
                    <td class="right debit">
                        {{ $item->debit > 0 ? number_format($item->debit, 2) : '—' }}
                    </td>
                @endif
                @if($cols->contains('credit'))
                    <td class="right credit">
                        {{ $item->credit > 0 ? number_format($item->credit, 2) : '—' }}
                    </td>
                @endif
                @if($cols->contains('balance'))
                    <td class="right amount">{{ number_format($amount, 2) }}</td>
                @endif
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; padding:20px; color:#9ca3af;">No entries found</td></tr>
            @endforelse
            @if(count($items) > 0)
            <tr class="tfoot-row">
                <td colspan="5" class="tfoot-td">Total</td>
                @if($cols->contains('debit'))  <td class="tfoot-val">{{ number_format($totalDebit, 2) }}</td> @endif
                @if($cols->contains('credit')) <td class="tfoot-val" style="color:#16a34a;">{{ number_format($totalCredit, 2) }}</td> @endif
                @if($cols->contains('balance')) <td class="tfoot-val" style="color:#111827;">{{ number_format($totalDebit + $totalCredit, 2) }}</td> @endif
            </tr>
            @endif
        </tbody>
    </table>



    <div class="footer">
        <span>{{ $company->name ?? 'Company' }} — Confidential</span>
        <span>Generated by Daybook Report System</span>
    </div>

</body>
</html>

