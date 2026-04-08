@extends('admin.admin_master')
@section('page_title', 'Sale/Purchase by Category')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container">
    
    <!-- Page Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Sale/Purchase By Item Category</h1>
            <p class="report-premium-subtitle">Comprehensive performance analytics across product categories</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <button class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <!-- Sale Qty -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Sale Qty</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->sale_qty) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1"><i class="bi bi-arrow-up-right"></i> Units Sold</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cart-check"></i>
            </div>
        </div>

        <!-- Sale Amount -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Sale Amount</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? '$' }} {{ number_format($totals->sale_amount, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Revenue Generated</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>

        <!-- Purchase Qty -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Purchase Qty</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->purchase_qty) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Units Restocked</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-box-seam"></i>
            </div>
        </div>

        <!-- Purchase Amount -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Purchase Amount</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? '$' }} {{ number_format($totals->purchase_amount, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Inventory Cost</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-wallet2"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <form action="{{ route('reports.sale_purchase_by_item_category') }}" method="GET" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group flex-1">
            <span class="report-premium-filter-label">Category</span>
            <select name="category_id" class="report-premium-filter-input">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $filters['category_id'] == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">From Date</span>
            <input type="date" name="from_date" value="{{ $filters['from_date'] }}" class="report-premium-filter-input">
        </div>
        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">To Date</span>
            <input type="date" name="to_date" value="{{ $filters['to_date'] }}" class="report-premium-filter-input">
        </div>
        <button type="submit" class="report-premium-btn-primary h-10">
            <i class="bi bi-search text-xs"></i> FILTER
        </button>
    </form>

    <!-- Analysis Table -->
    <div class="report-premium-card overflow-hidden">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Category-wise Analysis</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black text-[9px] uppercase tracking-widest px-3">
                {{ $dataset->filter(fn($item) => $item->sale_qty > 0 || $item->purchase_qty > 0)->count() }} Active Categories
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="!text-[10px] font-black uppercase tracking-widest w-1/4">Item Category</th>
                        <th class="!text-[10px] font-black uppercase tracking-widest text-center">Sale Qty</th>
                        <th class="!text-[10px] font-black uppercase tracking-widest text-right">Sale Amount ({{ $company->currency ?? '$' }})</th>
                        <th class="!text-[10px] font-black uppercase tracking-widest text-center">Purchase Qty</th>
                        <th class="!text-[10px] font-black uppercase tracking-widest text-right">Purchase Amount ({{ $company->currency ?? '$' }})</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-[11.5px]">
                    @forelse($dataset as $item)
                        @if($item->sale_qty > 0 || $item->purchase_qty > 0)
                            <tr class="hover:bg-gray-50/50">
                                <td class="font-bold text-primary-dark">{{ $item->name }}</td>
                                <td class="text-center font-medium">{{ number_format($item->sale_qty) }}</td>
                                <td class="text-right font-mono font-bold text-primary">{{ number_format($item->sale_amount, 2) }}</td>
                                <td class="text-center font-medium">{{ number_format($item->purchase_qty) }}</td>
                                <td class="text-right font-mono font-bold text-primary-dark">{{ number_format($item->purchase_amount, 2) }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-text-secondary">No data found for the selected criteria</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="!bg-brand-bg/50">
                        <td class="font-black text-primary-dark uppercase">Grand Total</td>
                        <td class="text-center font-black">{{ number_format($totals->sale_qty) }}</td>
                        <td class="text-right font-mono font-black text-primary">{{ number_format($totals->sale_amount, 2) }}</td>
                        <td class="text-center font-black">{{ number_format($totals->purchase_qty) }}</td>
                        <td class="text-right font-mono font-black text-primary-dark">{{ number_format($totals->purchase_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>
@endsection

