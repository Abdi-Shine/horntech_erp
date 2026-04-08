@extends('admin.admin_master')
@section('page_title', 'Company Overview')



@section('admin')
<div class="p-6">
    <!-- Header with Date Filter -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-primary-dark">Company Overview</h1>
            <p class="text-[13px] text-text-secondary font-medium italic">High-level performance analysis across all divisions</p>
        </div>

        <form action="{{ route('company_overview_dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="flex items-center bg-white border border-brand-border rounded-xl px-3 py-1.5 shadow-sm">
                <i class="bi bi-calendar3 text-primary mr-2 text-sm"></i>
                <select name="date_range" onchange="this.form.submit()" 
                        class="bg-transparent border-none text-[12px] font-bold text-primary-dark focus:ring-0 cursor-pointer">
                    <option value="today" {{ $dateRange == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ $dateRange == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="last_7_days" {{ $dateRange == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="last_30_days" {{ $dateRange == 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="this_month" {{ $dateRange == 'this_month' ? 'selected' : '' }}>This Month</option>
                    <option value="this_year" {{ $dateRange == 'this_year' ? 'selected' : '' }}>This Year</option>
                </select>
            </div>
            
            <button type="submit" class="bg-primary text-white text-[11px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl hover:bg-primary/90 transition-all flex items-center gap-2">
                <i class="bi bi-funnel"></i>
                Filter
            </button>
        </form>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <!-- Revenue Card -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Revenue</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['revenue'], 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ $stats['revenue_growth'] >= 0 ? '+' : '' }}{{ number_format($stats['revenue_growth'], 1) }}% vs prev. · {{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-secondary/10 rounded-[0.6rem] flex items-center justify-center text-secondary flex-shrink-0">
                <i class="bi bi-currency-dollar text-xl"></i>
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Expenses</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['expenses'], 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ $stats['expense_growth'] >= 0 ? '+' : '' }}{{ number_format($stats['expense_growth'], 1) }}% vs prev. · {{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-wallet2 text-xl"></i>
            </div>
        </div>

        <!-- Profit Card -->
        @php
            $margin = $stats['revenue'] > 0 ? ($stats['profit'] / $stats['revenue']) * 100 : 0;
        @endphp
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Net Profit</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['profit'], 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ number_format($margin, 1) }}% Margin · {{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up text-xl"></i>
            </div>
        </div>

        <!-- Branches Card -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Branches</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['branches'] }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">Operational Units</p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-diagram-3 text-xl"></i>
            </div>
        </div>

        <!-- Stores Card -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Stores</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['stores'] }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">Points of Sale</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-shop text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Revenue Trend -->
        <div class="bg-white rounded-2xl p-6 border border-brand-border shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Revenue & Expense Trend</h3>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                        <span class="text-[9px] font-bold text-text-secondary">Revenue</span>
                    </div>
                    <div class="flex items-center gap-1.5 ml-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-primary/10"></span>
                        <span class="text-[9px] font-bold text-text-secondary">Expense</span>
                    </div>
                </div>
            </div>
            <div class="h-[300px]">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>

        <!-- Monthly Profit -->
        <div class="bg-white rounded-2xl p-6 border border-brand-border shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Monthly Net Profit</h3>
                <span class="text-[10px] font-black text-primary-dark bg-primary/5 px-2 py-1 rounded">{{ now()->year }} Analysis</span>
            </div>
            <div class="h-[300px]">
                <canvas id="monthlyProfitChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-2xl border border-brand-border shadow-sm overflow-hidden min-h-[400px]">
        <div class="px-6 py-4 border-b border-brand-border flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-4 bg-primary rounded-full"></div>
                <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Recent Transactions</h3>
            </div>
            <a href="{{ route('all_reports') }}" class="text-[10px] font-black text-secondary uppercase hover:underline">View All Intelligence →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-brand-bg/20 text-[10px] font-black text-primary-dark uppercase tracking-widest border-b border-brand-border">
                    <tr>
                        <th class="px-6 py-4">Transaction Details</th>
                        <th class="px-6 py-4">Branch</th>
                        <th class="px-6 py-4 text-center">Type</th>
                        <th class="px-6 py-4 text-right">Amount</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border">
                    @forelse($recentTxns as $txn)
                    <tr class="hover:bg-brand-bg/10 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-[13px] font-black text-primary-dark uppercase tracking-tight">{{ $txn->txn_id }}</span>
                                <span class="text-[10px] text-text-secondary italic font-medium">{{ \Carbon\Carbon::parse($txn->date)->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[12px] font-bold text-primary-dark">{{ $branches[$txn->branch_id] ?? 'Inter-branch' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="report-premium-badge {{ $txn->type == 'Revenue' ? 'report-premium-badge-success' : 'report-premium-badge-error' }} !rounded-full italic font-black text-[9px]">
                                {{ $txn->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[14px] font-mono font-black {{ $txn->type == 'Revenue' ? 'text-accent' : 'text-primary' }}">
                                {{ number_format($txn->amount, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-slate-100 rounded-full text-[9px] font-black text-slate-500 uppercase italic">
                                {{ $txn->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center opacity-40">
                                <i class="bi bi-inbox text-4xl mb-2 text-primary"></i>
                                <span class="text-[12px] font-bold italic">No recent activities found for this period.</span>
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
        // Revenue trend chart
        const trendCtx = document.getElementById('revenueTrendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @js($chartData->pluck('label')),
                datasets: [
                    {
                        label: 'Revenue',
                        data: @js($chartData->pluck('revenue')),
                        borderColor: '#99CC33',
                        backgroundColor: 'rgba(153, 204, 51, 0.05)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#99CC33',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    },
                    {
                        label: 'Expenses',
                        data: @js($chartData->pluck('expenses')),
                        borderColor: '#e11d48',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.4,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: { borderDash: [2, 2], color: '#f1f5f9' },
                        ticks: { font: { size: 9, weight: 'bold' }, color: '#64748b' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9, weight: 'bold' }, color: '#64748b' }
                    }
                }
            }
        });

        // Monthly Profit Chart
        const profitCtx = document.getElementById('monthlyProfitChart').getContext('2d');
        const profitGradient = profitCtx.createLinearGradient(0, 0, 0, 400);
        profitGradient.addColorStop(0, 'rgba(0, 65, 97, 0.2)');
        profitGradient.addColorStop(1, 'rgba(0, 65, 97, 0)');

        new Chart(profitCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Net Profit',
                    data: @js($monthlyProfit),
                    backgroundColor: (context) => {
                        const val = context.raw;
                        return val >= 0 ? '#99CC33' : '#e11d48';
                    },
                    borderRadius: 6,
                    barThickness: 12
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        grid: { borderDash: [2, 2], color: '#f1f5f9' },
                        ticks: { font: { size: 9, weight: 'bold' }, color: '#64748b' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9, weight: 'bold' }, color: '#64748b' }
                    }
                }
            }
        });
    });
</script>
@endpush


