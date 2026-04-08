@extends('super_admin.layouts.master')
@section('page_title', 'Subscriptions')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Subscriptions</h4>
        <p class="text-muted mb-0">All tenant subscriptions</p>
    </div>
    <span class="sa-badge sa-badge-blue">{{ $subscriptions->total() }} total</span>
</div>

<div class="sa-card">
    <table class="sa-table">
        <thead>
            <tr>
                <th>Company</th>
                <th>Plan</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>Expiry Date</th>
                <th>Auto Renew</th>
                <th>Payment</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $sub)
            @php
                $badgeClass = match($sub->status) {
                    'active'    => 'sa-badge-green',
                    'trial'     => 'sa-badge-blue',
                    'expired'   => 'sa-badge-red',
                    'cancelled' => 'sa-badge-gray',
                    default     => 'sa-badge-gray',
                };
                $expiring = $sub->status === 'active'
                    && $sub->expiry_date
                    && \Carbon\Carbon::parse($sub->expiry_date)->diffInDays(now()) <= 7
                    && \Carbon\Carbon::parse($sub->expiry_date)->isFuture();
            @endphp
            <tr>
                <td class="fw-semibold">{{ $sub->company->name ?? '—' }}</td>
                <td>{{ $sub->plan->name ?? 'No Plan' }}</td>
                <td><span class="sa-badge {{ $badgeClass }}">{{ ucfirst($sub->status) }}</span></td>
                <td>{{ $sub->start_date ? \Carbon\Carbon::parse($sub->start_date)->format('d M Y') : '—' }}</td>
                <td>
                    {{ $sub->expiry_date ? \Carbon\Carbon::parse($sub->expiry_date)->format('d M Y') : '—' }}
                    @if($expiring)
                        <span class="sa-badge sa-badge-yellow ms-1">Expiring Soon</span>
                    @endif
                </td>
                <td>
                    @if($sub->auto_renew)
                        <span class="sa-badge sa-badge-green"><i class="bi bi-check"></i> Yes</span>
                    @else
                        <span class="sa-badge sa-badge-gray">No</span>
                    @endif
                </td>
                <td>{{ $sub->payment_method ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-5 text-muted">No subscriptions found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($subscriptions->hasPages())
<div class="mt-4 d-flex justify-content-center">{{ $subscriptions->links() }}</div>
@endif
@endsection
