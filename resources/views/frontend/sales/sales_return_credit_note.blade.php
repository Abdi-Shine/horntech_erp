@extends('admin.admin_master')
@section('page_title', 'Sales Returns')
@section('admin')
@php
    $currencySymbols = [
        'USD'=>'$','EUR'=>'€','GBP'=>'£','JPY'=>'¥','AUD'=>'A$','CAD'=>'C$',
        'CHF'=>'Fr','CNY'=>'¥','INR'=>'₹','MYR'=>'RM','SGD'=>'S$','AED'=>'د.إ',
        'SAR'=>'﷼','NGN'=>'₦','KES'=>'KSh','ZAR'=>'R',
    ];
    $symbol = $currencySymbols[$company->currency ?? 'USD'] ?? ($company->currency ?? '$');
@endphp

    <div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen" x-data="{
            showModal: false,
            customerName: 'SELECT CUSTOMER',
            returnAmount: '',
            returnDate: '{{ date('Y-m-d') }}'
        }">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
            <div>
                <h1 class="text-[20px] font-bold text-primary-dark">Sales Return & Credit Note</h1>
                <p class="text-[13px] text-gray-500 mt-1">Manage product returns and store credits</p>
            </div>
            <div class="flex items-center gap-3">
                <button @click="showModal = true" class="btn-premium-primary group">
                    <i class="bi bi-plus-lg group-hover:rotate-180 transition-transform duration-300"></i>
                    <span>New Credit Note</span>
                </button>
            </div>
        </div>

        <!-- Premium Statistics Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Returns -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Total Returns</p>
                    <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['total_returns']) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-clock-history text-xs"></i> This Month
                    </p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-arrow-return-left text-lg"></i>
                </div>
            </div>

            <!-- Return Value -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Return Value</p>
                    <h3 class="text-[18px] font-black text-primary">{{ $symbol }} {{ number_format($stats['return_value'], 2) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-cash-stack text-xs"></i> Total value
                    </p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-currency-dollar text-lg"></i>
                </div>
            </div>

            <!-- Active Credit Notes -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Credit Notes</p>
                    <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['credit_notes']) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-check-circle text-xs"></i> Successfully issued
                    </p>
                </div>
                <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                    <i class="bi bi-receipt text-lg"></i>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Pending</p>
                    <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['pending']) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                         <i class="bi bi-hourglass-split text-xs"></i> Awaiting Approval
                    </p>
                </div>
                <div class="w-11 h-11 bg-slate-50/50 rounded-[0.6rem] flex items-center justify-center text-primary/40 flex-shrink-0">
                    <i class="bi bi-patch-check text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Filter & Table Section -->
        <div class="bg-white rounded-[1rem] border border-gray-200/80 shadow-sm overflow-hidden mb-6">
            
            <!-- Filter Bar -->
            <form action="{{ route('sales.return.view') }}" method="GET"
                  x-data="{ hasFilters: {{ request()->hasAny(['search','status']) ? 'true' : 'false' }} }"
                  class="p-4 border-b border-gray-100 flex items-center gap-3 overflow-x-auto custom-scrollbar whitespace-nowrap">
                <!-- Search -->
                <div class="relative group min-w-[250px] flex-1">
                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-primary-dark"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search credit notes or customers..."
                        class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>

                <!-- Status Filter -->
                <div class="relative min-w-[150px]">
                    <select name="status" onchange="this.form.submit()" class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">All Status</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                </div>

                <!-- Clear Filters -->
                <button type="button" onclick="window.location.href='{{ route('sales.return.view') }}'"
                        x-show="hasFilters" x-transition
                        class="w-9 h-9 flex items-center justify-center bg-primary/10 text-primary rounded-[0.5rem] hover:bg-primary hover:text-white transition-all flex-shrink-0 shadow-sm border border-primary/10"
                        title="Clear All Filters">
                    <i class="bi bi-x-lg text-sm"></i>
                </button>
            </form>

            <!-- Table List Header -->
            <div class="px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50">
                <i class="bi bi-list-ul text-primary-dark text-sm"></i>
                <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">Credit Notes Records</h2>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-gray-100">
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider w-16 text-center">#</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Credit Note Info</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Customer</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Reference Info</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Amount</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Status</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($returns as $key => $return)
                        <tr class="hover:bg-gray-50/60 transition-colors bg-white group">
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                                {{ str_pad($returns->firstItem() + $key, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-semibold text-primary-dark">{{ $return->credit_note_no }}</span>
                                    <span class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($return->return_date)->format('d M, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-semibold text-primary-dark">{{ $return->customer->name ?? '—' }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $return->customer->phone ?? '' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-semibold text-primary-dark">{{ $return->invoice->invoice_no ?? '—' }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $return->reason }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-[12px] font-semibold text-primary-dark">{{ $symbol }} {{ number_format($return->amount, 2) }}</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $statusClass = match($return->status) {
                                        'approved' => 'status-completed',
                                        'pending'  => 'status-warning',
                                        default    => 'status-danger',
                                    };
                                    $statusLabel = match($return->status) {
                                        'approved' => 'APPROVED',
                                        'pending'  => 'PENDING',
                                        default    => 'REJECTED',
                                    };
                                @endphp
                                <span class="premium-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button onclick="confirmDeleteReturn({{ $return->id }})" class="btn-action-delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-return-{{ $return->id }}" action="{{ route('sales.return.destroy', $return->id) }}" method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-14 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-300">
                                    <i class="bi bi-inbox text-4xl"></i>
                                    <span class="text-xs font-semibold text-gray-400">No credit notes found</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Issue Credit Note Modal -->
        <div x-show="showModal" x-cloak
             class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">

            <div class="bg-white rounded-[1.25rem] w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative"
                 @click.away="showModal = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">

                <!-- Modal Header -->
                <div class="px-6 py-6 bg-primary relative overflow-hidden shrink-0">
                    <div class="flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-white text-xl shadow-inner backdrop-blur-md">
                                <i class="bi bi-arrow-return-left"></i>
                            </div>
                            <div class="flex flex-col">
                                <h2 class="text-xl font-bold text-white tracking-tight">Process Sales Return</h2>
                                <p class="text-xs text-white/60 font-medium mt-0.5">Issue a new credit note for your customer</p>
                            </div>
                        </div>
                        <button @click="showModal = false" class="w-8 h-8 bg-white/10 border border-white/10 text-white rounded-lg hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                            <i class="bi bi-x-lg text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 overflow-y-auto custom-scrollbar flex-grow bg-white">
                    <form id="creditNoteForm" action="{{ route('sales.return.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-black text-primary uppercase tracking-wider">Select Customer <span class="text-primary">*</span></label>
                                <div class="relative group">
                                    <select name="customer_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-primary focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Select Customer...</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-person absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-40"></i>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-black text-primary uppercase tracking-wider">Original Invoice</label>
                                <div class="relative group">
                                    <select name="invoice_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-primary focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Select Invoice (optional)...</option>
                                        @foreach($invoices as $invoice)
                                            <option value="{{ $invoice->id }}">{{ $invoice->invoice_no }} — {{ $invoice->customer->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-receipt absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-40"></i>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-black text-primary uppercase tracking-wider">Return Reason <span class="text-primary">*</span></label>
                                <div class="relative group">
                                    <select name="reason" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-primary focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Select reason...</option>
                                        <option value="Defective">Defective Product</option>
                                        <option value="Wrong">Wrong Item Delivered</option>
                                        <option value="Damaged">Damaged in Transit</option>
                                        <option value="Other">Other Reason</option>
                                    </select>
                                    <i class="bi bi-chat-dots absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-40"></i>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-black text-primary uppercase tracking-wider">Return Date <span class="text-primary">*</span></label>
                                <input type="date" name="return_date" x-model="returnDate" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-primary focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-black text-primary uppercase tracking-wider">Return Amount <span class="text-primary">*</span></label>
                            <div class="relative">
                                <input type="number" name="amount" step="0.01" required placeholder="0.00" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-primary focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-40 font-black text-xs">$</div>
                            </div>
                        </div>

                        <div class="space-y-1.5 pt-2">
                            <label class="block text-[11px] font-black text-primary uppercase tracking-wider">Additional Notes</label>
                            <textarea name="notes" rows="3" placeholder="Enter any additional notes..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-primary focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all resize-none"></textarea>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 shrink-0 flex items-center justify-between">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-white border border-gray-200 text-primary/60 font-black rounded-lg hover:bg-gray-50 transition-all text-[11px] uppercase tracking-wider shadow-sm">
                        Cancel
                    </button>
                    <button type="submit" form="creditNoteForm" class="btn-premium-accent">
                        <i class="bi bi-check2-circle text-base"></i>
                        <span>Issue Credit Note</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($returns->total() > 0)
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest">
                Showing {{ $returns->firstItem() ?? 0 }} to {{ $returns->lastItem() ?? 0 }} of {{ $returns->total() }} entries
            </p>
            <div class="flex items-center gap-1">
                @if ($returns->onFirstPage())
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm" disabled><i class="bi bi-chevron-left text-xs"></i></button>
                @else
                    <a href="{{ $returns->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 transition-all shadow-sm"><i class="bi bi-chevron-left text-xs"></i></a>
                @endif
                @foreach ($returns->links()->elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $returns->currentPage())
                                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-black text-xs shadow-md shadow-primary/20">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 transition-all shadow-sm text-xs font-bold">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @if ($returns->hasMorePages())
                    <a href="{{ $returns->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 transition-all shadow-sm"><i class="bi bi-chevron-right text-xs"></i></a>
                @else
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm" disabled><i class="bi bi-chevron-right text-xs"></i></button>
                @endif
            </div>
        </div>
        @endif

    </div>

</div>

<script>
function confirmDeleteReturn(id) {
    Swal.fire({
        title: 'Delete Credit Note?',
        text: 'This will reverse the journal entry and restore the customer balance. Cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#004161',
        cancelButtonColor: '#99CC33',
        confirmButtonText: 'Yes, delete it!',
        customClass: {
            popup: 'rounded-[1.5rem]',
            confirmButton: 'rounded-[0.5rem] px-6 py-2 text-xs font-bold uppercase tracking-widest',
            cancelButton: 'rounded-[0.5rem] px-6 py-2 text-xs font-bold uppercase tracking-widest',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-return-' + id).submit();
        }
    });
}
</script>

@endsection

