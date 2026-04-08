@extends('admin.admin_master')
@section('page_title', 'Sales Report')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container"
     x-data="{
        searchTerm:    @js(request('search', '')),
        branchFilter:  @js(request('branch_id', '')),
        customerFilter: @js(request('customer_id', '')),
        statusFilter:  @js(request('status', '')),
        pdfModal: false,
        cols: {
            date: true, invoice_no: true, party_name: true, total: true,
            payment_type: true, received: true, balance: true,
            item_details: false, description: false, payment_status: false,
            order_number: false, phone: false
        },
        exportType: 'pdf',
        buildPdfUrl() {
            let base = '{{ route('reports.sales.pdf') }}';
            let params = new URLSearchParams(@js(request()->query()));
            Object.keys(this.cols).forEach(k => { if(this.cols[k]) params.append('cols[]', k); });
            return base + '?' + params.toString();
        },
        buildExcelUrl() {
            let base = '{{ route('reports.sales.excel') }}';
            let params = new URLSearchParams(@js(request()->query()));
            Object.keys(this.cols).forEach(k => { if(this.cols[k]) params.append('cols[]', k); });
            return base + '?' + params.toString();
        },
        buildExportUrl() {
            return this.exportType === 'pdf' ? this.buildPdfUrl() : this.buildExcelUrl();
        }
     }">

    <!-- Header Section -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Sales Report</h1>
            <p class="report-premium-subtitle">Detailed tracking of all sales transitions</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="exportType = 'excel'; pdfModal = true" class="report-premium-btn-accent">
                <i class="bi bi-file-earmark-excel"></i>
                Export Excel
            </button>
            <button @click="exportType = 'pdf'; pdfModal = true" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF
            </button>

            <!-- Export Report Options Modal (PDF & Excel) -->
            <div x-show="pdfModal" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/45">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6"
                     @click.outside="pdfModal = false">

                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-[16px] font-black text-primary-dark"
                            x-text="exportType === 'pdf' ? 'Export PDF — Select Columns' : 'Export Excel — Select Columns'"></h3>
                        <button @click="pdfModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="bi bi-x-lg text-lg"></i>
                        </button>
                    </div>

                    <!-- Checkbox Grid -->
                    <div class="grid grid-cols-2 gap-x-8 gap-y-3 mb-6">
                        <!-- Left column -->
                        <div class="space-y-3">
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.date" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Date</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.invoice_no" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Invoice No.</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.party_name" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Party Name</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.total" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Total</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.payment_type" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Payment Type</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.received" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Received/Paid</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.balance" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Balance Due</span>
                            </label>
                        </div>
                        <!-- Right column -->
                        <div class="space-y-3">
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.item_details" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Item Details</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.description" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Description</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.payment_status" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Payment Status</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.order_number" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Order Number</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.phone" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Party's Phone No.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Generate Buttons -->
                    <div class="flex justify-end gap-2">
                        <!-- PDF Button -->
                        <a x-show="exportType === 'pdf'"
                           :href="buildPdfUrl()" target="_blank"
                           @click="pdfModal = false"
                           class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white font-bold rounded-full transition-all shadow-md text-sm">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Generate PDF
                        </a>
                        <!-- Excel Button -->
                        <a x-show="exportType === 'excel'"
                           :href="buildExcelUrl()"
                           @click="pdfModal = false"
                           class="flex items-center gap-2 px-6 py-2.5 bg-accent hover:bg-accent/90 text-primary font-bold rounded-full transition-all shadow-md text-sm">
                            <i class="bi bi-file-earmark-excel"></i>
                            Download Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <!-- Total Sales -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Sales</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalSales, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1"><i class="bi bi-arrow-up text-[10px]"></i> {{ $company->currency ?? '$' }} Revenue</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up-arrow text-lg"></i>
            </div>
        </div>

        <!-- Total Product Items -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Product Items</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalItems) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Across {{ number_format($totalInvoices) }} transactions</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-box-seam text-lg"></i>
            </div>
        </div>

        <!-- Collected Amount -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Collected Amount</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($paidAmount, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">{{ $totalSales > 0 ? number_format(($paidAmount / $totalSales) * 100, 1) : 0 }}% Collection Rate</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-check-circle text-lg"></i>
            </div>
        </div>

        <!-- Outstanding -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Outstanding</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalOutstanding, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Pending payments</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-hourglass-split text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <form action="{{ route('reports.sales') }}" method="GET" class="report-premium-filter-bar no-print">
        <!-- Search Text (Flexible to fill space) -->
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
                <i class="bi bi-search text-text-secondary text-xs"></i>
                <input type="text" name="search" x-model="searchTerm" placeholder="Invoice # or name..." class="report-premium-filter-input">
            </div>

            <!-- Date Split -->
            <div class="flex items-center gap-2">
                <div class="report-premium-filter-group w-auto min-w-[140px]">
                    <span class="report-premium-filter-label">From</span>
                    <input type="date" name="from_date" value="{{ request('from_date', now()->startOfMonth()->format('Y-m-d')) }}" class="report-premium-filter-input">
                </div>
                <div class="report-premium-filter-group w-auto min-w-[140px]">
                    <span class="report-premium-filter-label">To</span>
                    <input type="date" name="to_date" value="{{ request('to_date', now()->format('Y-m-d')) }}" class="report-premium-filter-input">
                </div>
            </div>

            <div class="report-premium-filter-group min-w-[150px]">
                <span class="report-premium-filter-label">Location</span>
                <select name="branch_id" x-model="branchFilter" class="report-premium-filter-input">
                    <option value="">All Locations</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="report-premium-filter-group min-w-[150px]">
                <span class="report-premium-filter-label">Customer</span>
                <select name="customer_id" x-model="customerFilter" class="report-premium-filter-input">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="report-premium-filter-group min-w-[120px]">
                <span class="report-premium-filter-label">Status</span>
                <select name="status" x-model="statusFilter" class="report-premium-filter-input">
                    <option value="">All Status</option>
                    <option value="completed">Paid</option>
                    <option value="partial">Partial</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

        <!-- Search Action -->
        <button type="submit" class="report-premium-btn-primary hover:bg-primary/90">
            <i class="bi bi-search"></i>
            Search
        </button>
    </form>

    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Sales Transactions</h4>
            </div>
        </div>

        <!-- Table Display -->
        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider w-10 text-center">#</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Invoice #</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Date</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Customer</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Total Qty</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">Total Amount</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">Paid</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">Balance</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Payment Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sales as $sale)
                    @php
                        $customerName = $sale->customer->name ?? 'Walk-in Customer';
                        $invoiceNo = $sale->invoice_no;
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors bg-white group"
                        x-show="(searchTerm === '' || '{{ strtolower($invoiceNo) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($customerName) }}'.includes(searchTerm.toLowerCase())) && (branchFilter === '' || '{{ $sale->branch_id }}' === branchFilter) && (customerFilter === '' || '{{ $sale->customer_id }}' === customerFilter) && (statusFilter === '' || '{{ $sale->status }}' === statusFilter)">
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                            {{ str_pad($loop->iteration + ($sales->firstItem() - 1), 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                            {{ $invoiceNo }}
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                            {{ $sale->invoice_date->format('d-M-Y') }}
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                            {{ $customerName }}
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                            {{ number_format($sale->items->sum('quantity')) }} Qty
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right font-mono">
                            {{ number_format($sale->total_amount, 2) }}
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right font-mono">
                            <span class="text-accent">{{ number_format($sale->paid_amount, 2) }}</span>
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-right font-mono">
                            <span class="text-primary">{{ number_format($sale->total_amount - $sale->paid_amount, 2) }}</span>
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                            <span class="report-premium-badge {{ $sale->status == 'completed' ? 'report-premium-badge-success' : ($sale->status == 'partial' ? 'report-premium-badge-warning' : 'report-premium-badge-error') }}">
                                {{ $sale->status_label }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-5 py-16 text-center text-gray-400">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <i class="bi bi-inbox text-2xl"></i>
                            </div>
                            <p class="text-[13px] font-bold uppercase tracking-widest text-gray-400">No transaction records identified</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($sales->total() > 0)
                <tfoot>
                    <tr>
                        <td colspan="4" class="font-black text-primary-dark tracking-widest uppercase">Period Totals</td>
                        <td class="text-center font-black">{{ number_format($totalItems) }}</td>
                        <td class="text-right font-black">{{ number_format($totalSales, 2) }}</td>
                        <td class="text-right font-black text-accent">{{ number_format($paidAmount, 2) }}</td>
                        <td class="text-right font-black text-primary">{{ number_format($totalOutstanding, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($sales->total() > 0)
        <div class="report-premium-card-footer flex flex-col md:flex-row justify-between items-center gap-4 no-print">
            <p class="text-[11px] text-text-secondary font-bold uppercase tracking-widest">
                Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ number_format($sales->total()) }} entries
            </p>
            <div class="flex items-center gap-1">
                {{ $sales->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
        @endif
    </div>


</div>
@endsection

