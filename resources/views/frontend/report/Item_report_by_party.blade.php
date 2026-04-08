@extends('admin.admin_master')
@section('page_title', 'Item Report by Party')

@push('css')

@endpush

@section('admin')
<div class="report-premium-container">

    <!-- Page Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Item Report by Party</h1>
            <p class="report-premium-subtitle">Item-wise sales and purchase breakdown for a selected party</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <button class="report-premium-btn-outline">
                <i class="bi bi-file-earmark-excel text-sm"></i> EXCEL
            </button>
            @if($selectedParty)
            <a href="{{ route('reports.item_report_by_party.pdf', ['party_type' => $partyType, 'party_id' => $selectedParty->id, 'from_date' => $fromDate, 'to_date' => $toDate]) }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
            @else
            <button disabled class="report-premium-btn-primary opacity-50 cursor-not-allowed">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </button>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Sale Qty</p>
                <h3 class="text-[18px] font-black text-primary">{{ $totalSaleQty > 0 ? number_format($totalSaleQty) : '0' }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Units Sold</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cart-check"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Sale Amount</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totalSaleAmt, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Revenue Generated</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Purchase Qty</p>
                <h3 class="text-[18px] font-black text-primary">{{ $totalPurchQty > 0 ? number_format($totalPurchQty) : '0' }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Units Purchased</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-box-seam"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Purchase Amount</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} {{ number_format($totalPurchAmt, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Cost Incurred</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cart3"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('reports.item_report_by_party') }}" class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group w-auto">
            <span class="report-premium-filter-label">Party Type</span>
            <select name="party_type" id="partyTypeSelect" onchange="updatePartyList()" class="report-premium-filter-input min-w-[150px]">
                <option value="">— Type —</option>
                <option value="customer" {{ $partyType === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="supplier" {{ $partyType === 'supplier' ? 'selected' : '' }}>Supplier</option>
            </select>
        </div>

        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <span class="report-premium-filter-label">Select Party</span>
            <select name="party_id" id="partySelect" class="report-premium-filter-input">
                <option value="">— Select a Party —</option>
                <optgroup label="Customers" id="customerGroup" {{ $partyType === 'supplier' ? 'style=display:none' : '' }}>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ ($partyType === 'customer' && $selectedParty?->id == $c->id) ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </optgroup>
                <optgroup label="Suppliers" id="supplierGroup" {{ $partyType === 'customer' ? 'style=display:none' : '' }}>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}" {{ ($partyType === 'supplier' && $selectedParty?->id == $s->id) ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
        </div>

        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">From Date</span>
            <input type="date" name="from_date" value="{{ $fromDate }}" class="report-premium-filter-input">
        </div>

        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">To Date</span>
            <input type="date" name="to_date" value="{{ $toDate }}" class="report-premium-filter-input">
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
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Item-wise Transactions</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black uppercase text-[9px] tracking-widest px-3">
                {{ $selectedParty ? $items->count() . ' Items Found' : 'Select a Party' }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="text-center w-12">#</th>
                        <th>Item Name</th>
                        <th class="text-right">Sale Qty</th>
                        <th class="text-right">Sale Amount</th>
                        <th class="text-right">Purchase Qty</th>
                        <th class="text-right">Purchase Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @if(!$selectedParty)
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <i class="bi bi-person-lines-fill text-4xl text-gray-200 block mb-3"></i>
                                <p class="text-[13px] text-gray-400 font-semibold">Select a party and click <strong>Generate</strong> to view item-wise transactions.</p>
                            </td>
                        </tr>
                    @elseif($items->isEmpty())
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <i class="bi bi-inbox text-4xl text-gray-200 block mb-3"></i>
                                <p class="text-[13px] text-gray-400 font-semibold">No transactions found for the selected party and date range.</p>
                            </td>
                        </tr>
                    @else
                        @foreach($items as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4 text-[11px] font-black text-gray-400 text-center">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">
                                <span class="text-xs font-black text-primary-dark">{{ $item->name }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-xs font-black font-mono {{ $item->saleQty > 0 ? 'text-primary' : 'text-gray-300' }}">
                                    {{ $item->saleQty > 0 ? number_format($item->saleQty) : '---' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-xs font-black font-mono {{ $item->saleAmount > 0 ? 'text-accent' : 'text-gray-300' }}">
                                    {{ $item->saleAmount > 0 ? number_format($item->saleAmount, 2) : '---' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-xs font-black font-mono {{ $item->purchaseQty > 0 ? 'text-primary' : 'text-gray-300' }}">
                                    {{ $item->purchaseQty > 0 ? number_format($item->purchaseQty) : '---' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-xs font-black font-mono {{ $item->purchaseAmount > 0 ? 'text-primary' : 'text-gray-300' }}">
                                    {{ $item->purchaseAmount > 0 ? number_format($item->purchaseAmount, 2) : '---' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                @if($selectedParty && $items->isNotEmpty())
                <tfoot class="bg-primary/5">
                    <tr class="font-black text-primary-dark border-t-2 border-primary/20">
                        <td colspan="2" class="px-5 py-5 text-center">
                            <span class="text-[11px] font-black uppercase tracking-widest italic text-primary-dark">Grand Totals</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-bold uppercase mb-0.5">Sale Qty</span>
                            <span class="text-[13px] font-mono font-black text-primary">{{ number_format($totalSaleQty) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-bold uppercase mb-0.5">Sale Amount</span>
                            <span class="text-[13px] font-mono font-black text-accent">{{ ($company->currency ?? 'SAR') . ' ' . number_format($totalSaleAmt, 2) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-bold uppercase mb-0.5">Purch Qty</span>
                            <span class="text-[13px] font-mono font-black text-primary">{{ number_format($totalPurchQty) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-bold uppercase mb-0.5">Purch Amount</span>
                            <span class="text-[13px] font-mono font-black text-primary">{{ ($company->currency ?? 'SAR') . ' ' . number_format($totalPurchAmt, 2) }}</span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<script>
function updatePartyList() {
    const type = document.getElementById('partyTypeSelect').value;
    const cg = document.getElementById('customerGroup');
    const sg = document.getElementById('supplierGroup');
    const ps = document.getElementById('partySelect');

    if (type === 'customer') {
        cg.style.display = '';
        sg.style.display = 'none';
    } else if (type === 'supplier') {
        cg.style.display = 'none';
        sg.style.display = '';
    } else {
        cg.style.display = '';
        sg.style.display = '';
    }
    ps.value = '';
}
</script>
@endsection

