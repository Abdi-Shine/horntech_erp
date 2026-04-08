@extends('admin.admin_master')
@section('page_title', 'Purchase Return Detail')
@section('admin')

@php
    $currencyMap = ['SAR' => '﷼', 'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'AED' => 'د.إ', 'KWD' => 'د.ك', 'SOS' => 'Sh.So.', 'KES' => 'KSh'];
    $symbol = $currencyMap[$company->currency ?? ''] ?? ($company->currency ?? '$');

    $reasonLabels = [
        'damaged'   => 'Physical Damage on Arrival',
        'technical' => 'Technical Malfunction / Defect',
        'wrong_sku' => 'SKU Mismatch (Wrong Item)',
        'quality'   => 'Quality Control Violation',
    ];

    $statusClasses = [
        'approved' => 'bg-accent/10 text-accent border-accent/20',
        'pending'  => 'bg-primary/10 text-primary border-primary/20',
        'rejected' => 'bg-primary/10 text-primary border-primary/20',
    ];
@endphp

<div x-data="{
    showOptions: false,
    opts: {
        origQty:   true,
        unitPrice: true,
        supplier:  true,
        reason:    true,
    }
}" class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen w-full max-w-full overflow-hidden">

    {{-- ── Top Action Bar ── --}}
    <div class="print:hidden flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('purchase.returns') }}"
               class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-primary font-semibold rounded-lg hover:bg-gray-50 transition-all shadow-sm text-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="flex items-center gap-3">
            {{-- Options --}}
            <button @click="showOptions = true"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 font-semibold rounded-lg hover:bg-gray-50 transition-all shadow-sm text-sm">
                <i class="bi bi-gear text-primary"></i> Options
            </button>
            {{-- Print --}}
            <button onclick="window.print()"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-primary font-semibold rounded-lg hover:bg-gray-50 transition-all shadow-sm text-sm">
                <i class="bi bi-printer text-primary"></i> Print
            </button>
            {{-- Download PDF --}}
            <a href="{{ route('purchase.return.pdf', $return->id) }}"
               class="flex items-center gap-2 px-5 py-2 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 transition-all shadow-sm text-sm">
                <i class="bi bi-file-earmark-arrow-down"></i> Download PDF
            </a>
        </div>
    </div>

    {{-- ── Printable Document Card ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 md:p-10 print:p-0 print:border-none print:shadow-none w-full">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end border-b border-gray-100 pb-6 mb-8 gap-4">
            <div class="flex items-center gap-4">
                @if($company && $company->logo)
                    <img src="{{ asset($company->logo) }}" alt="Logo" class="h-14 object-contain">
                @else
                    <div class="h-14 w-14 bg-primary rounded-xl flex items-center justify-center text-white">
                        <i class="bi bi-building text-3xl"></i>
                    </div>
                @endif
                <div>
                    <h1 class="text-xl font-black text-primary">{{ $company->name ?? 'Company' }}</h1>
                    <p class="text-xs text-gray-400 mt-0.5">
                        @if($company->phone) {{ $company->phone }} @endif
                        @if($company->email) &nbsp;&bull;&nbsp; {{ $company->email }} @endif
                    </p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-black text-primary tracking-tight">DEBIT NOTE</div>
                <div class="text-sm font-bold text-gray-500 mt-1">{{ $return->return_number }}</div>
                <span class="mt-2 inline-block px-3 py-0.5 rounded-full border text-[10px] font-black uppercase tracking-widest {{ $statusClasses[$return->status ?? 'approved'] ?? 'bg-gray-50 text-gray-500 border-gray-200' }}">
                    {{ $return->status ?? 'Approved' }}
                </span>
            </div>
        </div>

        {{-- Meta Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-gray-50 rounded-xl border border-gray-100 p-4 mb-8">
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Return Date</p>
                <p class="text-sm font-bold text-primary">{{ \Carbon\Carbon::parse($return->return_date)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Ref. Bill No.</p>
                <p class="text-sm font-bold text-primary">{{ $return->bill->bill_number ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Branch</p>
                <p class="text-sm font-bold text-primary">{{ $return->branch->name ?? '-' }}</p>
            </div>
            <div class="text-right">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Processed By</p>
                <p class="text-sm font-bold text-primary">{{ $return->user->name ?? 'System' }}</p>
            </div>
        </div>

        {{-- Supplier Block --}}
        <div x-show="opts.supplier" class="flex flex-col sm:flex-row justify-between gap-6 mb-8">
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Return To (Supplier)</p>
                <h2 class="text-lg font-black text-primary-dark">{{ $return->supplier->name ?? 'N/A' }}</h2>
                @if($return->supplier)
                <div class="text-xs text-gray-400 mt-1 space-y-0.5">
                    @if($return->supplier->supplier_code) <p>Code: {{ $return->supplier->supplier_code }}</p> @endif
                    @if($return->supplier->phone) <p>Phone: {{ $return->supplier->phone }}</p> @endif
                    @if($return->supplier->email) <p>Email: {{ $return->supplier->email }}</p> @endif
                </div>
                @endif
            </div>
            <div class="text-right">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Document Info</p>
                <p class="text-sm font-bold text-primary">{{ $return->return_number }}</p>
                <p class="text-xs text-gray-400 mt-1">Generated: {{ now()->format('d M Y H:i') }}</p>
            </div>
        </div>

        {{-- Items Table --}}
        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3">Returned Items</p>
        <div class="overflow-x-auto rounded-xl border border-gray-100 mb-6">
            <table class="w-full text-left">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-wider">Product</th>
                        <th x-show="opts.origQty"  class="px-4 py-3 text-[10px] font-bold uppercase tracking-wider text-center">Orig. Qty</th>
                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-wider text-center">Return Qty</th>
                        <th x-show="opts.unitPrice" class="px-4 py-3 text-[10px] font-bold uppercase tracking-wider text-right">Unit Price</th>
                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-wider text-right">Credit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($return->items as $i => $item)
                    <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50/40' }} hover:bg-primary/5 transition-colors">
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">
                            <p class="font-bold text-sm text-primary-dark">{{ $item->product->product_name ?? 'Product' }}</p>
                            <p class="text-[10px] text-gray-400">{{ $item->product->product_code ?? '' }}</p>
                        </td>
                        <td x-show="opts.origQty"  class="px-4 py-3 text-center text-xs text-gray-400">{{ number_format($item->original_qty ?? 0, 0) }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-block bg-primary/10 text-primary border border-primary/20 px-2 py-0.5 rounded text-xs font-black">
                                {{ number_format($item->quantity, 0) }}
                            </span>
                        </td>
                        <td x-show="opts.unitPrice" class="px-4 py-3 text-right text-sm font-semibold text-gray-700">{{ $symbol }} {{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-4 py-3 text-right text-sm font-black text-primary">{{ $symbol }} {{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                            <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                            <p class="text-sm font-semibold">No items on this return.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Totals + Reason --}}
        <div class="flex flex-col sm:flex-row gap-6 justify-between">

            {{-- Reason --}}
            @if($return->reason)
            <div x-show="opts.reason" class="flex-1">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Return Reason</p>
                <div class="bg-primary/10 border border-primary/20 rounded-xl p-4">
                    <i class="bi bi-exclamation-triangle-fill text-primary mr-2"></i>
                    <span class="text-sm font-semibold text-primary">
                        {{ $reasonLabels[$return->reason] ?? ucfirst(str_replace('_', ' ', $return->reason)) }}
                    </span>
                </div>
            </div>
            @endif

            {{-- Totals --}}
            <div class="sm:w-72">
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 space-y-3">
                    <div class="flex justify-between text-sm font-semibold text-gray-500">
                        <span>Subtotal</span>
                        <span>{{ $symbol }} {{ number_format($return->subtotal ?? $return->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-semibold text-gray-500">
                        <span>Tax / VAT</span>
                        <span>{{ $symbol }} {{ number_format($return->tax ?? 0, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                        <span class="text-xs font-black text-primary uppercase tracking-wider">Total Credit</span>
                        <span class="text-xl font-black text-primary">{{ $symbol }} {{ number_format($return->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-10 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">This is a system-generated Debit Note and does not require a physical signature.</p>
            @if($company)
            <p class="text-xs text-gray-400 mt-1">
                {{ $company->name }}
                @if($company->email) &bull; {{ $company->email }} @endif
                @if($company->phone) &bull; {{ $company->phone }} @endif
            </p>
            @endif
        </div>

    </div>

    {{-- ── Print Options Modal ── --}}
    <div x-show="showOptions"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm print:hidden">

        <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl flex flex-col overflow-hidden" @click.away="showOptions = false">
            <div class="p-6">
                {{-- Modal Header --}}
                <div class="flex items-center gap-3 mb-5 border-b border-gray-100 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                        <i class="bi bi-printer"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-primary-dark">Print Options</h3>
                        <p class="text-[11px] font-semibold text-gray-400">Select columns to display</p>
                    </div>
                </div>

                {{-- Toggles --}}
                <div class="space-y-4">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-semibold text-gray-600 group-hover:text-primary-dark transition-colors">Original Bill Qty</span>
                        <input type="checkbox" x-model="opts.origQty"
                               class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4 cursor-pointer">
                    </label>
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-semibold text-gray-600 group-hover:text-primary-dark transition-colors">Unit Price</span>
                        <input type="checkbox" x-model="opts.unitPrice"
                               class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4 cursor-pointer">
                    </label>
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-semibold text-gray-600 group-hover:text-primary-dark transition-colors">Supplier Details</span>
                        <input type="checkbox" x-model="opts.supplier"
                               class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4 cursor-pointer">
                    </label>
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-semibold text-gray-600 group-hover:text-primary-dark transition-colors">Return Reason</span>
                        <input type="checkbox" x-model="opts.reason"
                               class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4 cursor-pointer">
                    </label>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center gap-3">
                <button type="button" @click="showOptions = false; window.print()"
                        class="flex-1 px-5 py-2.5 bg-white border border-gray-200 text-gray-600 font-semibold rounded-[0.5rem] hover:bg-gray-50 transition-all text-sm">
                    <i class="bi bi-printer mr-1"></i> Print Now
                </button>
                <button type="button" @click="showOptions = false"
                        class="flex-1 px-5 py-2.5 bg-primary text-white font-semibold rounded-[0.5rem] hover:bg-primary/90 transition-all text-sm shadow-sm">
                    Apply &amp; Close
                </button>
            </div>
        </div>
    </div>

</div>

@endsection

