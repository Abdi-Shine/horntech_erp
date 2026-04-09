@extends('admin.admin_master')
@section('page_title', 'Edit Invoice')
@section('admin')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@php
    $currencySymbols = [
        'USD' => '$',
        'SAR' => 'SAR',
        'SOS' => 'SOS',
        'EUR' => '€',
        'GBP' => '£',
        'KES' => 'KSh',
    ];
    $sym  = '$'; // Force Dollar
    $curr = '$'; // Force Dollar
@endphp

<div class="px-4 py-6 md:px-8 bg-gray-50 min-h-screen">

    {{-- Page Heading --}}
    <div class="mb-5">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-9 h-9 bg-accent/20 border-2 border-accent rounded-lg flex items-center justify-center shrink-0">
                <i class="bi bi-pencil-square text-primary-dark text-base"></i>
            </div>
            <h1 class="text-xl font-black text-primary-dark tracking-tight">Edit Invoice</h1>
        </div>
        <nav class="text-[11px] font-semibold text-gray-400 ml-12">
            <a href="#" class="hover:text-primary transition-colors">Dashboard</a>
            <span class="mx-1">/</span>
            <a href="{{ route('sales.invoice.view') }}" class="hover:text-primary transition-colors">Sales</a>
            <span class="mx-1">/</span>
            <span class="text-accent font-bold">Edit — {{ $order->invoice_no }}</span>
        </nav>
    </div>

    <form id="editForm" autocomplete="off">
        @csrf
        @method('PUT')

        {{-- Top Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

            {{-- Customer Information --}}
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-5">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Customer Information</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Customer</label>
                        <select id="customerSelect" name="customer_id" class="w-full" required>
                            <option value="">Search by Name/Phone #</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}"
                                        data-phone="{{ $c->phone }}"
                                        data-balance="{{ $c->amount_balance ?? 0 }}"
                                        {{ $order->customer_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Phone No.</label>
                        <input type="text" id="customerPhone" readonly
                               value="{{ $order->customer->phone ?? '' }}"
                               class="w-full border border-gray-200 rounded px-3 py-1.5 text-[12px] font-medium text-gray-600 bg-gray-50 focus:outline-none focus:border-primary">
                    </div>
                </div>
                <div id="balanceBadge" class="{{ ($order->customer->amount_balance ?? 0) > 0 ? 'flex' : 'hidden' }} mt-3 items-center gap-2 text-[11px] font-bold text-primary bg-primary/10 border border-primary/20 rounded-lg px-3 py-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Outstanding balance: <span id="balanceVal">{{ number_format($order->customer->amount_balance ?? 0, 2) }}</span> {{ $curr }}</span>
                </div>
            </div>

            {{-- Invoice Details --}}
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Invoice Details</p>
                <div class="mb-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1">Invoice Number</label>
                    <div class="text-lg font-black text-primary tracking-tight">{{ $order->invoice_no }}</div>
                </div>
                {{-- Hidden inputs — not displayed, submitted with form --}}
                <input type="hidden" name="invoice_no"     value="{{ $order->invoice_no }}">
                <input type="hidden" name="invoice_date"   value="{{ \Carbon\Carbon::parse($order->invoice_date)->format('Y-m-d') }}">
                <input type="hidden" name="branch_id"      value="{{ $order->branch_id }}">
                <input type="hidden" name="payment_method" value="{{ $order->payment_method }}">
            </div>
        </div>

        {{-- Items Table --}}
        <div class="bg-white border border-gray-200 rounded-lg mb-4 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider w-8 text-center">#</th>
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider min-w-[110px]">Category</th>
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider min-w-[140px]">Item</th>
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider min-w-[120px]">Description</th>
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider w-20 text-center">Qty</th>
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider w-24">Unit</th>
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider w-24 text-right">Price/Unit</th>
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider text-center min-w-[130px]">
                                Discount<br><span class="font-normal normal-case text-gray-400">Amt / %</span>
                            </th>
                            <th class="px-3 py-3 text-[10px] font-black text-gray-500 uppercase tracking-wider w-28 text-right">Amount</th>
                            <th class="w-16"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsTbody"></tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-200 bg-gray-50">
                            <td colspan="4" class="px-4 py-3 text-[11px] font-black text-gray-500 uppercase text-right">Total</td>
                            <td class="px-3 py-3 text-center"><span class="text-[13px] font-black text-primary" id="footerQty">0</span></td>
                            <td colspan="3"></td>
                            <td class="px-3 py-3 text-right"><span class="text-[14px] font-black text-accent" id="footerAmount">{{ $sym }} 0.00</span></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="border-t border-dashed border-gray-200 py-3 text-center">
                <button type="button" onclick="addItemRow()"
                        class="inline-flex items-center gap-2 text-[12px] font-bold text-primary border border-dashed border-primary/30 rounded-lg px-8 py-1.5 hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">
                    <i class="bi bi-plus-circle text-sm"></i> ADD ROW
                </button>
            </div>
        </div>

        {{-- Notes + Summary --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-5">

            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-3 pb-2 border-b border-gray-100">Notes / Terms &amp; Conditions</label>
                <textarea name="notes" rows="5" placeholder="Enter any notes..."
                          class="w-full border border-gray-200 rounded px-3 py-2.5 text-[12px] text-gray-600 resize-none focus:outline-none focus:border-primary placeholder-gray-300">{{ $order->notes }}</textarea>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Invoice Summary</p>

                {{-- Discount --}}
                <div class="flex items-center gap-3 mb-3">
                    <label class="text-[11px] font-bold text-gray-600 w-28 shrink-0">Discount</label>
                    <div class="flex items-center gap-2 flex-1">
                        <div class="relative flex-1">
                            <input type="number" id="discountPercent" value="{{ $order->subtotal > 0 ? round(($order->discount / $order->subtotal) * 100) : 0 }}" min="0" step="1" placeholder="0"
                                   class="w-full pl-3 pr-8 py-1.5 border border-gray-200 rounded text-[12px] font-bold text-right text-gray-700 focus:outline-none focus:border-primary">
                            <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">(%)</span>
                        </div>
                        <span class="text-gray-400 font-bold">-</span>
                        <div class="relative flex-1">
                            <input type="number" id="discountInput" name="discount" value="{{ round($order->discount ?? 0) }}" min="0" step="1" placeholder="0"
                                   class="w-full pl-3 pr-8 py-1.5 border border-gray-200 rounded text-[12px] font-bold text-right text-gray-700 focus:outline-none focus:border-primary">
                            <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">($)</span>
                        </div>
                    </div>
                </div>



                {{-- Paid Amount --}}
                <div class="flex items-center gap-3 mb-4">
                    <label class="text-[11px] font-bold text-gray-600 w-28 shrink-0">Amount Paid</label>
                    <div class="relative flex-1">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">{{ $curr }}</span>
                        <input type="number" name="paid_amount" id="paidAmountInput" value="{{ $order->paid_amount ?? 0 }}" min="0" step="0.01"
                               class="w-full pl-10 pr-3 py-1.5 border border-gray-200 rounded text-[12px] font-bold text-right text-gray-700 focus:outline-none focus:border-primary">
                    </div>
                </div>

                <input type="hidden" name="tax" id="taxVal" value="0">
                <input type="hidden" name="total_amount" id="grandTotalVal" value="{{ $order->total_amount }}">

                {{-- Grand Total --}}
                <div class="bg-primary rounded-lg px-5 py-4 flex items-center justify-between mt-4">
                    <span class="text-[13px] font-black text-white uppercase tracking-wider">Total</span>
                    <span class="text-[18px] font-black text-accent" id="grandTotalDisplay">{{ $curr }} {{ number_format($order->total_amount, 2) }}</span>
                </div>

                {{-- Sub-breakdown --}}
                <div class="mt-3 space-y-1.5 px-1">
                    <div class="flex justify-between text-[11px]">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-bold text-gray-700" id="subtotalDisplay">{{ $curr }} {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] border-t border-dashed border-gray-200 pt-1.5">
                        <span class="text-gray-500">Balance Due (this invoice)</span>
                        <span class="font-bold text-primary" id="balanceDueDisplay">{{ $curr }} {{ number_format($order->due_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] bg-primary/10 rounded-lg px-2 py-1.5 mt-1">
                        <span class="font-black text-primary">Total Customer Balance</span>
                        <span class="font-black text-primary" id="totalCustomerBalDisplay">{{ $curr }} 0.00</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="bg-white border border-gray-200 rounded-lg px-5 py-4 flex flex-wrap items-center gap-3 justify-between">
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('sales.invoice.view') }}" class="btn-action border-gray-300 text-gray-600 hover:bg-gray-50">
                    <i class="bi bi-x-circle text-sm"></i> Cancel
                </a>
            </div>
            <div class="flex gap-2 flex-wrap">
                <button type="button" onclick="submitUpdate()"
                        class="btn-action bg-accent text-primary-dark hover:bg-accent/90 border-accent font-black">
                    <i class="bi bi-check2-all text-sm"></i> Update Invoice
                </button>
            </div>
        </div>

    </form>
</div>

{{-- JSON data for JS --}}
<script id="productData" type="application/json">
{!! json_encode($products->map(fn($p) => [
    'id'          => $p->id,
    'name'        => $p->product_name,
    'code'        => $p->product_code ?? '',
    'price'       => (float) $p->selling_price,
    'unit'        => $p->unit ?? 'Piece',
    'stock'       => (int) ($p->stocks_sum_quantity ?? 0),
    'category_id' => $p->category_id,
])) !!}
</script>
<script id="categoryData" type="application/json">
{!! json_encode($categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])) !!}
</script>
<script id="existingItems" type="application/json">
{!! json_encode($order->items->map(fn($i) => [
    'product_id'   => $i->product_id,
    'product_name' => $i->product_name,
    'product_code' => $i->product_code ?? '',
    'quantity'     => (float) $i->quantity,
    'unit_price'   => (float) $i->unit_price,
    'unit'         => $i->unit ?? 'Piece',
    'discount'     => (float) ($i->discount ?? 0),
    'total_price'  => (float) $i->total_price,
])) !!}
</script>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
const SYM        = @json($sym);
const CURR       = @json($curr);
const CSRF       = @json(csrf_token());
const R_UPDATE   = @json(route('sales.invoice.update', $order->id));
const R_LIST     = @json(route('sales.invoice.view'));
const PRODUCTS   = JSON.parse(document.getElementById('productData').textContent);
const CATEGORIES = JSON.parse(document.getElementById('categoryData').textContent);
const EXISTING   = JSON.parse(document.getElementById('existingItems').textContent);

let rowCounter    = 0;
let discountFocus = 'amt';

/* ── Init ── */
$(document).ready(function () {
    $('#customerSelect').select2({ placeholder: 'Search by Name/Phone #', allowClear: true, width: '100%' })
        .on('select2:select', function () {
            const el  = $(this).find(':selected');
            document.getElementById('customerPhone').value = el.data('phone') || '';
            window._customerPrevBalance = parseFloat(el.data('balance')) || 0;
            const bal = window._customerPrevBalance;
            document.getElementById('balanceVal').textContent = bal.toFixed(2);
            document.getElementById('balanceBadge').classList.toggle('hidden', bal <= 0);
            recalcAll();
        }).on('select2:clear', () => {
            document.getElementById('customerPhone').value = '';
            document.getElementById('balanceBadge').classList.add('hidden');
            window._customerPrevBalance = 0;
            recalcAll();
        });

    // Set initial customer balance
    window._customerPrevBalance = parseFloat(
        $('#customerSelect').find(':selected').data('balance')
    ) || 0;

    // Load existing items
    EXISTING.forEach(item => addItemRow(item));

    document.getElementById('discountInput').addEventListener('input', function() {
        discountFocus = 'amt';
        syncDiscountBoxes();
        recalcAll();
    });

    document.getElementById('discountPercent').addEventListener('input', function() {
        discountFocus = 'pct';
        syncDiscountBoxes();
        recalcAll();
    });

    function syncDiscountBoxes() {
        const subtotal = calculateCurrentSubtotal();
        const pctInput = document.getElementById('discountPercent');
        const amtInput = document.getElementById('discountInput');

        if (subtotal <= 0) return;

        if (discountFocus === 'pct') {
            const pct = parseFloat(pctInput.value) || 0;
            amtInput.value = Math.round(subtotal * pct / 100);
        } else {
            const amt = parseFloat(amtInput.value) || 0;
            const pct = (amt / subtotal) * 100;
            pctInput.value = Math.round(pct);
        }
    }


    document.getElementById('paidAmountInput').addEventListener('input', recalcAll);

    recalcAll();
});

function calculateCurrentSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('#itemsTbody .item-row').forEach(row => {
        subtotal += parseFloat(row.querySelector('.row-amount').dataset.val) || 0;
    });
    return subtotal;
}

/* ── Category / Item option builders ── */
function buildCategoryOptions() {
    let html = `<option value="ALL">ALL</option>`;
    CATEGORIES.forEach(c => { html += `<option value="${c.id}">${c.name}</option>`; });
    return html;
}

function buildItemOptions(catId) {
    let html = `<option value="">Select Item</option>`;
    PRODUCTS.forEach(p => {
        if (!catId || catId === 'ALL' || p.category_id == catId) {
            html += `<option value="${p.id}"
                data-price="${p.price}" data-code="${p.code}"
                data-unit="${p.unit}" data-stock="${p.stock}"
                data-catid="${p.category_id}">${p.name}</option>`;
        }
    });
    return html;
}

/* ── Add row (optionally pre-filled) ── */
function addItemRow(prefill) {
    rowCounter++;
    const n  = rowCounter;
    const tr = document.createElement('tr');
    tr.className  = 'item-row';
    tr.dataset.row = n;

    tr.innerHTML = `
        <td class="px-3 py-2 text-[11px] font-bold text-gray-400 text-center">${n}</td>
        <td class="px-2 py-2">
            <select class="tbl-input tbl-select cat-select">
                ${buildCategoryOptions()}
            </select>
        </td>
        <td class="px-2 py-2">
            <select class="tbl-input tbl-select item-select" data-row="${n}">
                ${buildItemOptions('ALL')}
            </select>
        </td>
        <td class="px-2 py-2">
            <input type="text" class="tbl-input desc-input" placeholder="Add description">
        </td>
        <td class="px-2 py-2">
            <input type="number" class="tbl-input qty-input text-center"
                   value="${prefill ? prefill.quantity : 1}" min="0.01" step="1"
                   class="tbl-qty-w" oninput="calcRow(${n})">
        </td>
        <td class="px-2 py-2">
            <select class="tbl-input tbl-select unit-input tbl-unit-w">
                ${['','Piece','Box','Kg','Litre','Set'].map(u =>
                    `<option value="${u}" ${prefill && prefill.unit===u?'selected':''}>${u||'NONE'}</option>`
                ).join('')}
            </select>
        </td>
        <td class="px-2 py-2">
            <input type="number" class="tbl-input price-input text-right tbl-price-w"
                   value="${prefill ? prefill.unit_price : 0}" min="0" step="0.01"
                   oninput="calcRow(${n})">
        </td>
        <td class="px-2 py-2">
            <div class="flex items-center gap-1">
                <input type="number" class="tbl-input row-disc-input text-right"
                       value="${prefill ? prefill.discount : 0}" min="0" step="0.01"
                       class="tbl-disc-w" oninput="calcRow(${n})">
                <button type="button" class="disc-toggle row-disc-toggle text-[10px]"
                        onclick="toggleRowDisc(this, ${n})">Amt</button>
            </div>
        </td>
        <td class="px-2 py-2 text-right">
            <span class="text-[13px] font-black text-[#5a9a22] row-amount"
                  data-val="${prefill ? prefill.total_price : 0}">
                ${CURR} ${prefill ? prefill.total_price.toFixed(2) : '0.00'}
            </span>
        </td>
        <td class="px-2 py-2">
            <div class="flex items-center justify-center gap-1">
                <button type="button" class="w-6 h-6 rounded text-gray-400 hover:text-primary transition-colors flex items-center justify-center"
                        onclick="removeRow(${n})" title="Delete">
                    <i class="bi bi-trash3 text-xs"></i>
                </button>
            </div>
        </td>
    `;

    document.getElementById('itemsTbody').appendChild(tr);

    $(tr).find('.cat-select, .item-select').select2({ placeholder:'', width:'100%', minimumResultsForSearch:5 });

    // If pre-filling, select the matching product option
    if (prefill && prefill.product_id) {
        const itemSel = tr.querySelector('.item-select');
        for (let o of itemSel.options) {
            if (o.value == prefill.product_id) { $(itemSel).val(o.value).trigger('change.select2'); break; }
        }
    }

    $(tr).find('.item-select').on('select2:select', function () { onItemChange(this, n); });
    $(tr).find('.cat-select').on('select2:select',  function () { onCategoryChange(this, n); });

    renumberRows();
}

/* ── Category / Item change handlers ── */
function onCategoryChange(sel, rn) {
    const catId   = $(sel).val();
    const row     = document.querySelector(`tr[data-row="${rn}"]`);
    const itemSel = row.querySelector('.item-select');
    $(itemSel).select2('destroy');
    itemSel.innerHTML = buildItemOptions(catId);
    $(itemSel).select2({ placeholder:'', width:'100%', minimumResultsForSearch:5 });
    $(itemSel).on('select2:select', function () { onItemChange(this, rn); });
    calcRow(rn);
}

function onItemChange(sel, rn) {
    const opt = $(sel).find(':selected');
    if (!opt.val()) return;
    const row = document.querySelector(`tr[data-row="${rn}"]`);
    row.querySelector('.price-input').value = opt.data('price') || 0;
    const unitSel = row.querySelector('.unit-input');
    const unit    = opt.data('unit') || '';
    for (let o of unitSel.options) { if (o.value === unit) { o.selected = true; break; } }
    calcRow(rn);
}

/* ── Remove row ── */
function removeRow(rn) {
    const rows = document.querySelectorAll('#itemsTbody .item-row');
    if (rows.length <= 1) { toastWarn('At least one row is required.'); return; }
    const row = document.querySelector(`tr[data-row="${rn}"]`);
    $(row).find('select').select2('destroy');
    row.remove();
    renumberRows();
    recalcAll();
}

function renumberRows() {
    document.querySelectorAll('#itemsTbody .item-row').forEach((tr, i) => { tr.cells[0].textContent = i + 1; });
}

/* ── Row calc ── */
function calcRow(rn) {
    const row   = document.querySelector(`tr[data-row="${rn}"]`);
    if (!row) return;
    const qty   = parseFloat(row.querySelector('.qty-input').value)      || 0;
    const price = parseFloat(row.querySelector('.price-input').value)    || 0;
    const disc  = parseFloat(row.querySelector('.row-disc-input').value) || 0;
    const isPct = row.querySelector('.row-disc-toggle').classList.contains('active');
    const gross    = qty * price;
    const discAmt  = isPct ? (gross * disc / 100) : disc;
    const rowTotal = Math.max(0, gross - discAmt);
    const span     = row.querySelector('.row-amount');
    span.textContent  = CURR + ' ' + rowTotal.toFixed(2);
    span.dataset.val  = rowTotal.toFixed(2);
    recalcAll();
}

/* ── Global recalc ── */
function recalcAll() {
    let subtotal = 0, totalQty = 0;
    document.querySelectorAll('#itemsTbody .item-row').forEach(row => {
        subtotal += parseFloat(row.querySelector('.row-amount').dataset.val) || 0;
        totalQty += parseFloat(row.querySelector('.qty-input').value) || 0;
    });

    // Global discount - recalculate based on last focus
    const pctInput = document.getElementById('discountPercent');
    const amtInput = document.getElementById('discountInput');
    
    if (discountFocus === 'pct' && subtotal > 0) {
        const p = parseFloat(pctInput.value) || 0;
        const a = Math.round(subtotal * p / 100);
        amtInput.value = a;
    } else if (discountFocus === 'amt' && subtotal > 0) {
        const a = parseFloat(amtInput.value) || 0;
        const p = Math.round((a / subtotal) * 100);
        pctInput.value = p;
    }

    const discAmt = parseFloat(amtInput.value) || 0;
    const afterDisc = Math.max(0, subtotal - discAmt);
    const taxAmt    = 0;

    let grandTotal = afterDisc + taxAmt;
    let roundOff   = 0;

    const paid       = parseFloat(document.getElementById('paidAmountInput').value) || 0;
    const balanceDue = Math.max(0, grandTotal - paid);
    const prevBal    = parseFloat(window._customerPrevBalance) || 0;
    const totalCust  = prevBal + balanceDue;

    document.getElementById('subtotalDisplay').textContent   = CURR + ' ' + subtotal.toFixed(2);
    document.getElementById('grandTotalDisplay').textContent = CURR + ' ' + grandTotal.toFixed(2);
    document.getElementById('grandTotalVal').value           = grandTotal.toFixed(2);
    document.getElementById('taxVal').value                  = taxAmt.toFixed(2);
    document.getElementById('balanceDueDisplay').textContent = CURR + ' ' + balanceDue.toFixed(2);
    document.getElementById('totalCustomerBalDisplay').textContent = CURR + ' ' + totalCust.toFixed(2);

    document.getElementById('footerQty').textContent    = totalQty % 1 === 0 ? totalQty : totalQty.toFixed(2);
    document.getElementById('footerAmount').textContent = SYM + ' ' + subtotal.toFixed(2);
}

/* ── Discount mode toggle ── */


function toggleRowDisc(btn, rn) {
    const isActive = btn.classList.toggle('active');
    btn.textContent = isActive ? '%' : 'Amt';
    calcRow(rn);
}

/* ── Submit update ── */
function submitUpdate() {
    const customerId = document.getElementById('customerSelect').value;
    if (!customerId) { toastError('Please select a customer.'); return; }

    const items = [];
    let valid = true;
    document.querySelectorAll('#itemsTbody .item-row').forEach(row => {
        const itemSel = row.querySelector('.item-select');
        const qty     = parseFloat(row.querySelector('.qty-input').value) || 0;
        if (!itemSel.value) return;
        if (qty <= 0) { toastError('Quantity must be greater than 0.'); valid = false; return; }
        const opt     = $(itemSel).find(':selected');
        const isPct   = row.querySelector('.row-disc-toggle').classList.contains('active');
        const disc    = parseFloat(row.querySelector('.row-disc-input').value) || 0;
        const price   = parseFloat(row.querySelector('.price-input').value) || 0;
        const discAmt = isPct ? (qty * price * disc / 100) : disc;
        items.push({
            product_id:   itemSel.value,
            product_name: opt.text().split('(')[0].trim(),
            product_code: '',
            unit:         row.querySelector('.unit-input').value || 'Piece',
            quantity:     qty,
            unit_price:   price,
            discount:     discAmt,
            total_price:  parseFloat(row.querySelector('.row-amount').dataset.val) || 0,
        });
    });

    if (!valid) return;
    if (items.length === 0) { toastError('Please add at least one product.'); return; }

    const data = {
        _token:         CSRF,
        _method:        'PUT',
        customer_id:    customerId,
        branch_id:      document.getElementById('branchSelect').value,
        invoice_date:   document.querySelector('input[name="invoice_date"]').value,
        payment_method: document.getElementById('paymentMethodSelect').value,
        discount:       parseFloat(document.getElementById('discountInput').value) || 0,
        tax:            0,
        total_amount:   parseFloat(document.getElementById('grandTotalVal').value) || 0,
        paid_amount:    parseFloat(document.getElementById('paidAmountInput').value) || 0,
        notes:          document.querySelector('textarea[name="notes"]').value,
        items,
    };

    const btn = document.querySelector('button[onclick="submitUpdate()"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin text-sm"></i> Updating...';

    $.ajax({
        url: R_UPDATE,
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function () {
            Swal.fire({ icon: 'success', title: 'Invoice Updated!', confirmButtonColor: '#004161' })
                .then(() => window.location.href = R_LIST);
        },
        error: function (xhr) {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check2-all text-sm"></i> Update Invoice';
            const errs = xhr.responseJSON?.errors;
            toastError(errs ? Object.values(errs).flat().join(' | ') : (xhr.responseJSON?.message || 'Failed to update.'));
        }
    });
}

/* ── Toast helpers ── */
function toastError(msg) {
    Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:4500 })
        .fire({ icon:'error', title:msg });
}
function toastWarn(msg) {
    Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3000 })
        .fire({ icon:'warning', title:msg });
}
</script>
@endpush

@endsection


