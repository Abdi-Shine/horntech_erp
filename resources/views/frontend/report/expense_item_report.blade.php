@extends('admin.admin_master')
@section('page_title', 'Expense by Item')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container"
     x-data="{
        searchTerm: @js(request('search', '')),
        branchFilter: @js(request('branch_id', '')),
        pdfModal: false,
        exportType: 'pdf',
        buildPdfUrl() {
            let base = '{{ route('reports.expense_item_report.pdf') }}';
            let params = new URLSearchParams(@js(request()->query()));
            return base + '?' + params.toString();
        },
        buildExcelUrl() {
            let base = '{{ route('reports.expense_item_report.excel') }}';
            let params = new URLSearchParams(@js(request()->query()));
            return base + '?' + params.toString();
        }
     }">
    
    <!-- Header Section -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Expense Item Report</h1>
            <p class="report-premium-subtitle">Analysis of expenses grouped by item name</p>
        </div>
        <div class="flex items-center gap-3">
            <a :href="buildExcelUrl()" class="report-premium-btn-accent">
                <i class="bi bi-file-earmark-excel"></i>
                Export Excel
            </a>
            <a :href="buildPdfUrl()" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="report-premium-stat-grid">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Expense Amount</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalExpense, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">{{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Top Expense Item</p>
                <h3 class="text-[18px] font-black text-primary">
                    {{ $reportData->first()->expense_name ?? 'N/A' }}
                </h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">By Total Value</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-filter-square"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Instances</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalQuantity) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Total Volume</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-layers"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Unique Items</p>
                <h3 class="text-[18px] font-black text-primary">{{ $reportData->count() }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Expense Types</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-tag"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('reports.expense_item_report') }}" method="GET" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <span class="report-premium-filter-label">Search Item</span>
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Expense item name..."
                       class="report-premium-filter-input !pl-9">
            </div>
        </div>

        @if($branches->isNotEmpty())
        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">Branch</span>
            <select name="branch_id" class="report-premium-filter-input">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

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

    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Expense Item Details</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black uppercase tracking-widest text-[9px]">
                {{ \Carbon\Carbon::parse($filters['from_date'])->format('M d') }} — {{ \Carbon\Carbon::parse($filters['to_date'])->format('M d, Y') }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="w-12 text-center">#</th>
                        <th>Expense Item</th>
                        <th class="text-right">Avg. Unit Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Total Amount</th>
                        <th class="text-right">Share (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $index => $row)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="text-center text-text-secondary font-mono text-[11px]">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="font-bold text-primary-dark text-[13px]">{{ $row->expense_name }}</div>
                        </td>
                        <td class="text-right font-mono text-gray-500">{{ number_format($row->avg_amount, 2) }}</td>
                        <td class="text-center font-bold text-primary-dark">{{ $row->total_count }}</td>
                        <td class="text-right font-mono font-black text-primary">{{ number_format($row->total_amount, 2) }}</td>
                        <td class="text-right">
                            @php
                                $percent = $totalExpense > 0 ? ($row->total_amount / $totalExpense) * 100 : 0;
                            @endphp
                            <div class="flex items-center justify-end gap-2">
                                <span class="text-[11px] font-bold text-primary-dark">{{ number_format($percent, 1) }}%</span>
                                <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="bi bi-inbox text-4xl text-gray-200 mb-3"></i>
                                <p class="text-gray-400 font-medium text-sm">No expense items found for this period</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($reportData->isNotEmpty())
                <tfoot class="border-t-2 border-primary/10">
                    <tr class="bg-gray-50/50 font-black text-primary-dark">
                        <td colspan="3" class="px-5 py-4 text-[11px] uppercase tracking-wider">Summary Totals</td>
                        <td class="px-5 py-4 text-center text-[14px]">{{ number_format($totalQuantity) }}</td>
                        <td class="px-5 py-4 text-right text-[14px] text-primary">{{ number_format($totalExpense, 2) }}</td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[14px]">100%</span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

