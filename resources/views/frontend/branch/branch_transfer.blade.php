@extends('admin.admin_master')
@section('page_title', 'Branch Transfer')


@section('admin')
<div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen font-inter" x-data="branchTransfer()">
    <!-- Header Section -->
    <div class="animate-in fade-in slide-in-from-top-4 duration-500 flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-[20px] font-bold text-primary-dark">{{ $page_title ?? 'Inter-Branch Transfer' }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" @click="createNewTransfer()" class="btn-premium-primary group normal-case">
                <i class="bi bi-plus-lg group-hover:rotate-180 transition-transform duration-300"></i>
                <span>New Transfer</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Pending -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Pending Transfers</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['pending'] }} Waiting</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                    <i class="bi bi-clock-history text-[10px]"></i> Action Required
                </p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-clock-history text-lg"></i>
            </div>
        </div>

        <!-- Sent Today -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Sent Today</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['approved_today'] }} Batches</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                    <i class="bi bi-truck text-[10px]"></i> Processed Today
                </p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-truck text-lg"></i>
            </div>
        </div>

        <!-- Monthly Volume -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Moved This Month</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['completed_month']) }} Units</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                    <i class="bi bi-box-seam text-[10px]"></i> Total Monthly Volume
                </p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-box-seam text-lg"></i>
            </div>
        </div>

        <!-- Total Value -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Stock Value</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency_symbol ?? '$' }}{{ number_format($stats['total_value'] / 1000, 1) }}K</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Value of transfers</p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-currency-dollar text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[1rem] border border-gray-200/80 shadow-sm overflow-hidden mb-6">

        <!-- Filters -->
        <div class="p-4 border-b border-gray-100 flex items-center gap-3 overflow-x-auto custom-scrollbar whitespace-nowrap">
            <!-- Search -->
            <div class="relative group min-w-[250px] flex-1">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-primary-dark"></i>
                <input type="text" x-model="searchTerm" placeholder="Search transfer..." class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400">
            </div>

            <!-- Filter Options -->
            <div class="flex gap-2">
                <select x-model="statusFilter" class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer min-w-[140px]">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="rejected">Rejected</option>
                </select>

                <select x-model="branchFilter" class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer min-w-[140px]">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Clear Filters -->
            <button @click="searchTerm = ''; statusFilter = ''; branchFilter = '';"
                    class="w-9 h-9 flex items-center justify-center bg-primary/10 text-primary rounded-[0.5rem] hover:bg-primary hover:text-white transition-all flex-shrink-0 shadow-sm border border-primary/10" 
                    x-show="searchTerm !== '' || statusFilter !== '' || branchFilter !== ''"
                    x-transition
                    title="Clear All Filters">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>

        <div class="px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50">
            <i class="bi bi-list-ul text-primary-dark text-sm"></i>
            <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">TRANSFER LIST</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider w-12 text-center">#</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">REF</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">PRODUCT</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-left">FROM BRANCH</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-left">TO BRANCH</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">QTY</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">REQUESTED BY</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">AUTHORIZED BY</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">STATUS</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">ACTIONS</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transfers ?? [] as $t)
                        <tr class="hover:bg-gray-50/60 transition-colors bg-white group" x-show="shouldShow('{{ $t->transfer_no }}', '{{ $t->product->product_name }}', '{{ $t->status }}', '{{ $t->from_branch_id }}', '{{ $t->to_branch_id }}')">
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                {{ $t->transfer_no }}
                            </td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                {{ $t->product->product_name }}
                            </td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                {{ $t->fromBranch->name }}
                            </td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                {{ $t->toBranch->name }}
                            </td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                                {{ $t->quantity }}
                            </td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                {{ $t->requester->name }}
                            </td>
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                @if($t->approved_by && $t->approver)
                                    {{ $t->approver->name }}
                                @else
                                    <span class="opacity-40 italic">Awaiting</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($t->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">Pending</span>
                                @elseif($t->status === 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-accent/10 text-primary border border-accent/20 uppercase tracking-wider">Completed</span>
                                @elseif($t->status === 'rejected')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">Rejected</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-gray-50 text-gray-400 border border-gray-200 uppercase tracking-wider">{{ $t->status }}</span>
                                @endif
                            </td>


                            <!-- Actions -->
                        <td class="px-5 py-4 text-right">
                            @php
                                $userRole    = strtolower(trim(auth()->user()->role ?? ''));
                                $isManagement = in_array($userRole, ['admin', 'super admin', 'manager', 'branch manager']);
                                $userBranchId = auth()->user()->getAssignedBranchId();
                                $isRequester  = auth()->id() === $t->requested_by;
                                $canApprove   = $t->status === 'pending' && !$isRequester && ($isManagement || $userBranchId == $t->to_branch_id);
                            @endphp
                            <div class="flex items-center justify-end gap-1.5 min-h-[32px]">
                                <button @click="editTransfer({ id: {{ $t->id }}, transfer_no: '{{ $t->transfer_no }}', status: '{{ $t->status }}', from_branch_id: '{{ $t->from_branch_id }}', to_branch_id: '{{ $t->to_branch_id }}', product_id: '{{ $t->product_id }}', quantity: {{ $t->quantity }}, remarks: '{{ addslashes($t->remarks ?? '') }}' })" class="btn-action-edit" title="Edit Transfer">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button @click="deleteTransfer({{ $t->id }})" class="btn-action-delete" title="Delete Transfer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-5 py-14 text-center text-gray-400 text-xs italic">No transfers found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest">
                Showing <span class="text-primary-dark">{{ count($transfers) }}</span> of <span class="text-primary-dark">{{ count($transfers) }}</span> entries
            </p>
            <div class="flex items-center gap-1">
                <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm" disabled>
                    <i class="bi bi-chevron-left text-xs"></i>
                </button>
                <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-black text-xs shadow-md shadow-primary/20">1</button>
                <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm" disabled>
                    <i class="bi bi-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Section -->
    <div x-show="openModal === 'new-transfer'" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">

        <div class="bg-white rounded-[1.25rem] w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col" @click.away="openModal = null">
            <!-- Modal Header -->
            <div class="px-6 py-5 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-xl shadow-inner backdrop-blur-md text-white">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-xl font-bold tracking-tight text-white" x-text="isEdit ? 'Edit Transfer' : 'New Branch Transfer'"></h2>
                            <p class="text-xs text-white/60 font-medium mt-0.5" x-text="isEdit ? 'Modify the parameters of this transfer' : 'Allocate inventory across your branches'"></p>
                        </div>
                    </div>
                    <button @click="openModal = null" class="w-8 h-8 bg-white/10 border border-white/10 text-white rounded-lg hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6 overflow-y-auto custom-scrollbar flex-grow bg-white">
                <form id="transferForm" @submit.prevent="submitTransfer">
                    <div class="space-y-6">

                        <!-- From / To Branch -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">From Branch <span class="text-primary">*</span></label>
                                <div class="relative">
                                    <select x-model="formData.from_branch_id" required
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Select source branch...</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-building absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">To Branch <span class="text-primary">*</span></label>
                                <div class="relative">
                                    <select x-model="formData.to_branch_id" required
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Select destination branch...</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                x-show="formData.from_branch_id != '{{ $branch->id }}'"
                                                x-bind:disabled="formData.from_branch_id == '{{ $branch->id }}'">
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-building-check absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Product / Quantity -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-gray-100">
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Product <span class="text-primary">*</span></label>
                                <div class="relative">
                                    <select x-model="formData.product_id" required
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Select product...</option>
                                        <template x-for="p in availableProducts" :key="p.id">
                                            <option :value="p.id" x-text="p.name"></option>
                                        </template>
                                    </select>
                                    <i class="bi bi-box-seam absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Quantity <span class="text-primary">*</span></label>
                                    <div x-show="formData.product_id && formData.from_branch_id" x-transition
                                        class="text-[10px] font-bold px-2.5 py-0.5 rounded-full border"
                                        :class="availableStock > 0 ? 'bg-accent/10 text-primary border-accent/20' : 'bg-primary/10 text-primary border-primary/20'">
                                        Stock: <span x-text="availableStock"></span>
                                    </div>
                                </div>
                                <div class="relative">
                                    <input type="number" x-model="formData.quantity" required min="1" placeholder="Enter quantity"
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                                    <i class="bi bi-hash absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="space-y-1.5 pt-4 border-t border-gray-100">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Remarks</label>
                            <textarea x-model="formData.remarks" rows="3" placeholder="Add notes about this transfer..."
                                class="w-full pl-4 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all resize-none"></textarea>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/80 flex items-center justify-between shrink-0">
                <button type="button" @click="openModal = null" class="btn-premium-accent">Cancel</button>
                <button type="submit" form="transferForm" :disabled="isLoading" class="btn-premium-primary">
                    <template x-if="isLoading">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </template>
                    <span x-show="!isLoading" class="flex items-center gap-2">
                        <i :class="isEdit ? 'bi bi-arrow-repeat' : 'bi bi-check2-circle'"></i>
                        <span x-text="isEdit ? 'Update Transfer' : 'Confirm Transfer'"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

</div>

<script>
function branchTransfer() {
    return {
        openModal: null,
        searchTerm: '',
        statusFilter: '',
        branchFilter: '',
        availableStock: 0,
        isLoading: false,
        isEdit: false,
        formData: {
            id: null,
            from_branch_id: '{{ auth()->user()->getAssignedBranchId() ?? '' }}',
            to_branch_id: '',
            product_id: '',
            quantity: '',
            remarks: 'Inter-Branch Transfer',
        },
        allProducts: @json($products->map(fn($p) => ['id' => $p->id, 'name' => $p->product_name . ' (' . $p->product_code . ')', 'branch_ids' => $p->stocks->pluck('branch_id')->map(fn($id) => (string)$id)->toArray()])),
        get availableProducts() {
            if (!this.formData.from_branch_id) return [];
            return this.allProducts.filter(p => p.branch_ids.includes(String(this.formData.from_branch_id)));
        },
        init() {
            this.$watch('formData.from_branch_id', (val) => {
                if (this.formData.to_branch_id === val && val !== '') {
                    this.formData.to_branch_id = '';
                }
                if (this.formData.product_id && !this.availableProducts.some(p => p.id == this.formData.product_id)) {
                    this.formData.product_id = '';
                }
                this.fetchStock();
            });
            this.$watch('formData.product_id', () => this.fetchStock());
        },
        shouldShow(no, product, status, fromId, toId) {
            const matchesSearch  = this.searchTerm === '' || no.toLowerCase().includes(this.searchTerm.toLowerCase()) || product.toLowerCase().includes(this.searchTerm.toLowerCase());
            const matchesStatus  = this.statusFilter === '' || status === this.statusFilter;
            const matchesBranch  = this.branchFilter === '' || fromId == this.branchFilter || toId == this.branchFilter;
            return matchesSearch && matchesStatus && matchesBranch;
        },
        async fetchStock() {
            if (!this.formData.from_branch_id || !this.formData.product_id) { this.availableStock = 0; return; }
            try {
                const url = new URL('{{ route('branch-transfer.check-stock') }}', window.location.origin);
                url.searchParams.append('product_id', this.formData.product_id);
                url.searchParams.append('branch_id', this.formData.from_branch_id);
                const res  = await fetch(url);
                const data = await res.json();
                this.availableStock = data.available_stock || 0;
            } catch(e) { console.error(e); }
        },
        async submitTransfer() {
            if (!this.formData.from_branch_id || !this.formData.to_branch_id || !this.formData.product_id || !this.formData.quantity) {
                return Swal.fire('Error', 'Please fill all required fields.', 'error');
            }
            if (this.formData.from_branch_id === this.formData.to_branch_id) {
                return Swal.fire('Invalid', 'Source and destination cannot be the same.', 'error');
            }
            if (Number(this.formData.quantity) > Number(this.availableStock)) {
                const conf = await Swal.fire({ title: 'Stock Alert', text: `Only ${this.availableStock} units available. Proceed?`, icon: 'warning', showCancelButton: true, cancelButtonColor: '#99CC33' });
                if (!conf.isConfirmed) return;
            }
            this.isLoading = true;
            try {
                const res  = await fetch('{{ route('branch-transfer.store') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(this.formData)
                });
                const data = await res.json();
                if (data.success) {
                    Swal.fire('Success', data.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            } catch (e) {
                Swal.fire('System Error', 'Could not connect to server.', 'error');
            } finally {
                this.isLoading = false;
            }
        },
        async performAction(id, action) {
            const result = await Swal.fire({
                title: 'Review Transfer',
                text: `Do you want to ${action === 'approve' ? 'approve' : 'reject'} this transfer?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: action === 'approve' ? '#10b981' : '#f43f5e',
                cancelButtonColor: '#99CC33',
                confirmButtonText: 'Yes, proceed'
            });
            if (result.isConfirmed) {
                try {
                    const res  = await fetch(`{{ url('/branch-transfer/action/') }}/${id}`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ action })
                    });
                    const data = await res.json();
                    data.success ? Swal.fire('Done', data.message, 'success').then(() => location.reload())
                                 : Swal.fire('Error', data.message, 'error');
                } catch(e) { Swal.fire('Error', 'Network failure.', 'error'); }
            }
        },
        async deleteTransfer(id) {
            const { isConfirmed } = await Swal.fire({ title: 'Delete Transfer?', text: 'This will permanently remove the record.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#e11d48', cancelButtonColor: '#99CC33' });
            if (isConfirmed) {
                try {
                    const res  = await fetch(`{{ url('/branch-transfer/delete') }}/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                    const data = await res.json();
                    data.success ? Swal.fire('Deleted', data.message, 'success').then(() => location.reload())
                                 : Swal.fire('Error', data.message, 'error');
                } catch(e) { Swal.fire('Error', 'Connection failure.', 'error'); }
            }
        },
        createNewTransfer() {
            this.isEdit = false;
            this.formData = { id: null, from_branch_id: '{{ auth()->user()->getAssignedBranchId() ?? '' }}', to_branch_id: '', product_id: '', quantity: '', remarks: 'Inter-Branch Transfer' };
            this.openModal = 'new-transfer';
        },
        editTransfer(t) {
            if (t.status !== 'pending') {
                Swal.fire('Locked', 'Only pending transfers can be edited.', 'warning');
                return;
            }
            this.isEdit   = true;
            this.formData = { id: t.id, from_branch_id: t.from_branch_id, to_branch_id: t.to_branch_id, product_id: t.product_id, quantity: t.quantity, remarks: t.remarks };
            this.openModal = 'new-transfer';
            setTimeout(() => this.fetchStock(), 100);
        },
    };
}
</script>
@endsection


