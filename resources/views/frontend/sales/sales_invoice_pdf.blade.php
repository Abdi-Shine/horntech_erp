<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->invoice_no }}</title>
    <style>
        {!! file_get_contents(public_path('frontend/assets/css/receipt-pdf.css')) !!}
    </style>
</head>
<body>

{{-- Header --}}
<div class="inv-header">
    <div class="inv-header-left">
        <div class="inv-company-name">{{ $company->name ?? 'Your Company' }}</div>
        <div class="inv-title">TAX INVOICE</div>
        <div class="inv-no"># {{ $order->invoice_no }}</div>
    </div>
    <div class="inv-header-right">
        <span class="inv-status-badge inv-status-{{ $order->status }}">
            @if($order->status == 'completed') PAID
            @elseif($order->status == 'partial') PARTIAL
            @else UNPAID
            @endif
        </span>
        <div class="inv-issued-date">
            Issued: {{ \Carbon\Carbon::parse($order->invoice_date)->format('d M, Y') }}
        </div>
        @if($order->due_date)
        <div class="inv-due-date">
            Due: {{ \Carbon\Carbon::parse($order->due_date)->format('d M, Y') }}
        </div>
        @endif
    </div>
</div>

{{-- Bill To / From / Payment Info --}}
<div class="inv-info-section">
    <div class="inv-info-block">
        <div class="inv-info-label">Bill To</div>
        <div class="inv-info-value">{{ $order->customer->name ?? 'N/A' }}</div>
        @if($order->customer->phone ?? false)
            <div class="inv-info-sub">{{ $order->customer->phone }}</div>
        @endif
        @if($order->customer->email ?? false)
            <div class="inv-info-sub">{{ $order->customer->email }}</div>
        @endif
        @if($order->customer->address ?? false)
            <div class="inv-info-sub">{{ $order->customer->address }}</div>
        @endif
    </div>
    <div class="inv-info-block-mid">
        <div class="inv-info-label">From</div>
        <div class="inv-info-value">{{ $company->name ?? 'Your Company' }}</div>
        @if($company->phone ?? false)
            <div class="inv-info-sub">{{ $company->phone }}</div>
        @endif
        @if($company->email ?? false)
            <div class="inv-info-sub">{{ $company->email }}</div>
        @endif
        @if($company->address ?? false)
            <div class="inv-info-sub">{{ $company->address }}</div>
        @endif
    </div>
    <div class="inv-info-block-right">
        <div class="inv-info-label">Payment Details</div>
        <div class="inv-info-sub">Method: <strong>{{ $order->payment_method }}</strong></div>
        <div class="inv-info-sub">Items: <strong>{{ $order->items->count() }}</strong></div>
    </div>
</div>

{{-- Items --}}
@php
    $currencySymbols = [
        'USD' => '$',
        'SAR' => 'SAR',
        'SOS' => 'SOS',
        'EUR' => '€',
        'GBP' => '£',
        'KES' => 'KSh',
    ];
    $symbol = '$'; // Force Dollar
@endphp
<div class="inv-items-section">
    <table>
        <thead>
            <tr>
                <th class="inv-th-num">#</th>
                <th>Product / Service</th>
                <th class="center inv-th-qty">Qty</th>
                <th class="center inv-th-unit">Unit</th>
                <th class="right inv-th-price">Unit Price</th>
                <th class="right inv-th-disc">Discount</th>
                <th class="right inv-th-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $i => $item)
            <tr>
                <td class="inv-row-num">{{ $i + 1 }}</td>
                <td>
                    <div class="inv-product-name">{{ $item->product_name }}</div>
                    @if($item->product_code)
                        <div class="inv-product-code">SKU: {{ $item->product_code }}</div>
                    @endif
                </td>
                <td class="center inv-qty-bold">{{ $item->quantity }}</td>
                <td class="center inv-unit-text">{{ $item->unit }}</td>
                <td class="right inv-price-bold">{{ $symbol }} {{ number_format($item->unit_price, 2) }}</td>
                <td class="right inv-disc-val">
                    {{ $item->discount > 0 ? '-'.$symbol.' '.number_format($item->discount, 2) : '—' }}
                </td>
                <td class="right inv-amount">{{ $symbol }} {{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Totals --}}
<div class="inv-totals-section">
    <div class="inv-totals-box">
        <div class="inv-total-row">
            <span class="inv-total-label">Subtotal</span>
            <span class="inv-total-value">{{ $symbol }} {{ number_format($order->subtotal, 2) }}</span>
        </div>
        @if($order->discount > 0)
        <div class="inv-total-row inv-total-disc">
            <span class="inv-total-label">Discount</span>
            <span class="inv-total-value">-{{ $symbol }} {{ number_format($order->discount, 2) }}</span>
        </div>
        @endif
        @if($order->tax > 0)
        <div class="inv-total-row">
            <span class="inv-total-label">Tax</span>
            <span class="inv-total-value">{{ $symbol }} {{ number_format($order->tax, 2) }}</span>
        </div>
        @endif
        <div class="inv-total-row inv-total-grand">
            <span class="inv-total-label">Grand Total</span>
            <span class="inv-total-value">{{ $symbol }} {{ number_format($order->total_amount, 2) }}</span>
        </div>
        <div class="inv-total-row inv-total-paid">
            <span class="inv-total-label">Amount Paid</span>
            <span class="inv-total-value">{{ $symbol }} {{ number_format($order->paid_amount, 2) }}</span>
        </div>
        <div class="inv-balance-box {{ $order->due_amount > 0 ? 'inv-balance-due' : 'inv-balance-zero' }}">
            <span class="inv-balance-label">Balance Due</span>
            <span class="inv-balance-value">{{ $symbol }} {{ number_format($order->due_amount, 2) }}</span>
        </div>
    </div>
</div>

{{-- Notes --}}
@if($order->notes)
<div class="inv-notes-section">
    <div class="inv-notes-label">Notes</div>
    <div class="inv-notes-box">{{ $order->notes }}</div>
</div>
@endif

{{-- Footer --}}
<div class="inv-footer">
    <p>Thank you for your business! Questions? Contact us at <strong>{{ $company->email ?? 'info@company.com' }}</strong> or <strong>{{ $company->phone ?? '' }}</strong></p>
    <p class="inv-footer-margin">{{ $company->name ?? 'Your Company' }} &bull; {{ $company->address ?? '' }}</p>
</div>

</body>
</html>
