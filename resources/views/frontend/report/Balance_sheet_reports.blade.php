@extends('admin.admin_master')
@section('page_title', 'Balance Sheet')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container">
    
    <!-- Page Header -->
    <div class="report-premium-header">
        <div>
            <h1 class="report-premium-title">Balance Sheet</h1>
            <p class="report-premium-subtitle">Financial Position Statement as of {{ \Carbon\Carbon::parse($filters['as_of_date'])->format('d M Y') }}</p>
        </div>
        <div class="flex items-center gap-2 no-print">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <a href="{{ route('reports.balance_sheet.pdf', request()->query()) }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Assets</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totalAssets, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Current + Fixed</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-building"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Current Assets</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($currentAssets, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Liquid Assets</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-wallet2"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Liabilities</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totalLiabilities, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Current Liabilities</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-shield"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Owner's Equity</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totalEquity, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Net Worth</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-pie-chart"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('reports.balance_sheet') }}" method="GET" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group">
            <span class="report-premium-filter-label">As On Date</span>
            <input type="date" name="as_of_date" value="{{ $filters['as_of_date'] }}" class="report-premium-filter-input">
        </div>

        <div class="report-premium-filter-group">
            <span class="report-premium-filter-label">Comparison Date</span>
            <select name="comparison_date" class="report-premium-filter-input">
                <option value="">No Comparison</option>
            </select>
        </div>

        <div class="report-premium-filter-group">
            <span class="report-premium-filter-label">Detail Level</span>
            <select name="detail_level" class="report-premium-filter-input">
                <option value="detailed">Detailed View</option>
                <option value="summary">Summary View</option>
            </select>
        </div>

        <button type="submit" class="report-premium-btn-primary">
            <i class="bi bi-funnel"></i> 
            Generate Report
        </button>
    </form>

    <!-- Balance Sheet Card -->
    <div class="report-premium-card overflow-hidden !mb-8">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Statement of Financial Position</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-success !rounded-full !px-4 italic font-black uppercase text-[9px] tracking-widest">
                Assets = Liabilities + Equity ✓
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table !border-0">
                <thead>
                    <tr class="!bg-slate-50">
                        <th class="!bg-transparent text-primary-dark border-r border-gray-100" style="width: 35%;">ASSETS (USES OF FUNDS)</th>
                        <th class="!bg-transparent text-right text-primary-dark border-r border-gray-200" style="width: 15%;">AMOUNT</th>
                        <th class="!bg-transparent text-primary-dark" style="width: 35%;">LIABILITIES & EQUITY (SOURCES)</th>
                        <th class="!bg-transparent text-right text-primary-dark" style="width: 15%;">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $assetRows = $assets->values();
                        $liabilitiesRows = $liabilities->values();
                        $equityRows = $equityAccounts->values();
                        
                        // Combine liabilities and equity for the right side
                        $rightSide = $liabilitiesRows->concat($equityRows);
                        // Add Net Income row to right side
                        $rightSide->push((object)['name' => 'Retained Earnings (Net Income)', 'balance' => $netIncome, 'is_net_income' => true]);
                        
                        $maxRows = max($assetRows->count(), $rightSide->count());
                    @endphp

                    @for($i = 0; $i < $maxRows; $i++)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <!-- Left Side: Assets -->
                            @if(isset($assetRows[$i]))
                                <td class="px-5 py-3 border-r border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-primary rounded-full opacity-30 shadow-[0_0_8px_rgba(0,65,97,0.5)]"></div>
                                        <span class="text-[13px] font-bold text-primary-dark">{{ $assetRows[$i]->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-right font-mono text-[12px] font-black text-gray-700 border-r border-gray-200 bg-brand-bg/5">
                                    {{ number_format($assetRows[$i]->balance, 2) }}
                                </td>
                            @else
                                <td class="border-r border-gray-100 bg-brand-bg/[0.02]"></td>
                                <td class="border-r border-gray-200 bg-brand-bg/[0.02]"></td>
                            @endif

                            <!-- Right Side: Liabilities & Equity -->
                            @if(isset($rightSide[$i]))
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-{{ isset($rightSide[$i]->is_net_income) ? 'success' : 'primary' }} rounded-full opacity-30 shadow-[0_0_8px_rgba(153,204,51,0.5)]"></div>
                                        <span class="text-[13px] font-bold text-primary-dark">{{ $rightSide[$i]->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-right font-mono text-[12px] font-black text-gray-700 bg-brand-bg/5">
                                    {{ number_format($rightSide[$i]->balance, 2) }}
                                </td>
                            @else
                                <td class="bg-brand-bg/[0.02]"></td>
                                <td class="bg-brand-bg/[0.02]"></td>
                            @endif
                        </tr>
                    @endfor
                </tbody>
                <tfoot class="bg-primary/5">
                    <tr class="font-black text-primary-dark border-t-2 border-primary/20">
                        <td class="px-6 py-4 text-xs tracking-widest border-r border-gray-100">TOTAL ASSETS</td>
                        <td class="px-6 py-4 text-right font-mono text-sm border-r border-gray-200 bg-primary/10">{{ number_format($totalAssets, 2) }}</td>
                        <td class="px-6 py-4 text-xs tracking-widest">TOTAL LIABILITIES & EQUITY</td>
                        <td class="px-6 py-4 text-right font-mono text-sm bg-primary/10">{{ number_format($totalLiabilitiesEquity, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Integrity Summary -->
    <div class="bg-accent/10 border border-accent/20 rounded-2xl p-6 text-center shadow-inner no-print">
        <div class="flex items-center justify-center gap-3 mb-2">
            <i class="bi bi-patch-check-fill text-accent text-2xl"></i>
            <h3 class="text-accent font-black uppercase tracking-widest text-sm">Financial Integrity Confirmed</h3>
        </div>
        <p class="text-accent/70 text-xs font-bold leading-relaxed max-w-2xl mx-auto">
            Standard Accounting Equation is satisfied: <br>
            <span class="text-primary-dark">Assets ({{ number_format($totalAssets, 2) }})</span> = 
            <span class="text-primary">Liabilities ({{ number_format($totalLiabilities, 2) }})</span> + 
            <span class="text-primary">Equity ({{ number_format($totalEquity, 2) }})</span>
        </p>
    </div>
</div>
@endsection

