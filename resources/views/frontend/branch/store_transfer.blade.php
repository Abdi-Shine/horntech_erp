@extends('admin.admin_master')
@section('page_title', 'Store Transfer')

@section('admin')
<div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen font-inter" x-data="storeTransfer()">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <div>
            <h1 class="text-[20px] font-bold text-primary-dark">{{ $page_title ?? 'Store Transfer' }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" @click="openModal = 'new-transfer'" class="btn-premium-primary group normal-case">
                <i class="bi bi-plus-lg group-hover:rotate-180 transition-transform duration-300"></i>
                Add Transfer
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
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
                <i class="bi bi-check-circle text-lg"></i>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Moved This Month</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['completed_month'] }} Units</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                    <i class="bi bi-box-seam text-[10px]"></i> Monthly Total
                </p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-check2-all text-lg"></i>
            </div>
        </div>

        <!-- Value -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Stock Value</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? '$' }}{{ number_format($stats['total_value'], 0) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">Value of transfers</p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-currency-dollar text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Table Section -->
    <div class="bg-white rounded-[1rem] border border-gray-200/80 shadow-sm overflow-hidden mb-6">

        <!-- Filters -->
        <div class="p-4 border-b border-gray-100 flex items-center gap-3 overflow-x-auto custom-scrollbar whitespace-nowrap">
            <!-- Search -->
            <div class="relative group min-w-[250px] flex-1">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-primary-dark"></i>
                <input type="text" x-model="searchTerm" placeholder="Search transfer..."
                    class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400">
            </div>

            <!-- Status Filter -->
            <div class="relative min-w-[150px]">
                <select x-model="statusFilter"
                    class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="completed">Completed</option>
                    <option value="rejected">Rejected</option>
                </select>
                <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
            </div>

            <!-- Store Filter -->
            <div class="relative min-w-[150px]">
                <select x-model="storeFilter"
                    class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">All Stores</option>
                    @foreach($stores as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                </select>
                <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
            </div>

            <!-- Clear Filters -->
            <button @click="searchTerm = ''; statusFilter = ''; storeFilter = '';" 
                    class="w-9 h-9 flex items-center justify-center bg-primary/10 text-primary rounded-[0.5rem] hover:bg-primary hover:text-white transition-all flex-shrink-0 shadow-sm border border-primary/10" 
                    x-show="searchTerm !== '' || statusFilter !== '' || storeFilter !== ''"
                    x-transition
                    title="Clear All Filters">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>

        <!-- Table Title -->
        <div class="px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50">
            <i class="bi bi-list-ul text-primary-dark text-sm"></i>
            <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">Transfer List</h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider w-16 text-center">#</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Ref</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Product</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">From Store</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">To Store</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Qty</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Requested By</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Authorized By</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Status</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transfers ?? [] as $transfer)
                        <tr class="hover:bg-gray-50/60 transition-colors bg-white group"
                            x-show="(searchTerm === '' || '{{ $transfer->transfer_no }}'.toLowerCase().includes(searchTerm.toLowerCase()) || '{{ $transfer->product->product_name }}'.toLowerCase().includes(searchTerm.toLowerCase())) && (statusFilter === '' || '{{ $transfer->status }}' === statusFilter) && (storeFilter === '' || '{{ $transfer->from_store_id }}' === storeFilter || '{{ $transfer->to_store_id }}' === storeFilter)">
                            <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[12px] font-semibold text-primary-dark">{{ $transfer->transfer_no }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[12px] font-semibold text-primary-dark">{{ $transfer->product->product_name }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[12px] font-semibold text-primary-dark">{{ $transfer->fromStore->name }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[12px] font-semibold text-primary-dark">{{ $transfer->toStore->name }}</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-[12px] font-semibold text-primary-dark">{{ $transfer->quantity }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[12px] font-semibold text-primary-dark">{{ $transfer->requester->name }}</span>
                            </td>
                            <td class="px-5 py-4">
                                @if($transfer->approved_by && $transfer->approver)
                                    <span class="text-[12px] font-semibold text-primary-dark">{{ $transfer->approver->name }}</span>
                                @else
                                    <span class="text-[12px] font-semibold text-gray-400">Awaiting</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php $st = strtolower($transfer->status); @endphp
                                @if($st === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">Pending</span>
                                @elseif($st === 'completed' || $st === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-accent/10 text-primary border border-accent/20 uppercase tracking-wider">{{ ucfirst($transfer->status) }}</span>
                                @elseif($st === 'rejected')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">Rejected</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-gray-100 text-gray-400 border border-gray-200 uppercase tracking-wider">{{ ucfirst($transfer->status) }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    @php
                                        $currentUser = auth()->user();
                                        $userRole = strtolower(trim($currentUser->role ?? ''));
                                        $isManagement = in_array($userRole, ['admin', 'super admin', 'manager', 'branch manager', 'hub manager', 'store manager']);
                                        $isStorekeeper = $userRole === 'storekeeper';
                                        $userStoreId = $currentUser->getAssignedStoreId();
                                        $isRequester = auth()->id() === $transfer->requested_by;

                                        $canApprove = false;
                                        if ($transfer->status === 'pending' && !$isRequester) {
                                            if ($isManagement || ($isStorekeeper && ($userStoreId == $transfer->from_store_id || $userStoreId == $transfer->to_store_id))) {
                                                $canApprove = true;
                                            }
                                        }
                                    @endphp

                                    @if($canApprove)
                                        <button @click="performAction({{ $transfer->id }}, 'approve')" class="btn-action-view" title="Approve">
                                            <i class="bi bi-shield-check"></i>
                                        </button>
                                    @endif

                                    @if($transfer->status === 'pending' && ($isManagement || $isRequester || ($isStorekeeper && ($userStoreId == $transfer->from_store_id || $userStoreId == $transfer->to_store_id))))
                                        <button @click="performAction({{ $transfer->id }}, 'reject')" class="btn-action-delete" title="Reject">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    @endif

                                    <button type="button" @click="editTransfer({ id: {{ $transfer->id }}, transfer_no: '{{ $transfer->transfer_no }}', from_store_id: '{{ $transfer->from_store_id }}', to_store_id: '{{ $transfer->to_store_id }}', product_id: '{{ $transfer->product_id }}', quantity: {{ $transfer->quantity }}, remarks: '{{ addslashes($transfer->remarks ?? '') }}', status: '{{ $transfer->status }}' })" class="btn-action-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn-action-delete" @click="deleteTransfer({{ $transfer->id }})" title="Delete">
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

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest">
                Showing {{ count($transfers ?? []) > 0 ? 1 : 0 }} to {{ count($transfers ?? []) }} of {{ count($transfers ?? []) }} entries
            </p>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm" disabled>
                    <i class="bi bi-chevron-left text-xs"></i>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-black text-xs shadow-md shadow-primary/20">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm" disabled>
                    <i class="bi bi-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- TRANSFER MODAL -->
    <div x-show="openModal === 'new-transfer'" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">

        <div class="bg-white rounded-[1.25rem] w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative" @click.away="openModal = null">

            <!-- Modal Header -->
            <div class="px-6 py-6 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-4 text-white">
                        <div class="w-12 h-12 bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-xl shadow-inner backdrop-blur-md">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-xl font-bold tracking-tight">Initiate Transfer</h2>
                            <p class="text-xs text-white/60 font-medium mt-0.5">Fill in the required transfer details below</p>
                        </div>
                    </div>
                    <button @click="openModal = null" class="w-8 h-8 bg-white/10 border border-white/10 text-white rounded-lg hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6 overflow-y-auto custom-scrollbar flex-grow bg-white">
                <form @submit.prevent="submitProtocol" id="transferForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Source Store <span class="text-primary">*</span></label>
                            @php $userStoreId = auth()->user()->getAssignedStoreId(); @endphp
                            <div class="relative">
                                <select x-model="formData.from_store_id" name="from_store_id"
                                    class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none {{ $userStoreId ? 'opacity-70 cursor-not-allowed' : '' }}"
                                    {{ $userStoreId ? 'disabled' : '' }}>
                                    <option value="">Select source store...</option>
                                    @php $groupedStores = $stores->groupBy('branch.name'); @endphp
                                    @foreach($groupedStores as $branchName => $branchStores)
                                        <optgroup label="{{ $branchName }}">
                                            @foreach($branchStores as $st)
                                                <option value="{{ $st->id }}" {{ $userStoreId == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Destination Store <span class="text-primary">*</span></label>
                            <div class="relative">
                                <select x-model="formData.to_store_id" name="to_store_id" required
                                    class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none">
                                    <option value="">Select destination store...</option>
                                    @foreach($groupedStores as $branchName => $branchStores)
                                        <optgroup label="{{ $branchName }}">
                                            @foreach($branchStores as $st)
                                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Product <span class="text-primary">*</span></label>
                            <div class="relative">
                                <select x-model="formData.product_id" name="product_id" required
                                    class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none">
                                    <option value="">Select product...</option>
                                    @foreach($products as $prod)
                                        <option value="{{ $prod->id }}">{{ $prod->product_name }} ({{ $prod->product_code }})</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Unit Count <span class="text-primary">*</span></label>
                            <div class="relative">
                                <input type="number" x-model="formData.quantity" name="quantity" required placeholder="0"
                                    class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                                <i class="bi bi-hash absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Remarks</label>
                        <textarea x-model="formData.remarks" name="remarks" rows="3" placeholder="Transfer remarks..."
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
                <button type="button" @click="submitProtocol" 
                    class="px-6 py-2.5 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-all text-[13px] uppercase tracking-wide shadow-sm flex items-center justify-center gap-2 min-w-[150px]">
                    <i class="bi bi-check2-circle"></i>
                    <span>Submit Request</span>
                </button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function storeTransfer() {
    return {
        openModal: null,
        searchTerm: '',
        statusFilter: '',
        storeFilter: '',
        formData: {
            from_store_id: '{{ auth()->user()->getAssignedStoreId() ?? '' }}',
            to_store_id: '',
            product_id: '',
            quantity: '',
            remarks: '',
            type: '{{ $type ?? 'inter-store' }}'
        },
        async submitProtocol() {
            if(!this.formData.from_store_id || !this.formData.to_store_id || !this.formData.product_id || !this.formData.quantity) {
                 Swal.fire('Error', 'Please fill all required fields.', 'error');
                 return;
            }

            if(this.formData.from_store_id === this.formData.to_store_id) {
                Swal.fire('Error', 'Source and Destination stores must be different.', 'error');
                return;
            }

            try {
                const response = await fetch('{{ route('store-transfer.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.formData)
                });

                const result = await response.json();

                if(result.success) {
                    Swal.fire('Success', result.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', result.message || 'Something went wrong', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Network error or server down', 'error');
            }
        },
        async performAction(id, action) {
             const confirmText = action === 'approve' ? 'Approve this transfer?' : (action === 'reject' ? 'Reject this transfer?' : 'Complete this transfer?');

             const result = await Swal.fire({
                 title: 'Are you sure?',
                 text: confirmText,
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#004161',
                 cancelButtonColor: '#99CC33',
                 confirmButtonText: 'Yes, proceed!',
                 customClass: {
                    popup: 'rounded-[1.5rem]',
                    confirmButton: 'rounded-[0.5rem] px-6 py-2 text-xs font-bold uppercase tracking-widest',
                    cancelButton: 'rounded-[0.5rem] px-6 py-2 text-xs font-bold uppercase tracking-widest'
                 }
             });

             if (result.isConfirmed) {
                 try {
                     const response = await fetch(`/store-transfer/action/${id}`, {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                         },
                         body: JSON.stringify({ action })
                     });

                     const data = await response.json();
                     if(data.success) {
                         Swal.fire('Updated!', data.message, 'success').then(() => location.reload());
                     } else {
                         Swal.fire('Error', data.message, 'error');
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
                text: 'Transfer ' + transfer.transfer_no + ' has been loaded into the editor.',
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
                type: transfer.type || 'inter-store'
            };
            this.openModal = 'new-transfer';
        },
        deleteTransfer(id) {
            Swal.fire({
                title: 'Confirm Deletion',
                text: 'Are you sure you want to delete this transfer log? This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#004161',
                cancelButtonColor: '#99CC33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    popup: 'rounded-[1.5rem]',
                    confirmButton: 'rounded-[0.5rem] px-6 py-2 text-xs font-bold uppercase tracking-widest',
                    cancelButton: 'rounded-[0.5rem] px-6 py-2 text-xs font-bold uppercase tracking-widest'
                }
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
        }
    }
}
</script>
@endpush

@endsection
