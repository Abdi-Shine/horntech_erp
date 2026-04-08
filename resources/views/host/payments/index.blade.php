@extends('super_admin.layouts.master')
@section('page_title', 'Payments')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Payments</h4>
        <p class="text-muted mb-0">All subscription payment transactions</p>
    </div>
    <div class="sa-stat d-flex align-items-center gap-3 px-4 py-3" style="margin-bottom:0;">
        <div class="sa-stat-icon" style="background:#dcfce7;color:#16a34a;margin-bottom:0;">
            <i class="bi bi-currency-dollar"></i>
        </div>
        <div>
            <div class="sa-stat-lbl">Total Revenue</div>
            <div class="sa-stat-val text-success">${{ number_format($totalRevenue, 2) }}</div>
        </div>
    </div>
</div>

<div class="sa-card">
    <table class="sa-table">
        <thead>
            <tr>
                <th>Company</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Method</th>
                <th>Transaction ID</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $pmt)
            @php
                $badgeClass = match($pmt->status) {
                    'paid'    => 'sa-badge-green',
                    'pending' => 'sa-badge-yellow',
                    'failed'  => 'sa-badge-red',
                    default   => 'sa-badge-gray',
                };
            @endphp
            <tr>
                <td class="fw-semibold">{{ $pmt->subscription->company->name ?? '—' }}</td>
                <td>{{ $pmt->subscription->plan->name ?? '—' }}</td>
                <td class="fw-bold">${{ number_format($pmt->amount, 2) }}</td>
                <td>{{ $pmt->payment_date ? \Carbon\Carbon::parse($pmt->payment_date)->format('d M Y') : '—' }}</td>
                <td>{{ $pmt->payment_method ?? '—' }}</td>
                <td><code>{{ $pmt->transaction_id ?? '—' }}</code></td>
                <td><span class="sa-badge {{ $badgeClass }}">{{ ucfirst($pmt->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-5 text-muted">No payments recorded yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($payments->hasPages())
<div class="mt-4 d-flex justify-content-center">{{ $payments->links() }}</div>
@endif
@endsection
