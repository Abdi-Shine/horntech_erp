@extends('admin.admin_master')
@section('page_title', 'Branch to Store Transfer')

@push('css')

@endpush

@section('admin')
    <div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen font-inter" x-data="{
                        openModal: null,
                        searchTerm: '',
                        statusFilter: '',
                        storeFilter: '',
                        branchFilter: '',
                        availableStock: 0,
                        isLoading: false,
                        formData: {
                            from_store_id: '{{ auth()->user()->getAssignedStoreId() ?? '' }}',
                            to_store_id: '',
                            product_id: '',
                            quantity: '',
                            remarks: 'Standard Replenishment Strategy',
                            type: 'branch-to-store'
                        },
                        init() {
                            this.$watch('formData.from_store_id', () => this.fetchStock());
                            this.$watch('formData.product_id', () => this.fetchStock());
                        },
                        shouldShow(no, product, status, fromStoreId, toStoreId) {
                            const matchesSearch = this.searchTerm === '' ||
                                                no.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                                                product.toLowerCase().includes(this.searchTerm.toLowerCase());
                            const matchesStatus = this.statusFilter === '' || status === this.statusFilter;
                            const matchesStore = this.storeFilter === '' || fromStoreId === this.storeFilter;
                            const matchesBranch = this.branchFilter === '' || toStoreId === this.branchFilter;
                            return matchesSearch && matchesStatus && matchesStore && matchesBranch;
                        },
                        async fetchStock() {
                            if (!this.formData.from_store_id || !this.formData.product_id) {
                                this.availableStock = 0; return;
                            }
                            try {
                                const url = new URL('{{ route('store-transfer.check-stock') }}', window.location.origin);
                                url.searchParams.append('product_id', this.formData.product_id);
                                url.searchParams.append('store_id', this.formData.from_store_id);
                                const res = await fetch(url);
                                const data = await res.json();
                                this.availableStock = data.available_stock || 0;
                            } catch(e) { console.error(e); }
                        },
                        async submitTransfer() {
                            if(!this.formData.from_store_id || !this.formData.to_store_id || !this.formData.product_id || !this.formData.quantity) {
                                return Swal.fire('Error', 'Please complete the logistical parameters before submission.', 'info');
                            }
                            if(this.formData.from_store_id === this.formData.to_store_id) {
                                return Swal.fire('Invalid Path', 'Source and Destination cannot be identical.', 'error');
                            }
                            if(Number(this.formData.quantity) > Number(this.availableStock)) {
                                const conf = await Swal.fire({
                                    title: 'Stock Alert',
                                    text: `Requested quantity exceeds physical limits. Stock available: ${this.availableStock}. Proceed with override?`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    cancelButtonColor: '#99CC33'
                                });
                                if(!conf.isConfirmed) return;
                            }

                            this.isLoading = true;
                            try {
                                const res = await fetch('{{ route('store-transfer.store') }}', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                    body: JSON.stringify(this.formData)
                                });
                                const data = await res.json();
                                if(data.success) {
                                    Swal.fire('Success', 'Inventory movement protocol initiated.', 'success').then(() => location.reload());
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            } catch (e) {
                                Swal.fire('System Error', 'Could not establish connection.', 'error');
                            } finally {
                                this.isLoading = false;
                            }
                        },
                        async performAction(id, action) {
                            const confirmText = action === 'approve' ? 'fully authorize' : 'deny';
                            const result = await Swal.fire({
                                title: 'Authorization Required',
                                text: `Do you want to ${confirmText} this logistical request?`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: action === 'approve' ? '#10b981' : '#f43f5e',
                                cancelButtonColor: '#99CC33',
                                confirmButtonText: 'Yes, proceed'
                            });

                            if(result.isConfirmed) {
                                try {
                                    const res = await fetch(`{{ url('/store-transfer/action/') }}/${id}`, {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                        body: JSON.stringify({ action })
                                    });
                                    const data = await res.json();
                                    if(data.success) {
                                        Swal.fire('Acknowledged', data.message, 'success').then(() => location.reload());
                                    } else {
                                        Swal.fire('Declined', data.message, 'error');
                                    }
                                } catch(e) {
                                    Swal.fire('System Failure', 'The action encountered a fatal network error.', 'error');
                                }
                            }
                        },
                        editTransfer(transfer) {
                            if(transfer.status !== 'pending') {
                                Swal.fire('Modification Locked', 'Only pending transfers can be modified.', 'warning');
                                return;
                            }
                            Swal.fire({
                                title: 'Edit Mode Enabled',
                                text: 'Transfer ' + transfer.transfer_no + ' has been loaded into the editor. (Note: Backend update endpoint requires configuration)',
                                icon: 'info',
                                confirmButtonColor: '#004161'
                            });
                            this.formData = {
                                id: transfer.id,
                                from_store_id: transfer.from_store_id,
                                to_store_id: transfer.to_store_id,
                                product_id: transfer.product_id,
                                quantity: transfer.quantity,
                                remarks: transfer.remarks,
                                type: transfer.type || 'branch-to-store'
                            };
                            this.openModal = 'new-transfer';
                        },
                        deleteTransfer(id) {
                            Swal.fire({
                                title: 'Confirm Deletion',
                                text: 'Are you sure you want to delete this transfer log? This cannot be undone.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#e3342f',
                                cancelButtonColor: '#99CC33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then(async (result) => {
                                if (result.isConfirmed) {
                                    try {
                                        const res = await fetch(`{{ url('/store-transfer/delete') }}/${id}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        });
                                        const data = await res.json();
                                        if (data.success) {
                                            Swal.fire('Deleted!', 'The transfer record has been removed.', 'success').then(() => location.reload());
                                        } else {
                                            Swal.fire('Locked', data.message || 'Deletion failed', 'error');
                                        }
                                    } catch (e) {
                                        Swal.fire('Error', 'Server failure occurred', 'error');
                                    }
                                }
                            });
                        },
                        viewDetails(id, text) {
                            Swal.fire({
                                title: 'Transfer Instructions',
                                text: text || 'No instructions provided for this exchange.',
                                icon: 'info',
                                confirmButtonColor: '#004161'
                            });
                        },
                        exportReport() {
                            Swal.fire('Transfer Log', 'Printing or exporting transfer registry log...', 'info');
                        }
                }">
        <!-- Header Section -->
        <div
            class="animate-in fade-in slide-in-from-top-4 duration-500 flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-[20px] font-bold text-primary-dark">{{ $page_title ?? 'Branch to Store Transfer' }}</h1>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" @click="openModal = 'new-transfer'" class="btn-premium-primary group normal-case">
                    <i class="bi bi-plus-lg group-hover:rotate-180 transition-transform duration-300"></i>
                    <span>Add Transfer</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Pending -->
            <div
                class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Pending Transfers</p>
                    <h3 class="text-[18px] font-black text-primary">{{ $stats['pending'] }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-clock-history text-[10px]"></i> Waiting for Action
                    </p>
                </div>
                <div
                    class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-clock-history text-lg"></i>
                </div>
            </div>

            <!-- Sent Today -->
            <div
                class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Sent Today</p>
                    <h3 class="text-[18px] font-black text-primary">{{ $stats['approved_today'] }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-truck text-[10px]"></i> Batches Processed
                    </p>
                </div>
                <div
                    class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                    <i class="bi bi-truck text-lg"></i>
                </div>
            </div>

            <!-- Monthly Volume -->
            <div
                class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Moved This Month</p>
                    <h3 class="text-[18px] font-black text-primary">{{ number_format($stats['completed_month']) }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-box-seam text-[10px]"></i> Units Moved
                    </p>
                </div>
                <div
                    class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-box-seam text-lg"></i>
                </div>
            </div>

            <!-- Total Value -->
            <div
                class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Total Stock Value</p>
                    <h3 class="text-[18px] font-black text-primary">
                        {{ $company->currency_symbol ?? '$' }}{{ number_format($stats['total_value'] / 1000, 1) }}K
                    </h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Value of transfers</p>
                </div>
                <div
                    class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                    <i class="bi bi-currency-dollar text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Filter & Table Section -->
        <div class="bg-white rounded-[1rem] border border-gray-200/80 shadow-sm overflow-hidden mb-6">

            <!-- Filters -->
            <div
                class="p-4 border-b border-gray-100 flex items-center gap-3 overflow-x-auto custom-scrollbar whitespace-nowrap">
                <!-- Search -->
                <div class="relative group min-w-[250px] flex-1">
                    <i
                        class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-primary-dark"></i>
                    <input type="text" x-model="searchTerm" placeholder="Search product or transfer ID..."
                        class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>

                <!-- All Stores -->
                <div class="relative min-w-[150px]">
                    <select x-model="storeFilter"
                        class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">All Stores</option>
                        @foreach($stores as $st)
                            <option value="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                    </select>
                    <i
                        class="bi bi-shop absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                </div>

                <!-- All Branches -->
                <div class="relative min-w-[150px]">
                    <select x-model="branchFilter"
                        class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">All Branches</option>
                        @foreach($branches as $br)
                            @php $hub = $stores->where('branch_id', $br->id)->first(); @endphp
                            @if($hub)
                                <option value="{{ $hub->id }}">{{ $br->name }} Hub</option>
                            @endif
                        @endforeach
                    </select>
                    <i
                        class="bi bi-building absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                </div>

                <div class="relative min-w-[150px]">
                    <select x-model="statusFilter"
                        class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <i
                        class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                </div>

                <!-- Clear Filters -->
                <button @click="searchTerm = ''; statusFilter = ''; storeFilter = ''; branchFilter = '';"
                    class="w-9 h-9 flex items-center justify-center bg-primary/10 text-primary rounded-[0.5rem] hover:bg-primary hover:text-white transition-all flex-shrink-0 shadow-sm border border-primary/10"
                    x-show="searchTerm !== '' || statusFilter !== '' || storeFilter !== '' || branchFilter !== ''"
                    x-transition title="Clear All Filters">
                    <i class="bi bi-x-lg text-sm"></i>
                </button>
            </div>

            <div class="px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50">
                <i class="bi bi-list-ul text-primary-dark text-sm"></i>
                <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">Transfer List</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left">
                    <thead>
                        <tr>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center w-12">
                                #</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Ref</th>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-left">
                                Product</th>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-left">
                                From Store</th>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-left">
                                To Branch</th>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">
                                Qty</th>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-left">
                                Requested By</th>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-left">
                                Authorized By</th>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">
                                Status</th>
                            <th
                                class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transfers ?? [] as $t)
                            <tr class="hover:bg-gray-50/60 transition-colors bg-white group"
                                x-show="shouldShow('{{ $t->transfer_no }}', '{{ $t->product->product_name }}', '{{ $t->status }}', '{{ $t->from_store_id }}', '{{ $t->to_store_id }}')">
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
                                    {{ $t->fromStore->name }}
                                </td>
                                <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                    {{ $t->toStore->name }}
                                </td>
                                <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                                    {{ $t->quantity }}
                                </td>
                                <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                    {{ $t->requester->name }}
                                </td>
                                <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                                    @if($t->approved_by && $t->approver)
                                        <span>{{ $t->approver->name }}</span>
                                    @else
                                        <span class="opacity-60 italic">Awaiting</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @php $tst = strtolower($t->status); @endphp
                                    @if($tst === 'pending')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">Pending</span>
                                    @elseif($tst === 'completed' || $tst === 'approved')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-accent/10 text-primary border border-accent/20 uppercase tracking-wider">{{ ucfirst($t->status) }}</span>
                                    @elseif($tst === 'rejected')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">Rejected</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-gray-100 text-gray-400 border border-gray-200 uppercase tracking-wider">{{ ucfirst($t->status) }}</span>
                                    @endif
                                </td>
                                <!-- Actions -->
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @php
                                            $userRole = strtolower(trim(auth()->user()->role ?? ''));
                                            $isManagement = in_array($userRole, ['admin', 'super admin', 'manager', 'branch manager']);
                                            $userStoreId = auth()->user()->getAssignedStoreId();
                                            $isRequester = auth()->id() === $t->requested_by;

                                            $canApprove = false;
                                            if ($t->status === 'pending' && !$isRequester) {
                                                if ($isManagement || ($userStoreId == $t->to_store_id || $userStoreId == $t->from_store_id)) {
                                                    $canApprove = true;
                                                }
                                            }
                                        @endphp

                                        @if($canApprove)
                                            <button @click="performAction({{ $t->id }}, 'approve')" class="btn-action-view"
                                                title="Receive / Authorize">
                                                <i class="bi bi-shield-check"></i>
                                            </button>
                                        @endif

                                        @if($t->status === 'pending' && ($isManagement || $isRequester))
                                            <button @click="performAction({{ $t->id }}, 'reject')" class="btn-action-delete"
                                                title="Reject">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        @endif

                                        <button type="button"
                                            @click="editTransfer({ id: {{ $t->id }}, transfer_no: '{{ $t->transfer_no }}', from_store_id: '{{ $t->from_store_id }}', to_store_id: '{{ $t->to_store_id }}', product_id: '{{ $t->product_id }}', quantity: {{ $t->quantity }}, remarks: '{{ addslashes($t->remarks ?? '') }}', status: '{{ $t->status }}' })"
                                            class="btn-action-edit" title="Edit Transfer">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button class="btn-action-delete" @click="deleteTransfer({{ $t->id }})"
                                            title="Delete Transfer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-5 py-10 text-center">
                                    <span class="text-xs italic text-gray-400">No transfers found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Placeholder -->
            <div class="px-5 py-4 border-t border-gray-100 bg-white flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                    Showing {{ count($transfers ?? []) > 0 ? 1 : 0 }} to {{ count($transfers ?? []) }} of
                    {{ count($transfers ?? []) }} entries
                </span>
                <div class="flex items-center gap-1.5">
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-md bg-white border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors shadow-sm"><i
                            class="bi bi-chevron-left text-[10px]"></i></button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-md bg-primary-dark text-white font-bold text-xs shadow-sm">1</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-md bg-white border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors shadow-sm"><i
                            class="bi bi-chevron-right text-[10px]"></i></button>
                </div>
            </div>
        </div>

        <!-- Modal Section -->
        <div x-show="openModal === 'new-transfer'" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">

            <div class="bg-white rounded-[1.25rem] w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col"
                @click.away="openModal = null">
                <!-- Modal Header -->
                <div class="px-6 py-6 bg-primary relative overflow-hidden shrink-0">
                    <div class="flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-xl shadow-inner backdrop-blur-md text-white">
                                <i class="bi bi-diagram-3"></i>
                            </div>
                            <div class="flex flex-col">
                                <h2 class="text-xl font-bold tracking-tight text-white">Initiate Transfer</h2>
                                <p class="text-xs text-white/60 font-medium mt-0.5">Fill in the required transfer details
                                    below</p>
                            </div>
                        </div>
                        <button @click="openModal = null"
                            class="w-8 h-8 bg-white/10 border border-white/10 text-white rounded-lg hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                            <i class="bi bi-x-lg text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 overflow-y-auto custom-scrollbar flex-grow bg-white">
                    <form @submit.prevent="submitTransfer" id="transferForm" class="space-y-6">
                        <!-- Route Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Source Store
                                    <span class="text-primary">*</span></label>
                                <div class="relative">
                                    <select x-model="formData.from_store_id" required
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none">
                                        <option value="">Select source store...</option>
                                        @foreach($stores->groupBy('branch.name') as $branchName => $branchStores)
                                            <optgroup label="{{ $branchName }}">
                                                @foreach($branchStores as $st)
                                                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <i
                                        class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Target Hub
                                    Branch <span class="text-primary">*</span></label>
                                <div class="relative">
                                    <select x-model="formData.to_store_id" required
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none">
                                        <option value="">Select destination...</option>
                                        @foreach($branches as $branch)
                                            @php $hub = $stores->where('branch_id', $branch->id)->first(); @endphp
                                            @if($hub)
                                                <option value="{{ $hub->id }}">{{ $branch->name }} Hub</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <i
                                        class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-gray-100">
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Product <span
                                        class="text-primary">*</span></label>
                                <div class="relative">
                                    <select x-model="formData.product_id" required
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none">
                                        <option value="">Select product...</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->product_name }} ({{ $p->product_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <i
                                        class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                                <div x-show="formData.product_id && formData.from_store_id"
                                    class="text-[11px] font-medium px-2 py-0.5 rounded mt-1"
                                    :class="availableStock > 0 ? 'bg-accent/10 text-accent border border-accent/20' : 'bg-primary/10 text-primary border border-primary/20'">
                                    Available Stock: <span x-text="availableStock" class="font-bold"></span>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Unit Count <span
                                        class="text-primary">*</span></label>
                                <div class="relative">
                                    <input type="number" x-model="formData.quantity" required min="1" placeholder="0"
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                                    <i
                                        class="bi bi-hash absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="space-y-1.5 pt-4 border-t border-gray-100">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Batch
                                Remarks</label>
                            <textarea x-model="formData.remarks" rows="3" placeholder="Transfer remarks..."
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all resize-none"></textarea>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/80 flex items-center justify-between">
                    <button type="button" @click="openModal = null" 
                        class="px-6 py-2.5 bg-accent text-primary font-bold rounded-lg hover:bg-accent/90 transition-all text-[13px] uppercase tracking-wide shadow-sm min-w-[120px]">
                        Cancel
                    </button>
                    <button type="submit" form="transferForm" :disabled="isLoading" 
                        class="px-6 py-2.5 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-all text-[13px] uppercase tracking-wide shadow-sm flex items-center justify-center gap-2 min-w-[150px]">
                        <template x-if="isLoading">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </template>
                        <span x-show="!isLoading" class="flex items-center justify-center gap-2">
                            <i class="bi bi-check2-circle"></i>
                            <span>Submit Transfer</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection