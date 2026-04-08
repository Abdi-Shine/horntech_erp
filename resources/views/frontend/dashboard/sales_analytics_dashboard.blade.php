@extends('admin.admin_master')
@section('page_title', 'Sales Analytics')



@section('admin')
<div class="p-6 space-y-6">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center">
                    <i class="bi bi-graph-up-arrow text-primary text-lg"></i>
                </div>
                <h1 class="text-[22px] font-black text-primary-dark tracking-tight">Sales Analytics</h1>
            </div>
            <p class="text-[12px] text-text-secondary font-medium ml-12 italic">Product velocity, category distribution, and transaction intelligence</p>
        </div>
        <form action="{{ route('sales_analytics_dashboard') }}" method="GET" class="flex items-center gap-3">
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Revenue</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalSales, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-secondary/10 rounded-[0.6rem] flex items-center justify-center text-secondary flex-shrink-0">
                <i class="bi bi-currency-dollar text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Invoices</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($txnCount) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">Processed Transactions</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cart-check text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Avg. Invoice Value</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($avgTxn, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ $company->currency ?? 'SAR' }} Per Transaction</p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-wallet2 text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Top Category</p>
                <h3 class="text-[18px] font-black text-primary">{{ $categorySales->first()->name ?? '—' }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ number_format($categorySales->first()->revenue ?? 0, 2) }} {{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-tags text-xl"></i>
            </div>
        </div>
    </div>

    {{-- ── CHARTS ROW ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Category Donut --}}
        <div class="bg-white rounded-2xl border border-brand-border shadow-sm p-6 flex flex-col">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-1.5 h-5 bg-secondary rounded-full"></div>
                <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Revenue by Category</h3>
            </div>
            <div class="h-[220px]">
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="mt-4 space-y-2">
                @php $catColors = ['#99CC33','#004161','#17a2b8','#f59e0b','#e11d48','#8b5cf6']; @endphp
                @foreach($categorySales->take(5) as $i => $cat)
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:{{ $catColors[$i] ?? '#ddd' }}"></span>
                        <span class="text-[11px] font-bold text-primary-dark truncate max-w-[110px]">{{ $cat->name }}</span>
                    </div>
                    <span class="text-[11px] font-black text-text-secondary">{{ number_format($cat->revenue, 0) }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Top Products Table --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-brand-border shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-brand-border flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-primary rounded-full"></div>
                    <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Top Velocity Products</h3>
                </div>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left">
                    <thead class="bg-brand-bg/20 border-b border-brand-border">
                        <tr class="text-[10px] font-black text-primary-dark uppercase tracking-widest">
                            <th class="px-6 py-4 w-12">Rank</th>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4 text-center">Units Sold</th>
                            <th class="px-6 py-4 text-right">Revenue</th>
                            <th class="px-6 py-4">Share</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-border/40">
                        @forelse($topProducts as $i => $product)
                        @php
                            $rankColors = ['bg-primary/10 text-white','bg-slate-400 text-white','bg-primary/10 text-white','bg-brand-bg/40 text-primary-dark','bg-brand-bg/30 text-primary-dark'];
                            $share = $totalSales > 0 ? min(($product->revenue / $totalSales) * 100, 100) : 0;
                        @endphp
                        <tr class="product-row transition-colors">
                            <td class="px-6 py-4">
                                <div class="rank-badge {{ $rankColors[$i] ?? 'bg-brand-bg/20 text-primary-dark' }}">{{ $i+1 }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-[13px] font-black text-primary-dark">{{ $product->product_name }}</p>
                                <p class="text-[9px] font-bold text-text-secondary uppercase">CODE: {{ $product->product_code }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 bg-secondary/10 text-secondary text-[11px] font-black rounded-lg">{{ number_format($product->units_sold) }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-accent text-[13px]">{{ number_format($product->revenue, 2) }}</td>
                            <td class="px-6 py-4 min-w-[100px]">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-brand-bg/30 rounded-full h-1.5">
                                        <div class="bg-primary h-1.5 rounded-full" style="width:{{ number_format($share, 1) }}%"></div>
                                    </div>
                                    <span class="text-[9px] font-black text-text-secondary w-8">{{ number_format($share, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center opacity-40">
                                    <i class="bi bi-box text-4xl mb-2 text-primary"></i>
                                    <span class="text-[12px] font-bold italic">No sales data for this period.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const catCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(catCtx, {
        type: 'doughnut',
        data: {
            labels: @js($categorySales->pluck('name')),
            datasets: [{
                data: @js($categorySales->pluck('revenue')),
                backgroundColor: ['#99CC33','#004161','#17a2b8','#f59e0b','#e11d48','#8b5cf6'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#004161',
                    callbacks: { label: ctx => ' ' + ctx.label + ': ' + parseFloat(ctx.raw).toLocaleString() + ' {{ $company->currency ?? "SAR" }}' }
                }
            }
        }
    });
});
</script>
@endpush


