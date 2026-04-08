@extends('admin.admin_master')
@section('page_title', 'Branch Performance')



@section('admin')
<div class="p-6 space-y-6">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center">
                    <i class="bi bi-diagram-3-fill text-primary text-lg"></i>
                </div>
                <h1 class="text-[22px] font-black text-primary-dark tracking-tight">Branch Performance</h1>
            </div>
            <p class="text-[12px] text-text-secondary font-medium ml-12 italic">Revenue, profit, and growth analytics across all business branches</p>
        </div>
        <form action="{{ route('branch_performance_dashboard') }}" method="GET" class="flex items-center gap-3">
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

        {{-- Top Revenue --}}
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Highest Revenue Branch</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['top_revenue_branch']->name ?? '—' }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ number_format($stats['top_revenue_branch']->revenue ?? 0, 2) }} {{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-secondary/10 rounded-[0.6rem] flex items-center justify-center text-secondary flex-shrink-0">
                <i class="bi bi-building-fill text-xl"></i>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Network Revenue</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['total_revenue'], 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-cash-stack text-xl"></i>
            </div>
        </div>

        {{-- Total Expenses --}}
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Operating Expenses</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['total_expenses'], 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-down-circle text-xl"></i>
            </div>
        </div>

        {{-- Net Profit --}}
        @php $netMargin = $stats['total_revenue'] > 0 ? ($stats['total_profit'] / $stats['total_revenue']) * 100 : 0; @endphp
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Net Profit</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['total_profit'], 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ number_format($netMargin, 1) }}% margin · {{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up-arrow text-xl"></i>
            </div>
        </div>
    </div>

    {{-- ── CHART ── --}}
    <div class="bg-white rounded-2xl border border-brand-border shadow-sm p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-1.5 h-5 bg-primary rounded-full"></div>
            <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Branch Revenue vs Expenses vs Profit</h3>
            <div class="ml-auto flex items-center gap-4 text-[10px] font-bold text-text-secondary">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-secondary inline-block"></span>Revenue</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-primary/10 inline-block"></span>Expenses</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-primary inline-block"></span>Profit</span>
            </div>
        </div>
        <div class="h-[320px]">
            <canvas id="branchChart"></canvas>
        </div>
    </div>

    {{-- ── BRANCH TABLE ── --}}
    <div class="bg-white rounded-2xl border border-brand-border shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-brand-border flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-5 bg-secondary rounded-full"></div>
                <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Branch-wise Financial Breakdown</h3>
            </div>
            <span class="text-[10px] font-bold text-text-secondary bg-brand-bg/30 px-3 py-1 rounded-full">{{ $branches->count() }} Branches</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-brand-bg/20 border-b border-brand-border">
                    <tr class="text-[10px] font-black text-primary-dark uppercase tracking-widest">
                        <th class="px-6 py-4">Branch</th>
                        <th class="px-6 py-4 text-center">Stores</th>
                        <th class="px-6 py-4 text-right">Revenue</th>
                        <th class="px-6 py-4 text-right">Expenses</th>
                        <th class="px-6 py-4 text-right">Net Profit</th>
                        <th class="px-6 py-4 text-center">Margin</th>
                        <th class="px-6 py-4 text-center">Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/40">
                    @forelse($branches as $branch)
                    @php
                        $stars = $branch->margin >= 35 ? 5 : ($branch->margin >= 25 ? 4 : ($branch->margin >= 15 ? 3 : ($branch->margin >= 5 ? 2 : 1)));
                    @endphp
                    <tr class="branch-row transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-primary/5 rounded-xl flex items-center justify-center text-primary flex-shrink-0">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <p class="text-[13px] font-black text-primary-dark">{{ $branch->name }}</p>
                                    <p class="text-[9px] font-bold text-text-secondary uppercase">ID #{{ str_pad($branch->id, 3, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 bg-primary/10 text-primary text-[11px] font-black rounded-lg">{{ $branch->stores_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-right font-black text-accent text-[13px]">{{ number_format($branch->revenue, 2) }}</td>
                        <td class="px-6 py-4 text-right font-black text-primary text-[13px]">{{ number_format($branch->expenses, 2) }}</td>
                        <td class="px-6 py-4 text-right font-black text-primary-dark text-[13px]">{{ number_format($branch->profit, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-[10px] font-black rounded-lg {{ $branch->margin >= 20 ? 'bg-accent/10 text-accent' : ($branch->margin >= 10 ? 'bg-secondary/10 text-secondary' : 'bg-primary/10 text-primary') }}">
                                {{ number_format($branch->margin, 1) }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $stars ? '-fill star-fill' : ' star-empty' }} text-xs"></i>
                                @endfor
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center opacity-40">
                                <i class="bi bi-diagram-3 text-4xl mb-2 text-primary"></i>
                                <span class="text-[12px] font-bold italic">No branch data available for this period.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($branches->count())
                <tfoot class="bg-primary/5 border-t-2 border-primary/20">
                    <tr class="text-[12px] font-black">
                        <td class="px-6 py-4 text-primary-dark uppercase tracking-wider">Network Total</td>
                        <td class="px-6 py-4 text-center text-primary-dark">{{ $branches->sum('stores_count') }}</td>
                        <td class="px-6 py-4 text-right text-accent">{{ number_format($stats['total_revenue'], 2) }}</td>
                        <td class="px-6 py-4 text-right text-primary">{{ number_format($stats['total_expenses'], 2) }}</td>
                        <td class="px-6 py-4 text-right text-primary-dark">{{ number_format($stats['total_profit'], 2) }}</td>
                        <td class="px-6 py-4 text-center text-primary">{{ number_format($netMargin, 1) }}%</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('branchChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @js($branches->pluck('name')),
            datasets: [
                { label: 'Revenue', data: @js($branches->pluck('revenue')), backgroundColor: '#99CC33', borderRadius: 6, barPercentage: 0.6 },
                { label: 'Expenses', data: @js($branches->pluck('expenses')), backgroundColor: '#e11d48', borderRadius: 6, barPercentage: 0.6 },
                { label: 'Profit', data: @js($branches->pluck('profit')), backgroundColor: '#004161', borderRadius: 6, barPercentage: 0.6 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#004161', titleFont: { size: 11, weight: 'bold' }, bodyFont: { size: 10 }, padding: 12,
                    callbacks: { label: ctx => ' ' + ctx.dataset.label + ': ' + parseFloat(ctx.raw).toLocaleString() + ' {{ $company->currency ?? "SAR" }}' }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2,2], color: '#f1f5f9' }, ticks: { font: { size: 9, weight: 'bold' }, color: '#64748b' } },
                x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#64748b' } }
            }
        }
    });
});
</script>
@endpush


