@extends('admin.admin_master')
@section('page_title', 'Cash Flow')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container">
    
    <!-- Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Cash & Bank Management</h1>
            <p class="report-premium-subtitle">Live tracking of your liquidity and fund movements</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <a href="{{ route('reports.cash_flow.pdf', request()->query()) }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Summary Row -->
    <!-- Liquidity Summary -->
    <div class="report-premium-stat-grid">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Cash In</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totals->inflow, 0) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Receipts collected</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-down-circle"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Cash Out</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totals->outflow, 0) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Payments disbursed</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-up-circle"></i>
            </div>
        </div>
        @php $netFlow = $totals->inflow - $totals->outflow; @endphp
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Net Cash Flow</p>
                <h3 class="text-[18px] font-black text-primary">
                    {{ $company->currency ?? 'SAR' }} {{ number_format($netFlow, 0) }}
                </h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">{{ $netFlow >= 0 ? 'Positive Surplus' : 'Negative Deficit' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Cash on Hand</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totals->closing_balance, 0) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Closing balance</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-wallet2"></i>
            </div>
        </div>
    </div>

    <!-- Full-Width Horizontal Filter Bar -->
    <!-- Filter Bar -->
    <form action="{{ route('reports.cash_flow') }}" method="GET" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">From Date</span>
            <input type="date" name="from_date" value="{{ $filters['from_date'] }}" class="report-premium-filter-input">
        </div>
        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">To Date</span>
            <input type="date" name="to_date" value="{{ $filters['to_date'] }}" class="report-premium-filter-input">
        </div>
        <div class="report-premium-filter-group flex-1 min-w-[260px]">
            <span class="report-premium-filter-label">Liquidity Account</span>
            <select name="account_id" class="report-premium-filter-input">
                <option value="all" {{ ($filters['account_id'] ?? '') == 'all' ? 'selected' : '' }}>All Consolidated Cash Accounts</option>
                @foreach($allCashAccounts as $acc)
                    <option value="{{ $acc->id }}" {{ ($filters['account_id'] ?? '') == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="report-premium-btn-primary h-[38px] mt-auto">
            <i class="bi bi-bar-chart"></i> Generate
        </button>
    </form>

    <!-- Table Details -->
    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden mb-6">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Liquid Asset Master Ledger</h4>
            </div>
            <div class="flex items-center gap-2">
                <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black uppercase tracking-widest text-[9px]">Consolidated Fund View</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="w-1/3">Fund / Account Hierarchy</th>
                        <th class="text-center w-32">Classification</th>
                        <th class="text-right">Opening Balance</th>
                        <th class="text-right">Cash Inflow (+)</th>
                        <th class="text-right">Cash Outflow (-)</th>
                        <th class="text-right">Net Liquidity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reportData as $data)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-[13px] font-black text-primary-dark uppercase tracking-tight">{{ $data->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $badgeClass = match($data->type) {
                                    'cash' => 'warning',
                                    'bank' => 'info',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="report-premium-badge report-premium-badge-{{ $badgeClass }} !rounded-full italic font-black text-[9px] uppercase tracking-widest">{{ $data->type }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[12px] font-black font-mono text-gray-400 italic">
                                {{ number_format($data->opening_balance, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[13px] font-black font-mono text-accent tracking-tighter">
                                {{ number_format($data->inflow, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[13px] font-black font-mono text-primary tracking-tighter">
                                {{ number_format($data->outflow, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right bg-brand-bg/5">
                            <span class="text-[14px] font-black font-mono text-primary tracking-tighter">
                                {{ number_format($data->closing_balance, 2) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400 font-bold uppercase text-[10px] tracking-widest">
                            No cash or bank accounts detected in hierarchy
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-primary/5">
                    <tr class="font-black text-primary-dark border-t-2 border-primary/20">
                        <td colspan="2" class="px-6 py-5 text-center">
                            <span class="text-[11px] font-black uppercase tracking-[0.2em] italic text-primary-dark opacity-70">Global Asset Consolidation</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Net Open</span>
                            <span class="text-[14px] font-mono text-gray-400 italic leading-none">{{ number_format($totals->opening_balance, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Total Inflow</span>
                            <span class="text-[14px] font-mono text-accent italic leading-none">+{{ number_format($totals->inflow, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Total Outflow</span>
                            <span class="text-[14px] font-mono text-primary italic leading-none">-{{ number_format($totals->outflow, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right bg-brand-bg/5">
                             <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Net Position</span>
                             <span class="text-[16px] font-mono text-primary leading-none tracking-tighter">{{ number_format($totals->closing_balance, 2) }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection

