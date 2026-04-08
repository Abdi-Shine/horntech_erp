@extends('admin.admin_master')
@section('page_title', 'Profit & Loss')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container">
    
    <!-- Page Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Profit & Loss Statement</h1>
            <p class="report-premium-subtitle">Performance tracking for {{ $company->name }}</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <a href="{{ route('reports.profit_loss.pdf', request()->query()) }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <!-- Total Revenue -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Revenue</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalRevenue, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1"><i class="bi bi-graph-up text-[10px]"></i> {{ $company->currency ?? '$' }} Sales</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-bar-chart-line"></i>
            </div>
        </div>

        <!-- Gross Profit -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Gross Profit</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($grossProfit, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">{{ $totalRevenue > 0 ? number_format(($grossProfit/$totalRevenue)*100, 1) : 0 }}% Margin</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>

        <!-- Expenses -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Expenses</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalExpenses, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">{{ $totalRevenue > 0 ? number_format(($totalExpenses/$totalRevenue)*100, 1) : 0 }}% of Rev</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Net Profit</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($netProfit, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">{{ $totalRevenue > 0 ? number_format(($netProfit/$totalRevenue)*100, 1) : 0 }}% Net Margin</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-trophy"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section (One Row Style) -->
    <form action="{{ route('reports.profit_loss') }}" method="GET" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <span class="report-premium-filter-label">Period Description</span>
            <div class="flex items-center gap-2 text-xs font-bold text-primary-dark bg-brand-bg/5 px-3 py-2 rounded-lg border border-brand-bg/10">
                <i class="bi bi-calendar3"></i>
                {{ \Carbon\Carbon::parse($filters['from_date'])->format('d M Y') }} — {{ \Carbon\Carbon::parse($filters['to_date'])->format('d M Y') }}
            </div>
        </div>

        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">From Date</span>
            <input type="date" name="from_date" value="{{ $filters['from_date'] }}" class="report-premium-filter-input">
        </div>

        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">To Date</span>
            <input type="date" name="to_date" value="{{ $filters['to_date'] }}" class="report-premium-filter-input">
        </div>

        <button type="submit" class="report-premium-btn-primary h-[38px] mt-auto">
            <i class="bi bi-arrow-clockwise text-sm"></i>
            Update 
        </button>
    </form>

    <!-- Financial Statement Table -->
    <div class="report-premium-card overflow-hidden mb-6">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Financial Statement Details</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black uppercase tracking-widest text-[9px]">
                {{ \Carbon\Carbon::parse($filters['from_date'])->format('M d') }} — {{ \Carbon\Carbon::parse($filters['to_date'])->format('M d, Y') }}
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr class="!bg-white">
                        <th class="!text-[10px] font-black uppercase tracking-widest w-1/2">Account Category</th>
                        <th class="!text-[10px] font-black uppercase tracking-widest text-right">Amount ({{ $company->currency ?? '$' }})</th>
                        <th class="!text-[10px] font-black uppercase tracking-widest text-right">% of Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <!-- REVENUE SECTION -->
                    <tr class="!bg-brand-bg/5">
                        <td colspan="3" class="px-5 py-2.5 text-[11px] font-black text-primary uppercase tracking-widst">Operating Income</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-3 text-[13px] font-bold text-primary-dark pl-10 border-l-2 border-primary/20">Sales Revenue</td>
                        <td class="px-5 py-3 text-[13px] font-mono font-black text-primary text-right">{{ number_format($totalRevenue, 2) }}</td>
                        <td class="px-5 py-3 text-[12px] font-bold text-text-secondary text-right">100.0%</td>
                    </tr>
                    <tr class="!bg-slate-50">
                        <td class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase">Total Operating Revenue</td>
                        <td class="px-5 py-3 text-[14px] font-mono font-black text-primary text-right border-t border-primary/10">{{ number_format($totalRevenue, 2) }}</td>
                        <td class="px-5 py-4 text-[12px] font-bold text-primary text-right">100.0%</td>
                    </tr>

                    <!-- COGS SECTION -->
                    <tr class="!bg-brand-bg/5 mt-4">
                        <td colspan="3" class="px-5 py-2.5 text-[11px] font-black text-primary uppercase tracking-widst">Cost of Sales (COGS)</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-3 text-[13px] font-bold text-primary-dark pl-10 border-l-2 border-primary/20">Purchases / Direct Costs</td>
                        <td class="px-5 py-3 text-[13px] font-mono font-black text-primary-dark text-right">{{ number_format($totalCogs, 2) }}</td>
                        <td class="px-5 py-3 text-[12px] font-bold text-text-secondary text-right">{{ $totalRevenue > 0 ? number_format(($totalCogs/$totalRevenue)*100, 1) : 0 }}%</td>
                    </tr>
                    <tr class="!bg-slate-50">
                        <td class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase">Total Cost of Goods Sold</td>
                        <td class="px-5 py-3 text-[14px] font-mono font-black text-primary-dark text-right border-t border-gray-200">{{ number_format($totalCogs, 2) }}</td>
                        <td class="px-5 py-4 text-[12px] font-bold text-primary-dark text-right">{{ $totalRevenue > 0 ? number_format(($totalCogs/$totalRevenue)*100, 1) : 0 }}%</td>
                    </tr>

                    <!-- GROSS PROFIT -->
                    <tr class="bg-accent/10">
                        <td class="px-5 py-4 text-[13px] font-black text-accent uppercase tracking-wider">Gross Profit Margin</td>
                        <td class="px-5 py-4 text-[16px] font-mono font-black text-accent text-right border-y-2 border-accent/20">{{ number_format($grossProfit, 2) }}</td>
                        <td class="px-5 py-4 text-[13px] font-black text-accent text-right uppercase">{{ $totalRevenue > 0 ? number_format(($grossProfit/$totalRevenue)*100, 1) : 0 }}%</td>
                    </tr>

                    <!-- OPERATING EXPENSES SECTION -->
                    <tr class="!bg-brand-bg/5 mt-4">
                        <td colspan="3" class="px-5 py-2.5 text-[11px] font-black text-primary uppercase tracking-widst">Operating Expenses (OPEX)</td>
                    </tr>
                    @forelse($expenseDetails as $exp)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-3 text-[13px] font-bold text-primary-dark pl-10 border-l-2 border-primary/20">{{ $exp->name }}</td>
                        <td class="px-5 py-3 text-[13px] font-mono font-black text-primary text-right">{{ number_format($exp->amount, 2) }}</td>
                        <td class="px-5 py-3 text-[12px] font-bold text-text-secondary text-right">{{ number_format($exp->percent, 1) }}%</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-8 text-center text-gray-400 italic text-xs">No operating expenses found for this period</td></tr>
                    @endforelse
                    <tr class="!bg-slate-50">
                        <td class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase">Total Operating Expenses</td>
                        <td class="px-5 py-3 text-[14px] font-mono font-black text-primary-dark text-right border-t border-gray-200">{{ number_format($totalExpenses, 2) }}</td>
                        <td class="px-5 py-4 text-[12px] font-bold text-primary-dark text-right">{{ $totalRevenue > 0 ? number_format(($totalExpenses/$totalRevenue)*100, 1) : 0 }}%</td>
                    </tr>

                    <!-- NET PROFIT -->
                    <tr class="!bg-slate-100 border-t-2 border-primary/20">
                        <td class="px-5 py-5 text-[14px] font-black text-primary-dark uppercase tracking-widest">Net Profit / (Loss)</td>
                        <td class="px-5 py-5 text-[22px] font-mono font-black text-primary-dark text-right">{{ number_format($netProfit, 2) }}</td>
                        <td class="px-5 py-5 text-[14px] font-black text-primary-dark text-right">{{ $totalRevenue > 0 ? number_format(($netProfit/$totalRevenue)*100, 1) : 0 }}% Margin</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

