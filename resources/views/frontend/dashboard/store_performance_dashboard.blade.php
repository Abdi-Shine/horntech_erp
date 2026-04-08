@extends('admin.admin_master')
@section('page_title', 'Store Performance')



@section('admin')
<div class="p-6 space-y-6">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center">
                    <i class="bi bi-shop-window text-primary text-lg"></i>
                </div>
                <h1 class="text-[22px] font-black text-primary-dark tracking-tight">Store Performance</h1>
            </div>
            <p class="text-[12px] text-text-secondary font-medium ml-12 italic">Individual point-of-sale metrics, inventory values, and transaction velocity</p>
        </div>
        <form action="{{ route('store_performance_dashboard') }}" method="GET" class="flex items-center gap-3">
            <div class="flex items-center bg-white border border-brand-border rounded-xl px-3 py-2 shadow-sm gap-2">
                <i class="bi bi-calendar3 text-primary text-sm"></i>
                <select name="date_range" onchange="this.form.submit()" class="bg-transparent border-none text-[12px] font-bold text-primary-dark focus:ring-0 cursor-pointer">
                    <option value="last_7_days" {{ $dateRange=='last_7_days'?'selected':'' }}>Last 7 Days</option>
                    <option value="this_month" {{ $dateRange=='this_month'?'selected':'' }}>This Month</option>
                    <option value="this_year" {{ $dateRange=='this_year'?'selected':'' }}>This Year</option>
                </select>
            </div>
            <button class="bg-primary text-white text-[11px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl hover:bg-primary/90 transition-all flex items-center gap-2">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </form>
    </div>

    {{-- ── KPI CARDS ── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- Top Store --}}
        <div class="relative bg-primary-dark rounded-2xl p-6 overflow-hidden shadow-lg kpi-card-hover">
            <div class="absolute top-0 right-0 w-24 h-24 bg-secondary/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="relative">
                <div class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center text-primary-dark mb-4">
                    <i class="bi bi-trophy-fill text-xl"></i>
                </div>
                <p class="text-[10px] font-black opacity-60 uppercase tracking-widest mb-1 text-white">#1 Top Performer</p>
                <h3 class="text-lg font-black text-white mb-1">{{ $stats['top_store']->name ?? '—' }}</h3>
                <p class="text-2xl font-black text-secondary">{{ number_format($stats['top_store']->revenue ?? 0, 2) }}</p>
                <p class="text-[9px] opacity-50 text-white mt-1">{{ $company->currency ?? 'SAR' }} Revenue</p>
            </div>
        </div>

        {{-- Total Sales --}}
        <div class="bg-white rounded-2xl p-6 border border-brand-border shadow-sm kpi-card-hover border-l-4 border-l-secondary">
            <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary mb-4">
                <i class="bi bi-receipt-cutoff text-xl"></i>
            </div>
            <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest mb-1">Total Sales (Period)</p>
            <h3 class="text-2xl font-black text-primary-dark">{{ number_format($stats['total_sales'], 2) }}</h3>
            <p class="text-[9px] text-text-secondary mt-1">{{ $company->currency ?? 'SAR' }} Across All Stores</p>
        </div>

        {{-- Inventory Value --}}
        <div class="bg-white rounded-2xl p-6 border border-brand-border shadow-sm kpi-card-hover border-l-4 border-l-primary">
            <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-4">
                <i class="bi bi-boxes text-xl"></i>
            </div>
            <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest mb-1">Total Inventory Value</p>
            <h3 class="text-2xl font-black text-primary-dark">{{ number_format($stats['total_stock_value'], 2) }}</h3>
            <p class="text-[9px] text-text-secondary mt-1">Cost Basis — All Locations</p>
        </div>
    </div>

    {{-- ── CHART ── --}}
    <div class="bg-white rounded-2xl border border-brand-border shadow-sm p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-1.5 h-5 bg-secondary rounded-full"></div>
            <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Revenue by Store</h3>
        </div>
        <div class="h-[280px]">
            <canvas id="storeChart"></canvas>
        </div>
    </div>

    {{-- ── STORE TABLE ── --}}
    <div class="bg-white rounded-2xl border border-brand-border shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-brand-border flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-5 bg-primary rounded-full"></div>
                <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Detailed Store Performance Ledger</h3>
            </div>
            <span class="text-[10px] font-bold text-text-secondary bg-brand-bg/30 px-3 py-1 rounded-full">{{ $stores->count() }} Stores</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-brand-bg/20 border-b border-brand-border">
                    <tr class="text-[10px] font-black text-primary-dark uppercase tracking-widest">
                        <th class="px-6 py-4">Store</th>
                        <th class="px-6 py-4">Branch</th>
                        <th class="px-6 py-4 text-right">Net Sales</th>
                        <th class="px-6 py-4 text-center">Transactions</th>
                        <th class="px-6 py-4 text-right">Stock Value</th>
                        <th class="px-6 py-4 text-right">Avg. Transaction</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/40">
                    @forelse($stores as $store)
                    @php
                        $avg = $store->transaction_count > 0 ? $store->revenue / $store->transaction_count : 0;
                        $perf = $store->revenue > 50000 ? 'excellent' : ($store->revenue > 15000 ? 'strong' : ($store->revenue > 0 ? 'developing' : 'inactive'));
                        $perfColor = match($perf) { 'excellent' => 'bg-accent/10 text-accent', 'strong' => 'bg-primary/10 text-primary', 'developing' => 'bg-secondary/10 text-secondary', default => 'bg-brand-bg/30 text-text-secondary' };
                    @endphp
                    <tr class="store-row transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary flex-shrink-0">
                                    <i class="bi bi-shop text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[13px] font-black text-primary-dark">{{ $store->name }}</p>
                                    <p class="text-[9px] font-bold text-text-secondary uppercase">STR-{{ str_pad($store->id, 3, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-[12px] font-bold text-text-secondary">{{ $store->branch->name ?? 'Unassigned' }}</td>
                        <td class="px-6 py-4 text-right font-black text-accent text-[13px]">{{ number_format($store->revenue, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 bg-primary/10 text-primary text-[11px] font-black rounded-lg">{{ number_format($store->transaction_count) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right font-black text-primary-dark text-[12px]">{{ number_format($store->stock_value, 2) }}</td>
                        <td class="px-6 py-4 text-right font-bold text-text-secondary text-[12px]">{{ number_format($avg, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-[9px] font-black rounded-full uppercase {{ $perfColor }}">{{ $perf }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center opacity-40">
                                <i class="bi bi-shop text-4xl mb-2 text-primary"></i>
                                <span class="text-[12px] font-bold italic">No store activity found for this period.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('storeChart').getContext('2d');
    const grad = ctx.createLinearGradient(0, 0, 0, 280);
    grad.addColorStop(0, 'rgba(153,204,51,0.25)');
    grad.addColorStop(1, 'rgba(153,204,51,0)');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @js($stores->pluck('name')),
            datasets: [{
                label: 'Revenue',
                data: @js($stores->pluck('revenue')),
                backgroundColor: '#99CC33',
                borderRadius: 8,
                barThickness: 28
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#004161',
                    callbacks: { label: ctx => ' Revenue: ' + parseFloat(ctx.raw).toLocaleString() + ' {{ $company->currency ?? "SAR" }}' }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash:[2,2], color:'#f1f5f9' }, ticks: { font:{size:9,weight:'bold'}, color:'#64748b' } },
                x: { grid: { display: false }, ticks: { font:{size:9,weight:'bold'}, color:'#64748b' } }
            }
        }
    });
});
</script>
@endpush


