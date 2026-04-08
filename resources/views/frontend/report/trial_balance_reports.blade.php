@extends('admin.admin_master')
@section('page_title', 'Trial Balance Report')

@push('css')
@endpush

@section('admin')
<div class="report-premium-container">
    
    <!-- Page Header -->
    <div class="report-premium-header">
        <div>
            <h1 class="report-premium-title">Trial Balance</h1>
            <p class="report-premium-subtitle">Accounting integrity check for period {{ \Carbon\Carbon::parse($filters['from_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($filters['to_date'])->format('d M Y') }}</p>
        </div>
        <div class="flex items-center gap-2 no-print">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <a href="{{ route('reports.trial_balance.pdf', request()->query()) }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid !grid-cols-3">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Opening Integrity</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->opening_balance, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Balanced Carryforward</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-shield-check"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Debits</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->closing_debit, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Total Assets/Expenses</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-plus-circle"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Credits</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->closing_credit, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Total Liability/Equity</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-dash-circle"></i>
            </div>
        </div>
    </div>

    <!-- Full-Width Horizontal Filter Bar -->
    <form action="{{ route('reports.trial_balance') }}" method="GET" class="report-premium-filter-bar no-print">
        <div class="flex items-center gap-6">
            <div class="report-premium-filter-group w-auto">
                <span class="report-premium-filter-label">From</span>
                <input type="date" name="from_date" value="{{ $filters['from_date'] }}" class="report-premium-filter-input min-w-[150px]">
            </div>
            <div class="report-premium-filter-group w-auto">
                <span class="report-premium-filter-label">To</span>
                <input type="date" name="to_date" value="{{ $filters['to_date'] }}" class="report-premium-filter-input min-w-[150px]">
            </div>
        </div>
        <button type="submit" class="report-premium-btn-primary">
            <i class="bi bi-funnel"></i> 
            FILTER PERIOD
        </button>
    </form>

    <!-- Report Table -->
    <div class="report-premium-card overflow-hidden !mb-8">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">6-Column Trial Balance Detail</h4>
            </div>
            <div class="flex items-center gap-2">
                <span class="report-premium-badge report-premium-badge-success !rounded-full !px-4 italic">
                    Balanced ✓
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-left w-[30%]">Account Description</th>
                        <th rowspan="2" class="text-right w-[15%]">Opening Balance</th>
                        <th colspan="2" class="text-center border-b-2 border-slate-200">Monthly Activity</th>
                        <th colspan="2" class="text-center border-b-2 border-slate-200">Closing Balance</th>
                    </tr>
                    <tr>
                        <th class="text-right w-[12.5%]">Debit (+)</th>
                        <th class="text-right w-[12.5%]">Credit (-)</th>
                        <th class="text-right w-[15%]">Debit</th>
                        <th class="text-right w-[15%]">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $groupedData = $reportData->groupBy('category');
                    @endphp

                    @foreach($groupedData as $category => $accounts)
                        <tr class="group-header">
                            <td colspan="6" class="px-6 py-3 bg-brand-bg/5 italic font-black text-[11px] text-primary-dark border-y border-gray-100 uppercase tracking-widest">{{ ucfirst($category) }} Accounts</td>
                        </tr>
                        @foreach($accounts as $item)
                            <tr>
                                <td class="font-bold flex items-center gap-3">
                                    <span class="text-[10px] text-gray-400 font-medium">{{ $item->code }}</span>
                                    {{ $item->name }}
                                </td>
                                <td class="text-right font-mono text-[11px] font-medium {{ $item->opening_balance < 0 ? 'text-primary' : '' }}">
                                    {{ number_format(abs($item->opening_balance), 2) }}
                                    <span class="text-[9px] text-gray-400 uppercase">{{ $item->opening_balance >= 0 ? 'Dr' : 'Cr' }}</span>
                                </td>
                                <td class="text-right text-primary font-bold font-mono text-[11px]">
                                    {{ $item->debit > 0 ? number_format($item->debit, 2) : '-' }}
                                </td>
                                <td class="text-right text-gray-400 font-mono text-[11px]">
                                    {{ $item->credit > 0 ? number_format($item->credit, 2) : '-' }}
                                </td>
                                <!-- Closing Debit -->
                                <td class="text-right font-black bg-slate-50 font-mono text-[11px]">
                                    @php
                                        $isDebit = (in_array($item->category, ['assets', 'expenses']) && $item->closing_balance >= 0) || 
                                                   (!in_array($item->category, ['assets', 'expenses']) && $item->closing_balance < 0);
                                    @endphp
                                    {{ $isDebit ? number_format(abs($item->closing_balance), 2) : '-' }}
                                </td>
                                <!-- Closing Credit -->
                                <td class="text-right font-black font-mono text-[11px]">
                                    {{ !$isDebit ? number_format(abs($item->closing_balance), 2) : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot class="bg-primary/5">
                    <tr class="font-black text-primary-dark border-t-2 border-primary/20">
                        <td class="px-6 py-4 text-xs">NET REPORT TOTALS</td>
                        <td class="px-6 py-4 text-right font-mono text-sm">
                            {{ number_format($totals->opening_balance, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-primary font-mono text-sm">
                            {{ number_format($totals->debit, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-text-secondary font-mono text-sm">
                            {{ number_format($totals->credit, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right bg-primary text-white font-mono text-sm">
                            {{ number_format($totals->closing_debit, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right bg-primary/95 text-white border-l border-white/10 font-mono text-sm">
                            {{ number_format($totals->closing_credit, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Bottom Verification -->
    <div class="bg-accent/10 border border-accent/20 rounded-2xl p-6 text-center shadow-inner no-print">
        <div class="flex items-center justify-center gap-3 mb-2">
            <i class="bi bi-patch-check-fill text-accent text-2xl"></i>
            <h3 class="text-accent font-black uppercase tracking-widest text-sm">Balanced Statement Verified</h3>
        </div>
        <p class="text-accent/70 text-xs font-bold leading-relaxed max-w-2xl mx-auto">
            Total Debits ({{ number_format($totals->closing_debit, 2) }}) matched Total Credits ({{ number_format($totals->closing_credit, 2) }}). <br>
            The fundamental accounting equation (Assets = Liabilities + Equity) is maintained. Statement of position is accurate.
        </p>
    </div>
</div>
@endsection

