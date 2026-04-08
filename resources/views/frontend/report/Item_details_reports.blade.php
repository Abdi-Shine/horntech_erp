@extends('admin.admin_master')
@section('page_title', 'Item Details Report')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container" x-data="{ searchTerm: '' }">
    <!-- Header Section -->
    <div class="report-premium-header">
        <div>
            <h1 class="report-premium-title">Item Details Report</h1>
            <p class="report-premium-subtitle">Comprehensive inventory transaction history</p>
        </div>
        <div class="flex items-center gap-3 no-print">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer"></i>
                Print
            </button>
            <a href="{{ route('reports.items_details.pdf', request()->all()) }}" class="report-premium-btn-accent">
                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF
            </a>
        </div>
    </div>

    @if($selectedProduct)
        <!-- Stats Section -->
        <div class="report-premium-stat-grid">
            <!-- Sales -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Total Sales</p>
                    <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->sales) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Units sold in period</p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-graph-down-arrow"></i>
                </div>
            </div>

            <!-- Purchases -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Total Purchases</p>
                    <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->purchases) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Units acquired in period</p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-cart-check"></i>
                </div>
            </div>

            <!-- Stock Adjustments -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Adjustments</p>
                    <h3 class="text-[18px] font-black text-primary">{{ $totals->adjustments >= 0 ? '+' : '' }}{{ number_format($totals->adjustments) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Internal corrections</p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-sliders2"></i>
                </div>
            </div>

            <!-- Net Movement -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Net Movement</p>
                    <h3 class="text-[18px] font-black text-primary">{{ ($totals->closing - $totals->opening) >= 0 ? '+' : '' }}{{ number_format($totals->closing - $totals->opening) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Periodic stock delta</p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-arrow-left-right text-lg"></i>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter Bar -->
    <form action="{{ route('reports.items_details') }}" method="GET" class="report-premium-filter-bar no-print flex flex-1 items-center flex-wrap gap-3">
        <!-- Search Results (Client-side) -->
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <i class="bi bi-search text-text-secondary text-[12px]"></i>
            <input type="text" x-model="searchTerm" placeholder="Search in results..." class="report-premium-filter-input">
        </div>

        <!-- Product Select -->
        <div class="report-premium-filter-group flex-[2] min-w-[300px]">
            <i class="bi bi-box-seam text-text-secondary text-sm"></i>
            <select name="product_id" required onchange="this.form.submit()" class="report-premium-filter-input">
                <option value="">Choose a product...</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected($filters['product_id'] == $product->id)>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date From -->
        <div class="report-premium-filter-group w-auto min-w-[170px]">
            <span class="report-premium-filter-label">From</span>
            <input type="date" name="from_date" value="{{ $filters['from_date'] }}" class="report-premium-filter-input">
        </div>

        <!-- Date To -->
        <div class="report-premium-filter-group w-auto min-w-[170px]">
            <span class="report-premium-filter-label">To</span>
            <input type="date" name="to_date" value="{{ $filters['to_date'] }}" class="report-premium-filter-input">
        </div>

        <!-- Load Button -->
        <button type="submit" class="report-premium-btn-primary h-[38px] mt-auto">
            <i class="bi bi-arrow-repeat"></i>
            Load
        </button>
    </form>

    @if($selectedProduct)
        <!-- Transaction Table Section -->
        <div class="report-premium-card overflow-hidden">
            <!-- Table Title Bar -->
            <div class="px-5 py-4 border-b border-brand-border flex items-center justify-between bg-brand-bg/10">
                <div class="flex items-center gap-2">
                    <i class="bi bi-list-ul text-primary text-sm"></i>
                    <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Daily Transaction History</h4>
                </div>
                <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black text-[9px] uppercase tracking-widest">
                    {{ date('M d', strtotime($filters['from_date'])) }} — {{ date('M d, Y', strtotime($filters['to_date'])) }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="report-premium-table">
                    <thead>
                        <tr class="bg-white border-b border-gray-100">
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Transaction Date</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">Sales (-)</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">Purchases (+)</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">Adjustments</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">Balance</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Opening -->
                        <tr class="hover:bg-gray-50/60 transition-colors bg-white group bg-slate-50/30">
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark"><span class="font-bold text-gray-800">Opening Balance</span></td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right text-gray-400">—</td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right text-gray-400">—</td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right text-gray-400">—</td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right font-black text-primary-dark">{{ number_format($totals->opening) }}</td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center"><span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Brought Forward</span></td>
                        </tr>
                        @foreach($dataset as $row)
                        <tr x-show="searchTerm === '' ||
                                   '{{ strtolower($row->type) }}'.includes(searchTerm.toLowerCase()) ||
                                   '{{ date('d M, Y', strtotime($row->date)) }}'.toLowerCase().includes(searchTerm.toLowerCase())"
                            class="hover:bg-gray-50/60 transition-colors bg-white group">
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark"><strong>{{ date('d M, Y', strtotime($row->date)) }}</strong></td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right text-primary font-bold">{{ $row->type == 'Sale' ? number_format(abs($row->quantity)) : '0' }}</td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right text-accent font-bold">{{ $row->type == 'Purchase' ? number_format(abs($row->quantity)) : '0' }}</td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right">{{ !in_array($row->type, ['Sale', 'Purchase']) ? ($row->quantity >= 0 ? '+' : '') . number_format($row->quantity) : '0' }}</td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right font-black text-primary">{{ number_format($row->closing) }}</td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                                <span class="report-premium-badge {{ strtolower($row->type) == 'sale' ? 'report-premium-badge-error' : (strtolower($row->type) == 'purchase' ? 'report-premium-badge-success' : 'report-premium-badge-info') }}">
                                    @if(strtolower($row->type) == 'sale')
                                        <i class="bi bi-dash-circle-fill"></i> Sale
                                    @elseif(strtolower($row->type) == 'purchase')
                                        <i class="bi bi-plus-circle-fill"></i> Purchase
                                    @else
                                        <i class="bi bi-gear-fill"></i> Update
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="font-black">TOTAL PERIOD ACTIVITY</td>
                            <td class="text-right text-primary font-black">-{{ number_format($totals->sales) }}</td>
                            <td class="text-right text-accent font-black">+{{ number_format($totals->purchases) }}</td>
                            <td class="text-right font-black">{{ $totals->adjustments >= 0 ? '+' : '' }}{{ number_format($totals->adjustments) }}</td>
                            <td class="text-right font-black text-primary-dark text-[15px]">{{ number_format($totals->closing) }} UNITS</td>
                            <td class="text-center"><span class="text-[10px] font-bold text-primary bg-slate-100 rounded px-2 py-0.5 uppercase">{{ $dataset->count() }} Txn</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @else
        <!-- Empty State (Matching Customer style) -->
        <div class="bg-white rounded-[1.5rem] border border-gray-200 border-dashed p-20 flex flex-col items-center text-center mt-10">
            <div class="w-20 h-20 bg-slate-50 rounded-[1.5rem] flex items-center justify-center text-primary-dark mb-6">
                <i class="bi bi-search text-3xl"></i>
            </div>
            <h3 class="text-[20px] font-bold text-primary-dark mb-2">Ready to generate report?</h3>
            <p class="text-[13px] text-gray-400 max-w-sm font-medium leading-relaxed">
                Select a product and duration from the filter bar above to analyze your inventory movements and stocks.
            </p>
        </div>
    @endif
</div>
@endsection

