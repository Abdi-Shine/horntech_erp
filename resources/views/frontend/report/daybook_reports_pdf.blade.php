<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daybook Report — {{ $company->name ?? 'Company' }}</title>
    <style>
        @page { size: A4 landscape; margin: 10mm 12mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; background: #fff; }

        .header { padding: 14px 20px 12px; border-bottom: 2px solid #004161; display: flex; justify-content: space-between; align-items: flex-start; }
        .company-name { font-size: 16px; font-weight: 800; color: #004161; }
        .report-title { font-size: 11px; font-weight: 700; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: 0.05em; }
        .report-meta { text-align: right; }
        .report-meta p { font-size: 9px; color: #64748b; margin-top: 2px; }

        .filters-bar { padding: 6px 20px; background: #f1f5f9; border-bottom: 1px solid #e2e8f0; font-size: 8.5px; color: #64748b; }
        .filters-bar span { font-weight: 700; color: #004161; }

        table { width: 100%; border-collapse: collapse; table-layout: auto; }
        thead tr { background: #004161; }
        thead th { padding: 7px 8px; text-align: left; font-size: 8px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap; }
        thead th.right  { text-align: right; }
        thead th.center { text-align: center; }

        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 5px 8px; font-size: 9px; color: #334155; word-break: break-word; }
        tbody td.right  { text-align: right; white-space: nowrap; }
        tbody td.center { text-align: center; white-space: nowrap; }
        tbody td.bold   { font-weight: 700; color: #004161; }
        tbody td.red    { color: #dc2626; font-weight: 700; }
        tbody td.balance { text-align: right; font-weight: 800; color: #004161; font-family: monospace; }

        /* Type pills */
        .pill { display: inline-block; padding: 1px 5px; border-radius: 3px; font-size: 7px; font-weight: 800; text-transform: capitalize; white-space: nowrap; }
        .pill-receipt  { background: #ccfbf1; color: #0d9488; }
        .pill-sale     { background: #dcfce7; color: #16a34a; }
        .pill-payment  { background: #ede9fe; color: #7c3aed; }
        .pill-purchase { background: #ffedd5; color: #ea580c; }
        .pill-expense  { background: #fee2e2; color: #dc2626; }
        .pill-journal  { background: #fef9c3; color: #ca8a04; }

        /* Summary */
        .summary { margin-top: 6px; border: 1px solid #fde68a; background: #fffbeb; border-radius: 4px; padding: 8px 14px; }
        .summary-row { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #fef3c7; font-size: 9px; }
        .summary-row:last-child { border-bottom: none; padding-top: 6px; font-size: 11px; font-weight: 900; color: #b45309; }
        .summary-label { color: #64748b; font-weight: 600; }
        .summary-value { font-weight: 800; color: #1e293b; font-family: monospace; }

        .footer { padding: 8px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 8px; color: #94a3b8; margin-top: 4px; }

        .logo-wrap { display: inline-block; vertical-align: middle; margin-right: 12px; }
        .logo-img  { height: 48px; width: 48px; border-radius: 8px; object-fit: contain; }
        .logo-initial { width: 48px; height: 48px; border-radius: 8px; background: #004161; color: #fff; font-size: 20px; font-weight: 900; text-align: center; line-height: 48px; display: inline-block; vertical-align: middle; }
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
                <div class="report-title">Daybook Report</div>
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
                <th class="center" style="width:25px">#</th>
                @if($cols->contains('type'))        <th style="width:55px">Type</th>      @endif
                @if($cols->contains('ref_no'))      <th>Ref #</th>                        @endif
                @if($cols->contains('description')) <th>Description</th>                  @endif
                @if($cols->contains('account'))     <th>Account</th>                      @endif
                @if($cols->contains('debit'))       <th class="right">Debit</th>          @endif
                @if($cols->contains('credit'))      <th class="right">Credit</th>         @endif
                @if($cols->contains('balance'))     <th class="right">Balance</th>        @endif
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
                    default                         => 'Journal',
                };
                $pillClass = match($type) {
                    'Receipt'  => 'pill-receipt',
                    'Sale'     => 'pill-sale',
                    'Payment'  => 'pill-payment',
                    'Purchase' => 'pill-purchase',
                    'Expense'  => 'pill-expense',
                    default    => 'pill-journal',
                };
            @endphp
            <tr>
                <td class="center">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                @if($cols->contains('type'))        <td class="center"><span class="pill {{ $pillClass }}">{{ $type }}</span></td> @endif
                @if($cols->contains('ref_no'))      <td class="bold">{{ $ref }}</td> @endif
                @if($cols->contains('description')) <td>{{ Str::limit($item->item_description ?: ($item->entry_description ?? '—'), 45) }}</td> @endif
                @if($cols->contains('account'))     <td>{{ $item->account_name ?? '—' }}</td> @endif
                @if($cols->contains('debit'))
                    <td class="right {{ $item->debit > 0 ? 'red' : '' }}">
                        {{ $item->debit > 0 ? number_format($item->debit, 2) : '—' }}
                    </td>
                @endif
                @if($cols->contains('credit'))
                    <td class="right {{ $item->credit > 0 ? 'red' : '' }}">
                        {{ $item->credit > 0 ? number_format($item->credit, 2) : '—' }}
                    </td>
                @endif
                @if($cols->contains('balance'))
                    <td class="balance">{{ number_format($item->running_balance, 2) }}</td>
                @endif
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; padding:20px; color:#94a3b8;">No entries found</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary Section -->
    <div class="summary">
        <div class="summary-row">
            <span class="summary-label">Opening Balance</span>
            <span class="summary-value">{{ $company->currency ?? '' }} {{ number_format($openingBalance, 2) }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Debits (Inflows)</span>
            <span class="summary-value">{{ $company->currency ?? '' }} {{ number_format($totalDebit, 2) }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Credits (Outflows)</span>
            <span class="summary-value">{{ $company->currency ?? '' }} {{ number_format($totalCredit, 2) }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Net Movement</span>
            <span class="summary-value">{{ $company->currency ?? '' }} {{ $netBalance >= 0 ? '+' : '' }}{{ number_format($netBalance, 2) }}</span>
        </div>
        <div class="summary-row">
            <span>CLOSING BALANCE</span>
            <span>{{ $company->currency ?? '' }} {{ number_format($closingBalance, 2) }}</span>
        </div>
    </div>

    <div class="footer">
        <span>{{ $company->name ?? 'Company' }} — Confidential</span>
        <span>Generated by Daybook Report System</span>
    </div>

</body>
</html>

