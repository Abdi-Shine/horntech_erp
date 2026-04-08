<?php

$content = <<<'EOD'
@extends('admin.admin_master')

@push('css')
<style>
    [x-cloak] { display: none !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 65, 97, 0.15); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0, 65, 97, 0.3); }
</style>
@endpush

@section('admin')
<div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen" x-data="expenseManagement()">
    
    <!-- Top Header Card -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <div>
            <h1 class="text-[22px] font-bold text-primary-dark">Expenses Management</h1>
        </div>
        <div class="flex items-center gap-3">
            <button @click="activeModal = 'import-modal'" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-primary-dark font-semibold rounded-[0.5rem] hover:bg-gray-50 transition-all shadow-sm text-sm">
                <i class="bi bi-download"></i>
                Import CSV
            </button>
            <button class="flex items-center gap-2 px-5 py-2.5 bg-accent text-primary font-semibold rounded-[0.5rem] hover:bg-accent transition-all shadow-sm text-sm">
                <i class="bi bi-file-earmark-excel"></i>
                Export
            </button>
            <button @click="openNewModal()" class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-semibold rounded-[0.5rem] hover:bg-primary/90 transition-all shadow-sm text-sm group">
                <i class="bi bi-plus-lg group-hover:rotate-180 transition-transform duration-300"></i>
                Add New Expense
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Expenses -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between border-l-4 border-l-primary">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Expenses</p>
                <h3 class="text-2xl font-black text-primary">{{ $curr }} {{ number_format($expenses->sum('amount'), 2) }}</h3>
                <p class="text-[11px] text-gray-400 mt-1.5 font-medium">This Month</p>
            </div>
            <div class="w-11 h-11 bg-slate-200 rounded-[0.6rem] flex items-center justify-center text-primary-dark">
                <i class="bi bi-wallet2 text-lg"></i>
            </div>
        </div>
        
        <!-- Pending Approvals -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Pending Approvals</p>
                <h3 class="text-2xl font-black text-yellow-500">{{ $expenses->where('status', 'Pending')->count() }}</h3>
                <p class="text-[11px] text-gray-400 mt-1.5 font-medium">Awaiting Review</p>
            </div>
            <div class="w-11 h-11 bg-yellow-100 rounded-[0.6rem] flex items-center justify-center text-yellow-500">
                <i class="bi bi-hourglass-split text-lg"></i>
            </div>
        </div>
        
        <!-- Approved Expenses -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Approved Expenses</p>
                <h3 class="text-2xl font-black text-success">{{ $curr }} {{ number_format($expenses->where('status', '!=', 'Pending')->sum('amount'), 2) }}</h3>
                <p class="text-[11px] text-success mt-1.5 flex items-center gap-1 font-medium"><i class="bi bi-check-circle text-[10px]"></i> Cleared Amount</p>
            </div>
            <div class="w-11 h-11 bg-green-100 rounded-[0.6rem] flex items-center justify-center text-success">
                <i class="bi bi-check-circle text-lg"></i>
            </div>
        </div>
        
        <!-- Average Daily -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Average Daily</p>
                <h3 class="text-2xl font-black text-sky-500">{{ $curr }} {{ number_format(count($expenses) > 0 ? $expenses->sum('amount') / max(date('d'), 1) : 0, 2) }}</h3>
                <p class="text-[11px] text-gray-400 mt-1.5 font-medium">Daily average this month</p>
            </div>
            <div class="w-11 h-11 bg-sky-100 rounded-[0.6rem] flex items-center justify-center text-sky-500">
                <i class="bi bi-graph-up text-lg"></i>
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
                <input type="text" x-model="searchQuery" placeholder="Search expenses..." 
                    class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400">
            </div>
            
            <!-- All Status -->
            <div class="relative min-w-[150px]">
                <select x-model="statusFilter" class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
                <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
            </div>
            
            <!-- Filter Button -->
            <div class="min-w-[120px]">
                <button class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-white border border-primary-dark text-primary-dark font-medium rounded-[0.5rem] hover:bg-gray-50 transition-colors text-[13px] shadow-sm">
                    <i class="bi bi-funnel"></i>
                    Filters
                </button>
            </div>
        </div>

        <!-- Table Title -->
        <div class="px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50">
            <i class="bi bi-list-ul text-primary-dark text-sm"></i>
            <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">Expense List</h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="px-5 py-4 text-[10px] font-black text-primary-dark uppercase tracking-wider w-16 text-center">#</th>
                        <th class="px-5 py-4 text-[10px] font-black text-primary-dark uppercase tracking-wider">Date</th>
                        <th class="px-5 py-4 text-[10px] font-black text-primary-dark uppercase tracking-wider">Expense No.</th>
                        <th class="px-5 py-4 text-[10px] font-black text-primary-dark uppercase tracking-wider text-center">Category</th>
                        <th class="px-5 py-4 text-[10px] font-black text-primary-dark uppercase tracking-wider text-center">Amount</th>
                        <th class="px-5 py-4 text-[10px] font-black text-primary-dark uppercase tracking-wider text-center">Status</th>
                        <th class="px-5 py-4 text-[10px] font-black text-primary-dark uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($expenses as $expense)
                    <tr class="hover:bg-gray-50/60 transition-colors bg-white group"
                        x-show="(statusFilter === '' || statusFilter === '{{ $expense->status ?? 'Approved' }}') && (searchQuery === '' || '{{ strtolower($expense->expense_name) }}'.includes(searchQuery.toLowerCase()))">
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-400 text-center">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-bold text-gray-700">{{ $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') : 'N/A' }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-bold text-primary-dark">EXP-{{ $expense->created_at->format('Y') }}-{{ str_pad($expense->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[10px] text-gray-400 font-medium truncate max-w-[150px]">{{ $expense->expense_name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-[0.35rem] text-[9px] font-bold uppercase tracking-widest shadow-sm">{{ $expense->account->name ?? 'Other' }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-xs font-black text-primary-dark">{{ $curr }} {{ number_format($expense->amount, 2) }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @php
                                $statusName = $expense->status ?? 'Approved';
                                $statusStyle = match($statusName) {
                                    'Approved', 'Paid' => 'bg-emerald-500 text-white',
                                    'Rejected' => 'bg-rose-500 text-white',
                                    default => 'bg-amber-500 text-white'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-[0.35rem] text-[9px] font-bold uppercase tracking-widest shadow-sm {{ $statusStyle }}">
                                {{ $statusName }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <button @click="editExpense({{ json_encode($expense) }})" class="w-7 h-7 rounded-md bg-gray-50 border border-gray-200 text-gray-400 hover:text-blue-500 hover:border-blue-500 hover:bg-white transition-all flex items-center justify-center text-xs shadow-sm">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="w-7 h-7 rounded-md bg-gray-50 border border-gray-200 text-gray-400 hover:text-rose-500 hover:border-rose-500 hover:bg-white transition-all flex items-center justify-center text-xs shadow-sm">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center text-gray-400">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <i class="bi bi-inbox text-2xl"></i>
                            </div>
                            <p class="text-[13px] font-bold uppercase tracking-widest text-gray-400">No expenses found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($expenses->count() > 0)
        <!-- Pagination -->
        <div class="px-5 py-4 border-t border-gray-100 bg-white flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                Showing 1 to {{ $expenses->count() }} of {{ $expenses->count() }} entries
            </div>
            <div class="flex items-center gap-1">
                <button class="w-7 h-7 flex items-center justify-center rounded bg-gray-50 text-gray-400 hover:bg-gray-100 transition-colors border border-gray-200"><i class="bi bi-chevron-left text-[10px]"></i></button>
                <button class="w-7 h-7 flex items-center justify-center rounded bg-primary-dark text-white font-bold text-[11px] shadow-sm">1</button>
                <button class="w-7 h-7 flex items-center justify-center rounded bg-gray-50 text-gray-400 hover:bg-gray-100 transition-colors border border-gray-200"><i class="bi bi-chevron-right text-[10px]"></i></button>
            </div>
        </div>
        @endif
    </div>

    <!-- EXPENSE MODAL (Add/Edit) -->
    <div x-show="activeModal === 'expense-modal'" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        
        <div class="bg-white rounded-[1.25rem] w-full max-w-3xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative" @click.away="activeModal = null">
            
            <!-- Modal Header (Dark Blue Premium Style) -->
            <div class="px-5 py-4 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-white/10 border border-white/10 rounded-lg flex items-center justify-center text-white text-base shadow-inner backdrop-blur-md">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-base font-bold text-white tracking-tight" x-text="editMode ? 'Edit Expense' : 'Add New Expense'"></h2>
                            <p class="text-[9px] text-blue-100/70 font-medium mt-0.5">Fill in the required details below</p>
                        </div>
                    </div>
                    
                    <button @click="activeModal = null" 
                        class="w-8 h-8 bg-white/10 border border-white/10 text-white rounded-lg hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Content (Wrapped in Form) -->
            <form :action="editMode ? '/expenses/' + expenseData.id : '{{ route('expenses.store') }}'" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="px-5 py-5 flex-1 overflow-y-auto custom-scrollbar bg-white">
                    <div class="space-y-5">
                        
                        <!-- Row 1: Triple columns grid-3 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Expense Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="expense_name" x-model="expenseData.expense_name" required placeholder="e.g. Shipping Fee" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Linked Bill</label>
                                <div class="relative">
                                    <select name="reference_no" x-model="expenseData.reference_no" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all cursor-pointer appearance-none">
                                        <option value="">-- SELECT BILL --</option>
                                    </select>
                                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[10px]"></i>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Category <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <select required name="expense_account_id" x-model="expenseData.expense_account_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all cursor-pointer appearance-none">
                                        <option value="">-- SELECT CATEGORY --</option>
                                        @foreach ($expenseAccounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[10px]"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Triple columns grid-3 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Amount Paid <span class="text-rose-500">*</span></label>
                                <input type="number" step="0.01" name="amount" x-model="expenseData.amount" required placeholder="0.00" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Date <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="date" name="expense_date" x-model="expenseData.expense_date" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Supplier</label>
                                <div class="relative">
                                    <select name="supplier_id" x-model="expenseData.supplier_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all cursor-pointer appearance-none">
                                        <option value="">-- SELECT SUPPLIER --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->company_name ?? $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[10px]"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Row 3: Triple columns grid-3 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Branch <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <select required name="branch_id" x-model="expenseData.branch_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all cursor-pointer appearance-none">
                                        <option value="">-- SELECT BRANCH --</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[10px]"></i>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Bank Account <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <select required name="bank_account_id" x-model="expenseData.bank_account_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all cursor-pointer appearance-none">
                                        <option value="">-- SELECT BANK ACCOUNT --</option>
                                        @foreach ($bankAccounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[10px]"></i>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Description & Notes</label>
                                <input type="text" name="description" x-model="expenseData.description" placeholder="Details..." class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[12px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                            </div>
                        </div>

                        <!-- Attachment -->
                        <div class="space-y-1 pt-2">
                             <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Attachment</label>
                             <input type="file" name="receipt" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-primary/5 file:text-primary hover:file:bg-primary/10 cursor-pointer">
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between shrink-0">
                    <button type="button" @click="activeModal = null" 
                        class="text-xs font-bold text-gray-500 hover:text-gray-700 transition-all uppercase tracking-wider">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-8 py-2.5 bg-primary-dark text-white font-bold rounded-lg hover:bg-black transition-all text-xs shadow-sm uppercase tracking-wider">
                        <span x-text="editMode ? 'Update Expense' : 'Save Expense'"></span>
                    </button>
                </div>
            </form>
            
        </div>
    </div>

    <!-- IMPORT MODAL -->
    <div x-show="activeModal === 'import-modal'" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        
        <div class="bg-white rounded-[1.25rem] w-full max-w-md max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative" @click.away="activeModal = null">
            
            <div class="px-6 py-6 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-white text-xl shadow-inner backdrop-blur-md">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-xl font-bold text-white tracking-tight">Import Expenses</h2>
                            <p class="text-xs text-blue-100/70 font-medium mt-0.5">Upload your CSV or Excel file</p>
                        </div>
                    </div>
                    <button @click="activeModal = null" class="text-white/50 hover:text-white transition-colors"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>

            <div class="p-6">
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-primary transition-colors cursor-pointer group">
                        <i class="bi bi-file-earmark-arrow-up text-3xl text-gray-300 group-hover:text-primary transition-colors mb-3 block"></i>
                        <p class="text-sm font-bold text-gray-700">Click to upload or drag & drop</p>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider font-bold">CSV, XLSX supported</p>
                        <input type="file" class="hidden">
                    </div>
                    <button type="submit" class="w-full py-3 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark transition-all text-sm shadow-sm uppercase tracking-wider">Start Import</button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function expenseManagement() {
    return {
        activeModal: null,
        editMode: false,
        searchQuery: '',
        statusFilter: '',
        expenseData: {
            id: null,
            expense_name: '',
            expense_date: '{{ date('Y-m-d') }}',
            amount: '',
            expense_account_id: '',
            bank_account_id: '',
            branch_id: '',
            supplier_id: '',
            reference_no: '',
            description: ''
        },
        openNewModal() {
            this.editMode = false;
            this.expenseData = {
                id: null,
                expense_name: '',
                expense_date: '{{ date('Y-m-d') }}',
                amount: '',
                expense_account_id: '',
                bank_account_id: '',
                branch_id: '',
                supplier_id: '',
                reference_no: '',
                description: ''
            };
            this.activeModal = 'expense-modal';
        },
        editExpense(expense) {
            this.editMode = true;
            this.expenseData = {
                id: expense.id,
                expense_name: expense.expense_name,
                expense_date: expense.expense_date,
                amount: expense.amount,
                expense_account_id: expense.expense_account_id,
                bank_account_id: expense.bank_account_id,
                branch_id: expense.branch_id,
                supplier_id: expense.supplier_id,
                reference_no: expense.reference_no,
                description: expense.description
            };
            this.activeModal = 'expense-modal';
        }
    }
}
</script>
@endsection
EOD;

file_put_contents('d:/Bilkheyr/resources/views/frontend/expense/add_all_expenses.blade.php', $content);
