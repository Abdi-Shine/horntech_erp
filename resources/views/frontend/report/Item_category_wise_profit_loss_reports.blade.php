@extends('admin.admin_master')
@section('page_title', 'Item Category P&L')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container">

    <!-- Page Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Item Category Wise Profit & Loss</h1>
            <p class="report-premium-subtitle">Profitability analysis grouped by product categories</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <a href="{{ route('reports.item_category_wise_profit_loss.pdf', ['from_date' => $filters['from_date'], 'to_date' => $filters['to_date']]) }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid !grid-cols-2 lg:!grid-cols-5">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Categories</p>
                <h3 class="text-[18px] font-black text-primary">{{ $totals->count }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Total Listed</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-grid"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Sale Qty</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->saleQty) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Units Sold</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cart-check"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Sales</p>
                <h3 class="text-[18px] font-black text-primary">{{ ($company->currency ?? 'SAR') }} {{ number_format($totals->saleAmount, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Revenue</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Purchases</p>
                <h3 class="text-[18px] font-black text-primary">{{ ($company->currency ?? 'SAR') }} {{ number_format($totals->purchaseAmount, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Cost</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cart3"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Net Profit</p>
                <h3 class="text-[18px] font-black text-primary">
                    {{ ($company->currency ?? 'SAR') }} {{ number_format($totals->netProfit, 2) }}
                </h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                    {{ $totals->netProfit >= 0 ? 'Profit' : 'Loss' }}
                </p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-{{ $totals->netProfit >= 0 ? 'graph-up-arrow' : 'graph-down-arrow' }}"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('reports.item_category_wise_profit_loss') }}" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group w-auto min-w-[160px]">
            <span class="report-premium-filter-label">From Date</span>
            <input type="date" name="from_date" value="{{ $filters['from_date'] }}" class="report-premium-filter-input">
        </div>
        <div class="report-premium-filter-group w-auto min-w-[160px]">
            <span class="report-premium-filter-label">To Date</span>
            <input type="date" name="to_date" value="{{ $filters['to_date'] }}" class="report-premium-filter-input">
        </div>
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <span class="report-premium-filter-label">Search Category</span>
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by category name..." class="report-premium-filter-input !pl-9">
            </div>
        </div>
        <button type="submit" class="report-premium-btn-primary h-[38px] mt-auto">
            <i class="bi bi-bar-chart"></i> Generate
        </button>
    </form>

    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden mb-6">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Category Wise Profitability Analysis</h4>
            </div>
            <div class="flex items-center gap-2">
                <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black uppercase tracking-widest text-[9px]">{{ count($dataset) }} Categories Parsed</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="text-center w-12"></th>
                        <th>Category / Project</th>
                        <th class="text-right">Sale Qty</th>
                        <th class="text-right">Sale Amount</th>
                        <th class="text-right">Purchase Qty</th>
                        <th class="text-right">Purchase Amount</th>
                        <th class="text-right">Net P&L</th>
                    </tr>
                </thead>
                @foreach($dataset as $category)
                <tbody x-data="{ expanded: false }" class="divide-y divide-gray-100">
                    <!-- Category Level Row -->
                        <tr class="bg-primary/[0.03] hover:bg-primary/[0.08] transition-colors cursor-pointer" @click="expanded = !expanded">
                            <td class="px-5 py-4 text-center">
                                <i class="bi text-primary text-sm transition-transform duration-300 inline-block" 
                                   :class="expanded ? 'rotate-90' : ''">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                   </svg>
                                </i>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-primary/20 text-primary flex items-center justify-center">
                                        <i class="bi bi-folder-fill text-xs"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-primary-dark uppercase tracking-tight">{{ $category->name }}</span>
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">{{ count($category->items) }} ITEMS NESTED</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-[13px] font-black font-mono {{ $category->totals->saleQty > 0 ? 'text-primary' : 'text-gray-300' }}">
                                    {{ $category->totals->saleQty > 0 ? number_format($category->totals->saleQty) : '0' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-[13px] font-black font-mono {{ $category->totals->saleAmount > 0 ? 'text-accent' : 'text-gray-300' }}">
                                    {{ $category->totals->saleAmount > 0 ? number_format($category->totals->saleAmount, 2) : '0.00' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-[13px] font-black font-mono {{ $category->totals->purchaseQty > 0 ? 'text-primary' : 'text-gray-300' }}">
                                    {{ $category->totals->purchaseQty > 0 ? number_format($category->totals->purchaseQty) : '0' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-[13px] font-black font-mono {{ $category->totals->purchaseAmount > 0 ? 'text-primary' : 'text-gray-300' }}">
                                    {{ $category->totals->purchaseAmount > 0 ? number_format($category->totals->purchaseAmount, 2) : '0.00' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                @php $catProfit = $category->totals->netProfit; @endphp
                                <span class="report-premium-badge !rounded-full !text-[10px] font-black tracking-tighter italic {{ $catProfit > 0 ? 'report-premium-badge-success' : ($catProfit < 0 ? 'report-premium-badge-error' : 'bg-gray-100 text-gray-400 border-gray-200') }}">
                                    <i class="bi bi-{{ $catProfit > 0 ? 'graph-up' : ($catProfit < 0 ? 'graph-down' : 'dash') }} mr-1"></i>
                                    {{ number_format(abs($catProfit), 2) }}
                                </span>
                            </td>
                        </tr>

                        <!-- Item Level Detail Rows -->
                        @foreach($category->items as $item)
                        <tr x-show="expanded" x-collapse x-cloak
                            class="bg-white hover:bg-gray-50/50 transition-colors border-l-4 border-l-primary/30">
                            <td class="px-5 py-3 text-center opacity-30">
                                <span class="text-[9px] font-black text-gray-400">{{ $loop->iteration }}</span>
                            </td>
                            <td class="px-5 py-3 pl-12">
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-black text-gray-700">{{ $item->name }}</span>
                                    @if($item->code)
                                        <span class="text-[9px] text-gray-400 font-mono tracking-tighter opacity-80 leading-none">REF: {{ $item->code }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <span class="text-[11px] font-black font-mono text-gray-500 italic">
                                    {{ $item->saleQty > 0 ? number_format($item->saleQty) : '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <span class="text-[11px] font-black font-mono text-gray-600">
                                    {{ $item->saleAmount > 0 ? number_format($item->saleAmount, 2) : '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <span class="text-[11px] font-black font-mono text-gray-500 italic">
                                    {{ $item->purchaseQty > 0 ? number_format($item->purchaseQty) : '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <span class="text-[11px] font-black font-mono text-gray-600">
                                    {{ $item->purchaseAmount > 0 ? number_format($item->purchaseAmount, 2) : '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                @php $profit = $item->netProfit; @endphp
                                <span class="text-[11px] font-black font-mono {{ $profit > 0 ? 'text-accent' : ($profit < 0 ? 'text-primary' : 'text-gray-300') }}">
                                    {{ $profit >= 0 ? '+' : '-' }}{{ number_format(abs($profit), 2) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endforeach
                    @if(count($dataset) == 0)
                    <tbody>
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="bi bi-inbox text-3xl text-gray-200"></i>
                                    </div>
                                    <p class="text-sm font-black text-gray-400 uppercase tracking-widest italic">No category data found for the selected period.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    @endif
                @if(count($dataset) > 0)
                <tfoot class="bg-primary/5">
                    <tr class="border-t-2 border-primary/20">
                        <td colspan="2" class="px-5 py-5 text-center">
                            <span class="text-[11px] font-black text-primary-dark uppercase tracking-[0.2em] italic">Consolidated Grand Totals</span>
                        </td>
                        <td class="px-5 py-5 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Total Units</span>
                            <span class="text-[14px] font-black text-primary font-mono leading-none tracking-tighter">{{ number_format($totals->saleQty) }}</span>
                        </td>
                        <td class="px-5 py-5 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Sales Rev.</span>
                            <span class="text-[14px] font-black text-accent font-mono leading-none tracking-tighter">{{ ($company->currency ?? 'SAR') }} {{ number_format($totals->saleAmount, 2) }}</span>
                        </td>
                        <td class="px-5 py-5 text-right border-l border-gray-100">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Total Purch.</span>
                            <span class="text-[14px] font-black text-primary font-mono leading-none tracking-tighter">{{ number_format($totals->purchaseQty) }}</span>
                        </td>
                        <td class="px-5 py-5 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Purchase Cost</span>
                            <span class="text-[14px] font-black text-primary font-mono leading-none tracking-tighter">{{ ($company->currency ?? 'SAR') }} {{ number_format($totals->purchaseAmount, 2) }}</span>
                        </td>
                        <td class="px-5 py-5 text-right border-l border-gray-100 bg-brand-bg/5">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Net P&L</span>
                            <span class="text-[15px] font-black font-mono leading-none tracking-tighter {{ $totals->netProfit >= 0 ? 'text-accent' : 'text-primary' }}">
                                {{ ($company->currency ?? 'SAR') }} {{ number_format($totals->netProfit, 2) }}
                            </span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>
@endsection

