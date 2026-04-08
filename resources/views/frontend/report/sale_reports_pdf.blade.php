<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report — {{ $company->name ?? 'Company' }}</title>
    <style>
        /* ── Force A4 Landscape in DomPDF ───────────────────────────────────── */
        @page { size: A4 landscape; margin: 10mm 12mm; }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; background: #fff; }

        /* ── Header ─────────────────────────────────────────────────────────── */
        .header { padding: 14px 20px 12px; border-bottom: 2px solid #004161; display: flex; justify-content: space-between; align-items: flex-start; }
        .company-name { font-size: 16px; font-weight: 800; color: #004161; }
        .report-title { font-size: 11px; font-weight: 700; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: 0.05em; }
        .report-meta { text-align: right; }
        .report-meta p { font-size: 9px; color: #64748b; margin-top: 2px; }

        /* ── Filters bar ─────────────────────────────────────────────────────── */
        .filters-bar { padding: 6px 20px; background: #f1f5f9; border-bottom: 1px solid #e2e8f0; font-size: 8.5px; color: #64748b; }
        .filters-bar span { font-weight: 700; color: #004161; }

        /* ── Table — compact so many columns fit in landscape ───────────────── */
        table { width: 100%; border-collapse: collapse; table-layout: auto; }
        thead tr { background: #004161; }
        thead th { padding: 7px 8px; text-align: left; font-size: 8px; font-weight: 800; color: #fff;
                   text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap; }
        thead th.right  { text-align: right; }
        thead th.center { text-align: center; }

        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 6px 8px; font-size: 9px; color: #334155; word-break: break-word; }
        tbody td.right  { text-align: right; white-space: nowrap; }
        tbody td.center { text-align: center; white-space: nowrap; }
        tbody td.bold   { font-weight: 700; color: #004161; }
        tbody td.green  { color: #10b981; font-weight: 700; }
        tbody td.red    { color: #ef4444; font-weight: 700; }

        /* ── Period Totals footer ────────────────────────────────────────────── */
        tfoot tr { background: #d1fae5; border-top: 2px solid #10b981; }
        tfoot td { padding: 7px 8px; font-size: 9px; font-weight: 800; color: #004161; white-space: nowrap; }
        tfoot td.right  { text-align: right; }
        tfoot td.center { text-align: center; }

        /* ── Status pills ────────────────────────────────────────────────────── */
        .pill { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 7px; font-weight: 800; text-transform: uppercase; white-space: nowrap; }
        .pill-paid    { background: #10b981; color: #fff; }
        .pill-partial { background: #f59e0b; color: #fff; }
        .pill-pending { background: #ef4444; color: #fff; }

        /* ── Page footer ─────────────────────────────────────────────────────── */
        .footer { padding: 8px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 8px; color: #94a3b8; margin-top: 4px; }

        /* ── Logo ────────────────────────────────────────────────────────────── */
        .logo-wrap { display: inline-block; vertical-align: middle; margin-right: 12px; }
        .logo-img  { height: 52px; width: 52px; border-radius: 8px; object-fit: contain; border: 1px solid #e2e8f0; }
        .logo-initial { width: 52px; height: 52px; border-radius: 8px; background: #004161;
                        color: #fff; font-size: 22px; font-weight: 900; text-align: center;
                        line-height: 52px; display: inline-block; vertical-align: middle; }
        .header-left { display: inline-block; vertical-align: middle; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div>
            @php
                $logoBase64  = null;
                if ($company && $company->logo) {
                    $logoPath = $company->logo;
                    if (!str_starts_with($logoPath, 'uploads/')) {
                        $logoPath = 'uploads/company/' . $logoPath;
                    }
                    $fullLogoPath = public_path($logoPath);
                    if (file_exists($fullLogoPath)) {
                        $ext         = pathinfo($fullLogoPath, PATHINFO_EXTENSION);
                        $logoData    = file_get_contents($fullLogoPath);
                        $logoBase64  = 'data:image/' . $ext . ';base64,' . base64_encode($logoData);
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
                <div class="report-title">Sales Report</div>
            </span>
        </div>
        <div class="report-meta">
            <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
            @if($filters['from_date'] ?? null)
            <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($filters['from_date'])->format('d M Y') }} — {{ \Carbon\Carbon::parse($filters['to_date'] ?? now())->format('d M Y') }}</p>
            @endif
            <p><strong>Total Records:</strong> {{ number_format($totalInvoices) }}</p>
        </div>
    </div>


    <!-- Filters applied -->
    @if(array_filter($filters))
    <div class="filters-bar">
        Filters applied:
        @if($filters['search'] ?? null) Search: <span>{{ $filters['search'] }}</span> &nbsp;|&nbsp; @endif
        @if($filters['from_date'] ?? null) From: <span>{{ $filters['from_date'] }}</span> @endif
        @if($filters['to_date'] ?? null) To: <span>{{ $filters['to_date'] }}</span> &nbsp;|&nbsp; @endif
        @if($filters['status'] ?? null) Status: <span>{{ ucfirst($filters['status']) }}</span> @endif
    </div>
    @endif

    <!-- Table -->
    @php
        $cols = collect(request('cols', [
            'date','invoice_no','party_name','total','payment_type','received','balance'
        ]));
        // Count active columns for colspan calculation
        $colCount = 1 + $cols->count(); // 1 for # column
    @endphp
    <table>
        <thead>
            <tr>
                <th style="width:30px" class="center">#</th>
                @if($cols->contains('invoice_no'))  <th>Invoice #</th>     @endif
                @if($cols->contains('date'))         <th>Date</th>          @endif
                @if($cols->contains('party_name'))   <th>Party Name</th>    @endif
                @if($cols->contains('phone'))        <th>Phone No.</th>     @endif
                @if($cols->contains('order_number')) <th>Order No.</th>     @endif
                @if($cols->contains('item_details')) <th class="center">Items</th> @endif
                @if($cols->contains('description'))  <th>Description</th>   @endif
                @if($cols->contains('payment_type')) <th class="center">Payment Type</th> @endif
                @if($cols->contains('total'))        <th class="right">Total Amount</th> @endif
                @if($cols->contains('received'))     <th class="right">Paid</th>         @endif
                @if($cols->contains('balance'))      <th class="right">Balance</th>      @endif
                @if($cols->contains('payment_status')) <th class="center">Status</th>   @endif
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $index => $sale)
            @php
                $customerName = $sale->customer->name ?? 'Walk-in Customer';
                $pillClass = match($sale->status) {
                    'completed' => 'pill-paid',
                    'partial'   => 'pill-partial',
                    'pending'   => 'pill-pending',
                    default     => ''
                };
                $phone = $sale->customer->phone ?? '—';
            @endphp
            <tr>
                <td class="center">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                @if($cols->contains('invoice_no'))   <td class="bold">{{ $sale->invoice_no }}</td> @endif
                @if($cols->contains('date'))         <td>{{ $sale->invoice_date->format('d-M-Y') }}</td> @endif
                @if($cols->contains('party_name'))   <td class="bold">{{ $customerName }}</td> @endif
                @if($cols->contains('phone'))        <td>{{ $phone }}</td> @endif
                @if($cols->contains('order_number')) <td>{{ $sale->id }}</td> @endif
                @if($cols->contains('item_details')) <td class="center">{{ number_format($sale->items->sum('quantity')) }}</td> @endif
                @if($cols->contains('description'))  <td>{{ $sale->notes ?? '—' }}</td> @endif
                @if($cols->contains('payment_type')) <td class="center">{{ $sale->payment_method ?? 'Cash' }}</td> @endif
                @if($cols->contains('total'))        <td class="right bold">{{ number_format($sale->total_amount, 2) }}</td> @endif
                @if($cols->contains('received'))     <td class="right green">{{ number_format($sale->paid_amount, 2) }}</td> @endif
                @if($cols->contains('balance'))      <td class="right red">{{ number_format($sale->total_amount - $sale->paid_amount, 2) }}</td> @endif
                @if($cols->contains('payment_status')) <td class="center"><span class="pill {{ $pillClass }}">{{ $sale->status_label }}</span></td> @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ $colCount }}" style="text-align:center; padding:30px; color:#94a3b8;">No records found</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                @php $tfootSpan = 1; @endphp
                @if($cols->contains('invoice_no'))  @php $tfootSpan++ @endphp @endif
                @if($cols->contains('date'))        @php $tfootSpan++ @endphp @endif
                @if($cols->contains('party_name'))  @php $tfootSpan++ @endphp @endif
                @if($cols->contains('phone'))       @php $tfootSpan++ @endphp @endif
                @if($cols->contains('order_number'))@php $tfootSpan++ @endphp @endif
                @if($cols->contains('description')) @php $tfootSpan++ @endphp @endif
                @if($cols->contains('payment_type'))@php $tfootSpan++ @endphp @endif
                <td colspan="{{ $tfootSpan }}"><strong>PERIOD TOTALS</strong></td>
                @if($cols->contains('item_details'))  <td class="center">{{ number_format($totalItems) }}</td>    @endif
                @if($cols->contains('total'))         <td class="right">{{ number_format($totalSales, 2) }}</td>  @endif
                @if($cols->contains('received'))      <td class="right" style="color:#10b981;">{{ number_format($paidAmount, 2) }}</td> @endif
                @if($cols->contains('balance'))       <td class="right" style="color:#ef4444;">{{ number_format($totalOutstanding, 2) }}</td> @endif
                @if($cols->contains('payment_status'))<td></td>                                                   @endif
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div class="footer">
        <span>{{ $company->name ?? 'Company' }} — Confidential</span>
        <span>Generated by Sales Report System</span>
    </div>

</body>
</html>

