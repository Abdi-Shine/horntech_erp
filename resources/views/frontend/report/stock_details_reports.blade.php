@extends('admin.admin_master')
@section('page_title', 'Stock Details')



@section('admin')
<div class="report-premium-container">

    {{-- Page Header --}}
    <!-- Page Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Stock Details Report</h1>
            <p class="report-premium-subtitle">Movement tracking with beginning, in, out, and closing quantities</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <a href="{{ route('reports.stock_details.pdf', request()->all()) }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    {{-- Stats Row --}}
    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Beginning Qty</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->beginningQty) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Opening position</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-box-arrow-in-down"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Quantity In</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->qtyIn) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Purchases / Receivals</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-down-circle"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Quantity Out</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->qtyOut) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Sales / Dispatches</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-up-circle"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Closing Qty</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totals->closingQty) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Current Net Avail.</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-box-seam"></i>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <!-- Filter Bar -->
    <form method="GET" action="{{ route('reports.stock_details') }}" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group w-auto min-w-[170px]">
            <span class="report-premium-filter-label">Category Filter</span>
            <select name="category_id" class="report-premium-filter-input">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="report-premium-filter-group w-auto min-w-[140px]">
            <span class="report-premium-filter-label">Beginning From</span>
            <input type="date" name="from_date" value="{{ $filters['from_date'] }}" class="report-premium-filter-input">
        </div>

        <div class="report-premium-filter-group w-auto min-w-[140px]">
            <span class="report-premium-filter-label">Closing To</span>
            <input type="date" name="to_date" value="{{ $filters['to_date'] }}" class="report-premium-filter-input">
        </div>

        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <span class="report-premium-filter-label">Quick Search</span>
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search product name..." class="report-premium-filter-input !pl-9">
            </div>
        </div>

        <div class="flex gap-2 mt-auto">
            <button type="submit" class="report-premium-btn-primary h-[38px]">
                <i class="bi bi-funnel"></i>
            </button>
            <a href="{{ route('reports.stock_details') }}" class="report-premium-btn-outline h-[38px] flex items-center justify-center">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </form>

    {{-- Main Table --}}
    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden mb-6">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Stock movement granular details</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black text-[9px] uppercase tracking-widest">
                {{ number_format($dataset->count()) }} SKUs Tracked
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="text-center w-12">#</th>
                        <th>Product Identity</th>
                        <th class="text-right">Beginning</th>
                        <th class="text-right">Qty IN</th>
                        <th class="text-right">Purch Value</th>
                        <th class="text-right">Qty OUT</th>
                        <th class="text-right">Sale Value</th>
                        <th class="text-right">Closing</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($dataset as $row)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-[11px] font-black text-gray-400 text-center italic uppercase leading-none">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-primary-dark uppercase leading-tight">{{ $row->name }}</span>
                                <span class="text-[10px] text-gray-400 font-black italic uppercase tracking-tighter opacity-70">{{ $row->category }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-xs font-black font-mono text-gray-400 opacity-80">{{ number_format($row->beginningQty) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-xs font-black font-mono text-accent">+{{ number_format($row->qtyIn) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right font-mono text-[11px] font-black text-gray-500 opacity-80 italic">
                             {{ number_format($row->purchaseAmount, 2) }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-xs font-black font-mono text-primary">-{{ number_format($row->qtyOut) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right font-mono text-[11px] font-black text-gray-500 opacity-80 italic">
                             {{ number_format($row->saleAmount, 2) }}
                        </td>
                        <td class="px-5 py-4 text-right bg-brand-bg/5">
                            <span class="text-[13px] font-black font-mono text-primary italic">{{ number_format($row->closingQty) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center">
                            <i class="bi bi-inbox text-4xl text-gray-100 block mb-3"></i>
                            <p class="text-[14px] text-gray-300 font-black uppercase tracking-widest italic">No movement activity identified</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($dataset->count() > 0)
                <tfoot class="bg-primary/5">
                    <tr class="font-black text-primary-dark border-t-2 border-primary/20">
                        <td colspan="2" class="px-5 py-5 text-center">
                             <span class="text-[11px] font-black uppercase tracking-[0.2em] italic text-primary-dark opacity-70">Consolidated Activity</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Beg. Total</span>
                            <span class="text-[13px] font-black font-mono text-gray-500 opacity-80">{{ number_format($totals->beginningQty) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right" colspan="2">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Net Inflows (Qty/Val)</span>
                            <div class="flex flex-col items-end">
                                <span class="text-[13px] font-black font-mono text-accent leading-none">+{{ number_format($totals->qtyIn) }}</span>
                                <span class="text-[10px] font-black font-mono text-gray-500 opacity-60 italic mt-1">{{ number_format($totals->purchaseAmount, 2) }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-right" colspan="2">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Net Outflows (Qty/Val)</span>
                            <div class="flex flex-col items-end">
                                <span class="text-[13px] font-black font-mono text-primary leading-none">-{{ number_format($totals->qtyOut) }}</span>
                                <span class="text-[10px] font-black font-mono text-gray-500 opacity-60 italic mt-1">{{ number_format($totals->saleAmount, 2) }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-right bg-primary/10">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Final Position</span>
                            <span class="text-[15px] font-black font-mono text-primary italic">{{ number_format($totals->closingQty) }}</span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>



</div>
@endsection


