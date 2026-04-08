@extends('admin.admin_master')
@section('page_title', 'Transaction Report')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container"
     x-data="{
        txType:       @js(request('tx_type', '')),
        accountFilter:@js(request('account_id', '')),
        amountRange:  @js(request('amount_range', '')),
        branchFilter: @js(request('branch_id', '')),
        pdfModal: false,
        cols: {
            type: true, ref_no: true, description: true,
            account: true, debit: true, credit: true, balance: true
        },
        exportType: 'pdf',
        buildPdfUrl() {
            let base = '{{ route('reports.transaction.pdf') }}';
            let params = new URLSearchParams(@js(request()->query()));
            Object.keys(this.cols).forEach(k => { if(this.cols[k]) params.append('cols[]', k); });
            return base + '?' + params.toString();
        },
        buildExcelUrl() {
            let base = '{{ route('reports.transaction.excel') }}';
            let params = new URLSearchParams(@js(request()->query()));
            Object.keys(this.cols).forEach(k => { if(this.cols[k]) params.append('cols[]', k); });
            return base + '?' + params.toString();
        }
     }">

    <!-- Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Transaction Reports</h1>
            <p class="report-premium-subtitle">Complete overview of all business transactions</p>
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

            <!-- Export Modal -->
            <div x-show="pdfModal" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 style="background: rgba(0,0,0,0.45);">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6"
                     @click.outside="pdfModal = false">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-[16px] font-black text-primary-dark"
                            x-text="exportType === 'pdf' ? 'Export PDF — Select Columns' : 'Export Excel — Select Columns'"></h3>
                        <button @click="pdfModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="bi bi-x-lg text-lg"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-3 mb-6">
                        <div class="space-y-3">
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.type" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Type</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.ref_no" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Ref #</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.description" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Description</span>
                            </label>
                        </div>
                        <div class="space-y-3">
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.account" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Party</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.debit" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Debit</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.credit" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Credit</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" x-model="cols.balance" class="w-4 h-4 rounded accent-primary cursor-pointer">
                                <span class="text-[13px] font-medium text-gray-700 group-hover:text-primary-dark">Amount</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <a x-show="exportType === 'pdf'" :href="buildPdfUrl()" target="_blank" @click="pdfModal = false"
                           class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white font-bold rounded-full transition-all shadow-md text-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Generate PDF
                        </a>
                        <a x-show="exportType === 'excel'" :href="buildExcelUrl()" @click="pdfModal = false"
                           class="flex items-center gap-2 px-6 py-2.5 bg-accent hover:bg-accent/90 text-primary font-bold rounded-full transition-all shadow-md text-sm">
                            <i class="bi bi-file-earmark-excel"></i> Download Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <!-- Opening Balance -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Opening Balance</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($openingBalance, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">{{ $company->currency ?? 'USD' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-journal-bookmark text-lg"></i>
            </div>
        </div>

        <!-- Total Debits -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Debits (Inflows)</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalDebit, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1"><i class="bi bi-arrow-up text-[10px]"></i> {{ $company->currency ?? 'USD' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-up-circle text-lg"></i>
            </div>
        </div>

        <!-- Total Credits -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Credits (Outflows)</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($totalCredit, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1"><i class="bi bi-arrow-down text-[10px]"></i> {{ $company->currency ?? 'USD' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-down-circle text-lg"></i>
            </div>
        </div>

        <!-- Closing Balance -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Closing Balance</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($closingBalance, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Net Movement: {{ number_format($netBalance, 2) }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-calculator text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <form action="{{ route('reports.transaction') }}" method="GET" class="report-premium-filter-bar no-print">

            <!-- Date Split -->
            <div class="flex items-center gap-2">
                <div class="report-premium-filter-group w-auto min-w-[140px]">
                    <span class="report-premium-filter-label">From</span>
                    <input type="date" name="from_date" value="{{ request('from_date', now()->format('Y-m-d')) }}" class="report-premium-filter-input">
                </div>
                <div class="report-premium-filter-group w-auto min-w-[140px]">
                    <span class="report-premium-filter-label">To</span>
                    <input type="date" name="to_date" value="{{ request('to_date', now()->format('Y-m-d')) }}" class="report-premium-filter-input">
                </div>
            </div>

            <div class="report-premium-filter-group min-w-[160px]">
                <span class="report-premium-filter-label">Transaction Type</span>
                <select name="tx_type" x-model="txType" class="report-premium-filter-input">
                    <option value="">All Transactions</option>
                    <option value="receipt">Receipt</option>
                    <option value="sale">Sale</option>
                    <option value="payment">Payment</option>
                    <option value="purchase">Purchase</option>
                    <option value="expense">Expense</option>
                    <option value="transfer">Transfer</option>
                    <option value="journal">Journal</option>
                </select>
            </div>

            <div class="report-premium-filter-group min-w-[180px]">
                <span class="report-premium-filter-label">Party</span>
                <select name="account_id" x-model="accountFilter" class="report-premium-filter-input">
                    <option value="">All Parties</option>
                    @if(isset($customers) && $customers->count() > 0)
                    <optgroup label="CUSTOMERS">
                        @foreach($customers as $c)
                            <option value="{{ $c->account_id }}">{{ $c->name }}</option>
                        @endforeach
                    </optgroup>
                    @endif
                    @if(isset($suppliers) && $suppliers->count() > 0)
                    <optgroup label="SUPPLIERS">
                        @foreach($suppliers as $s)
                            <option value="{{ $s->account_id }}">{{ $s->name }}</option>
                        @endforeach
                    </optgroup>
                    @endif
                </select>
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
                <span class="report-premium-filter-label">Amount Range</span>
                <select name="amount_range" x-model="amountRange" class="report-premium-filter-input">
                    <option value="">All Amounts</option>
                    <option value="0-1000">Under 1,000</option>
                    <option value="1000-5000">1,000 – 5,000</option>
                    <option value="5000-10000">5,000 – 10,000</option>
                    <option value="10000-50000">10,000 – 50,000</option>
                    <option value="50000+">Over 50,000</option>
                </select>
            </div>

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
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Transaction Log Entries</h4>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Reference #</th>
                        <th>Party</th>
                        <th>Description</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Credit</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($items as $index => $item)
                    @php
                        $ref     = $item->entry_reference ?? $item->entry_number ?? '—';
                        $refUp   = strtoupper($ref);
                        $type    = match(true) {
                            str_starts_with($refUp, 'RCP') => 'Receipt',
                            str_starts_with($refUp, 'INV') => 'Sale',
                            str_starts_with($refUp, 'PAY') => 'Payment',
                            str_starts_with($refUp, 'PO')  => 'Purchase',
                            str_starts_with($refUp, 'EXP') => 'Expense',
                            str_starts_with($refUp, 'TRF') => 'Transfer',
                            default                         => 'Journal',
                        };
                        $badgeClass = match($type) {
                            'Receipt'  => 'report-premium-badge-success',
                            'Sale'     => 'report-premium-badge-success',
                            'Payment'  => 'report-premium-badge-info',
                            'Purchase' => 'report-premium-badge-warning',
                            'Expense'  => 'report-premium-badge-error',
                            'Transfer' => 'report-premium-badge-info',
                            default    => 'report-premium-badge-info',
                        };
                        // Show Customer/Supplier name if it exists, otherwise fallback to Account Name
                        $party = $item->customer_name ?: ($item->supplier_name ?: ($item->account_name ?? '—'));
                        $amount = max($item->debit, $item->credit);
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors bg-white">
                        <td class="px-5 py-4 text-[11px] font-medium text-gray-500">
                            {{ \Carbon\Carbon::parse($item->entry_date)->format('M d, Y') }}
                        </td>
                        <td class="px-5 py-3.5 italic">
                            <span class="report-premium-badge {{ $badgeClass }}">{{ $type }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-[12px] font-black text-primary-dark">{{ $ref }}</span>
                        </td>
                        <td class="px-5 py-4 text-[12px] font-bold text-primary-dark">
                            {{ $party }}
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="text-[11px] text-gray-600 max-w-[200px] truncate" title="{{ $item->item_description ?: ($item->entry_description ?? '—') }}">
                                {{ $item->item_description ?: ($item->entry_description ?? '—') }}
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-right font-mono text-[11px]">
                            @if($item->debit > 0)
                                <span class="text-primary font-bold">{{ number_format($item->debit, 2) }}</span>
                            @else
                                <span class="text-gray-200">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right font-mono text-[11px]">
                            @if($item->credit > 0)
                                <span class="text-accent font-bold">{{ number_format($item->credit, 2) }}</span>
                            @else
                                <span class="text-gray-200">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right font-mono text-[11px]">
                            <span class="text-primary-dark font-black">{{ number_format($amount, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-gray-400">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <i class="bi bi-inbox text-2xl"></i>
                            </div>
                            <p class="text-[13px] font-bold uppercase tracking-widest text-gray-400">No entries found for this period</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if(count($items) > 0)
                <tfoot class="bg-primary/5">
                    <tr class="border-t-2 border-primary/20">
                        <td colspan="5" class="px-5 py-4 text-[14px] font-black text-primary uppercase tracking-widest">Total Period Summary</td>
                        <td class="px-5 py-4 text-right text-primary font-mono font-bold text-[13px]">{{ number_format($totalDebit, 2) }}</td>
                        <td class="px-5 py-4 text-right text-accent font-mono font-bold text-[13px]">{{ number_format($totalCredit, 2) }}</td>
                        <td class="px-5 py-4 text-right text-primary-dark font-mono font-black text-[14px]">{{ number_format($totalDebit + $totalCredit, 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>



    </div>

</div>
@endsection

