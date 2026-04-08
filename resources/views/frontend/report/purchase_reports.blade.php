@extends('admin.admin_master')
@section('page_title', 'Purchase Report')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container"
     x-data="{
        searchTerm:    @js(request('search', '')),
        branchFilter:  @js(request('branch_id', '')),
        supplierFilter: @js(request('supplier_id', '')),
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
            let base = '{{ route('reports.purchases.pdf') }}';
            let params = new URLSearchParams(@js(request()->query()));
            Object.keys(this.cols).forEach(k => { if(this.cols[k]) params.append('cols[]', k); });
            return base + '?' + params.toString();
        },
        buildExcelUrl() {
            let base = '{{ route('reports.purchases.excel') }}';
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
            <h1 class="report-premium-title">Purchase Report</h1>
            <p class="report-premium-subtitle">Detailed tracking of all purchase transitions</p>
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
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 style="background: rgba(0,0,0,0.45);">
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
        <!-- Total Purchases -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Purchases</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalPurchases, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1"><i class="bi bi-arrow-up text-[10px]"></i> {{ $company->currency ?? '$' }} Spend</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cart3 text-lg"></i>
            </div>
        </div>

        <!-- Total Product Items -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Product Items</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalItems) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Across {{ number_format($totalBills) }} bills</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-box-seam text-lg"></i>
            </div>
        </div>

        <!-- Collected Amount -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Paid Amount</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($paidAmount, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">{{ $totalPurchases > 0 ? number_format(($paidAmount / $totalPurchases) * 100, 1) : 0 }}% Payment Rate</p>
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
    <form action="{{ route('reports.purchases') }}" method="GET" class="report-premium-filter-bar no-print">
        <!-- Search Text (Flexible to fill space) -->
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
                <i class="bi bi-search text-text-secondary text-xs"></i>
                <input type="text" name="search" x-model="searchTerm" placeholder="Bill # or supplier..." class="report-premium-filter-input">
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
                <span class="report-premium-filter-label">Supplier</span>
                <select name="supplier_id" x-model="supplierFilter" class="report-premium-filter-input">
                    <option value="">All Suppliers</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="report-premium-filter-group min-w-[120px]">
                <span class="report-premium-filter-label">Status</span>
                <select name="status" x-model="statusFilter" class="report-premium-filter-input">
                    <option value="">All Status</option>
                    <option value="paid">Paid</option>
                    <option value="partial">Partial</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>
            
        <!-- Search Action -->
        <button type="submit" class="report-premium-btn-primary">
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
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Purchase Transactions</h4>
            </div>
        </div>

        <!-- Table Display -->
        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="w-10 text-center">#</th>
                        <th>Bill #</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th class="text-center">Total Qty</th>
                        <th class="text-right">Total Amount</th>
                        <th class="text-right">Paid</th>
                        <th class="text-right">Balance</th>
                        <th class="text-center">Payment Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($purchases as $purchase)
                    @php
                        $supplierName = $purchase->supplier->name ?? 'Unknown Supplier';
                        $billNo       = $purchase->bill_number;
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors bg-white group"
                        x-show="(searchTerm === '' || '{{ strtolower($billNo ?? '') }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($supplierName ?? '') }}'.includes(searchTerm.toLowerCase())) && (branchFilter === '' || '{{ $purchase->branch_id }}' === branchFilter) && (supplierFilter === '' || '{{ $purchase->supplier_id }}' === supplierFilter) && (statusFilter === '' || '{{ $purchase->status }}' === statusFilter)">
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-400 text-center">
                            {{ str_pad($loop->iteration + ($purchases->firstItem() - 1), 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-bold text-primary-dark">{{ $billNo }}</span>
                        </td>
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-500">
                            {{ \Carbon\Carbon::parse($purchase->bill_date)->format('d-M-Y') }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-bold text-primary-dark">{{ $supplierName }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-[11px] font-bold text-gray-600">{{ number_format($purchase->items->sum('quantity')) }} Qty</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-xs font-bold text-primary-dark font-mono">{{ number_format($purchase->total_amount, 2) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-xs font-bold text-accent font-mono">{{ number_format($purchase->paid_amount, 2) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-xs font-bold text-primary font-mono">{{ number_format($purchase->balance_amount, 2) }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="report-premium-badge {{ $purchase->status == 'paid' ? 'report-premium-badge-success' : ($purchase->status == 'partial' ? 'report-premium-badge-warning' : 'report-premium-badge-error') }}">
                                {{ ucfirst($purchase->status) }}
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
                @if($purchases->total() > 0)
                <tfoot>
                    <tr>
                        <td colspan="4" class="font-black text-primary-dark tracking-widest uppercase">Period Totals</td>
                        <td class="text-center font-black">{{ number_format($totalItems) }}</td>
                        <td class="text-right font-black">{{ number_format($totalPurchases, 2) }}</td>
                        <td class="text-right font-black text-accent">{{ number_format($paidAmount, 2) }}</td>
                        <td class="text-right font-black text-primary">{{ number_format($totalOutstanding, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($purchases->total() > 0)
        <div class="report-premium-card-footer flex flex-col md:flex-row justify-between items-center gap-4 no-print">
            <p class="text-[11px] text-text-secondary font-bold uppercase tracking-widest">
                Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ number_format($purchases->total()) }} entries
            </p>
            <div class="flex items-center gap-1">
                {{ $purchases->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
        @endif
    </div>


</div>
@endsection

