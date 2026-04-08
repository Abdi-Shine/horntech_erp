@extends('admin.admin_master')
@section('page_title', 'Low Stock Summary')



@section('admin')
<div class="report-premium-container">

    <!-- Page Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Low Stock Summary</h1>
            <p class="report-premium-subtitle">Monitor inventory levels and identify items requiring reorder</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <a href="{{ route('reports.low_stock_summary.pdf', request()->all()) }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Critical Stock</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($criticalCount) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Out of stock or &le; 25%</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Low Stock</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($lowCount) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Between 25% &ndash; 50%</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Warning Stock</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($warningCount) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Between 50% &ndash; 100%</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-info-circle-fill"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Value at Risk</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totalValueAtRisk, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Total valuation of listed items</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('reports.low_stock_summary') }}" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group w-auto min-w-[180px]">
            <span class="report-premium-filter-label">Category</span>
            <select name="category_id" class="report-premium-filter-input">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="report-premium-filter-group w-auto min-w-[180px]">
            <span class="report-premium-filter-label">Stock Status</span>
            <select name="status" class="report-premium-filter-input">
                <option value="All" {{ ($filters['status'] ?? 'All') === 'All' ? 'selected' : '' }}>All Below Minimum</option>
                <option value="Critical" {{ ($filters['status'] ?? '') === 'Critical' ? 'selected' : '' }}>Critical (0-25%)</option>
                <option value="Low" {{ ($filters['status'] ?? '') === 'Low' ? 'selected' : '' }}>Low (25-50%)</option>
                <option value="Warning" {{ ($filters['status'] ?? '') === 'Warning' ? 'selected' : '' }}>Warning (50-100%)</option>
            </select>
        </div>
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <span class="report-premium-filter-label">Search Item</span>
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by name or code..." class="report-premium-filter-input !pl-9">
            </div>
        </div>
        <button type="submit" class="report-premium-btn-primary h-[38px] mt-auto">
            <i class="bi bi-funnel"></i> Generate
        </button>
    </form>

    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden mb-6">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Low Stock Items Inventory</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-error !rounded-full italic bg-primary/10 !text-primary !border-primary/20 font-black uppercase text-[9px] tracking-widest px-3">
                {{ number_format($totalItems) }} Items Requiring Attention
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="text-center w-12">#</th>
                        <th>Item Details</th>
                        <th>Category</th>
                        <th class="text-right">Min Qty</th>
                        <th class="text-right">Current Stock</th>
                        <th class="text-right">Stock Value</th>
                        <th class="w-48">Status & Threshold</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($dataset as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-[11px] font-black text-gray-400 text-center">{{ $loop->iteration }}</td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-primary-dark">{{ $product->product_name }}</span>
                                @if($product->product_code)
                                    <span class="text-[10px] text-gray-400 font-mono tracking-tight">{{ $product->product_code }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-tighter">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[13px] font-black font-mono text-gray-400 italic">{{ number_format($product->min_stock) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[14px] font-black font-mono {{ $product->stock_status == 'critical' ? 'text-primary' : ($product->stock_status == 'low' ? 'text-primary' : 'text-primary') }}">
                                {{ number_format($product->current_stock) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[13px] font-black font-mono text-gray-700 italic opacity-80 leading-none tracking-tight">{{ number_format($product->stock_value, 2) }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col gap-1.5 min-w-[120px]">
                                @if($product->stock_status === 'critical')
                                    <span class="report-premium-badge report-premium-badge-error !text-[9px] !py-0.5 w-fit uppercase font-black tracking-widest italic">CRITICAL ({{ $product->percentage }}%)</span>
                                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary/10" style="width: {{ min(100, $product->percentage) }}%;"></div>
                                    </div>
                                @elseif($product->stock_status === 'low')
                                    <span class="report-premium-badge bg-primary/10 text-primary border-primary/20 !text-[9px] !py-0.5 w-fit uppercase font-black tracking-widest italic">LOW ({{ $product->percentage }}%)</span>
                                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary/10" style="width: {{ min(100, $product->percentage) }}%;"></div>
                                    </div>
                                @else
                                    <span class="report-premium-badge report-premium-badge-info !text-[9px] !py-0.5 w-fit uppercase font-black tracking-widest italic text-primary border-primary/20">WARNING ({{ $product->percentage }}%)</span>
                                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary" style="width: {{ min(100, $product->percentage) }}%;"></div>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



</div>
@endsection


