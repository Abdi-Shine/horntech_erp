@extends('admin.admin_master')
@section('page_title', 'Branch Cash Management')



@section('admin')

<div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen" x-data="{ 
    searchTerm: '',
    statusFilter: '',
    activeTab: 'summary',
    transferModal: false,
    addFundsModal: false
}">
    
    <!-- Header Section -->
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <div>
            <h1 class="text-[20px] font-bold text-primary-dark">Branch Cash Management</h1>
        </div>
        <div class="flex items-center gap-3">
            <button @click="transferModal = true"
                class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-primary-dark font-semibold rounded-[0.5rem] hover:bg-gray-50 transition-all shadow-sm text-sm">
                <i class="bi bi-arrow-left-right"></i>
                Cash Transfer
            </button>
            <button @click="addFundsModal = true"
                class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-semibold rounded-[0.5rem] hover:bg-primary/90 transition-all shadow-sm text-sm group">
                <i class="bi bi-plus-lg group-hover:rotate-180 transition-transform duration-300"></i>
                Add Funds
            </button>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-6 border-b border-gray-200 mb-8 overflow-x-auto custom-scrollbar">
        <button @click="activeTab = 'summary'" :class="activeTab === 'summary' ? 'border-accent/20 text-accent' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 px-1 border-b-2 font-bold text-sm transition-colors whitespace-nowrap">
            <i class="bi bi-grid-1x2 mr-1.5"></i> Liquidity Summary
        </button>
        <button @click="activeTab = 'registers'" :class="activeTab === 'registers' ? 'border-accent/20 text-accent' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 px-1 border-b-2 font-bold text-sm transition-colors whitespace-nowrap">
            <i class="bi bi-shop mr-1.5"></i> Branch Registers
        </button>
        <button @click="activeTab = 'petty_cash'" :class="activeTab === 'petty_cash' ? 'border-accent/20 text-accent' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 px-1 border-b-2 font-bold text-sm transition-colors whitespace-nowrap">
            <i class="bi bi-wallet2 mr-1.5"></i> Petty Cash
        </button>
        <button @click="activeTab = 'transactions'" :class="activeTab === 'transactions' ? 'border-accent/20 text-accent' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 px-1 border-b-2 font-bold text-sm transition-colors whitespace-nowrap">
            <i class="bi bi-arrow-down-up mr-1.5"></i> Transfer History
        </button>
    </div>

    <div x-show="activeTab === 'summary'" x-transition.opacity.duration.300ms>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Liquidity -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Total Liquidity</p>
                    <h3 class="text-[18px] font-black text-primary">$245,850.00</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1"><i
                            class="bi bi-arrow-up text-[10px]"></i> 12.5% increase</p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary shadow-sm">
                    <i class="bi bi-cash-stack text-lg"></i>
                </div>
            </div>

            <!-- Cash at Banks -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Cash at Banks</p>
                    <h3 class="text-[18px] font-black text-primary">$182,400.00</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5">74% of total funds</p>
                </div>
                <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent shadow-sm">
                    <i class="bi bi-bank2 text-lg"></i>
                </div>
            </div>

            <!-- Branch Cash Reserves -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Cash In-Hand</p>
                    <h3 class="text-[18px] font-black text-primary">$58,250.00</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5">Across 12 branches</p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary shadow-sm">
                    <i class="bi bi-safe text-lg"></i>
                </div>
            </div>

            <!-- Pending Deposits -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Pending Deposits</p>
                    <h3 class="text-[18px] font-black text-primary">$5,200.00</h3>
                    <p class="text-xs font-bold text-primary mt-1.5">8 transfers processing</p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary shadow-sm">
                    <i class="bi bi-clock-history text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Layout for Charts/Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            
            <!-- Main Branch Liquidity Table -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-primary-dark">Branch Balances Overview</h2>
                        <p class="text-[11px] text-gray-400 font-medium">Real-time cash and bank positioning</p>
                    </div>
                    <button class="text-[11px] font-bold text-accent bg-accent/10 px-3 py-1.5 rounded-lg hover:bg-accent/10 transition-colors">
                        View All
                    </button>
                </div>
                
                <div class="p-5">
                    <div class="flex gap-3 mb-4">
                        <div class="relative flex-1">
                            <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" x-model="searchTerm" placeholder="Search branch..." 
                                class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium focus:ring-2 focus:ring-accent/20 focus:border-accent/20 outline-none">
                        </div>
                        <select class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-600 outline-none">
                            <option value="">All Regions</option>
                            <option value="north">North Region</option>
                            <option value="south">South Region</option>
                        </select>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr>
                                    <th class="pb-3 text-[10px] font-black text-gray-400 uppercase tracking-widest pl-2">Branch Name</th>
                                    <th class="pb-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Cash In Hand</th>
                                    <th class="pb-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Bank Balance</th>
                                    <th class="pb-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right pr-2">Total Liquidity</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-4 pl-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg bg-accent/10 flex items-center justify-center text-accent font-black text-xs">HQ</div>
                                            <div>
                                                <p class="text-[13px] font-bold text-primary-dark">Main Headquarters</p>
                                                <p class="text-[10px] font-semibold text-gray-400">Riyadh Dist.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-right">
                                        <p class="text-[13px] font-bold text-gray-700">$25,000.00</p>
                                    </td>
                                    <td class="py-4 text-right">
                                        <p class="text-[13px] font-bold text-primary">$120,000.00</p>
                                    </td>
                                    <td class="py-4 text-right pr-2">
                                        <p class="text-sm font-black text-primary-dark">$145,000.00</p>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-4 pl-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-black text-xs">J1</div>
                                            <div>
                                                <p class="text-[13px] font-bold text-primary-dark">Jeddah Main Branch</p>
                                                <p class="text-[10px] font-semibold text-gray-400">Al Balad</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-right">
                                        <p class="text-[13px] font-bold text-gray-700">$12,450.00</p>
                                        <p class="text-[9px] font-bold text-primary uppercase">Needs funding</p>
                                    </td>
                                    <td class="py-4 text-right">
                                        <p class="text-[13px] font-bold text-primary">$45,200.00</p>
                                    </td>
                                    <td class="py-4 text-right pr-2">
                                        <p class="text-sm font-black text-primary-dark">$57,650.00</p>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-4 pl-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-black text-xs">D1</div>
                                            <div>
                                                <p class="text-[13px] font-bold text-primary-dark">Dammam Store</p>
                                                <p class="text-[10px] font-semibold text-gray-400">Corniche</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-right">
                                        <p class="text-[13px] font-bold text-gray-700">$20,800.00</p>
                                    </td>
                                    <td class="py-4 text-right">
                                        <p class="text-[13px] font-bold text-primary">$17,200.00</p>
                                    </td>
                                    <td class="py-4 text-right pr-2">
                                        <p class="text-sm font-black text-primary-dark">$38,000.00</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Transfer Activity -->
            <div class="col-span-1 bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden flex flex-col">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-base font-bold text-primary-dark">Recent Transfers</h2>
                    <i class="bi bi-clock-history text-gray-400"></i>
                </div>
                
                <div class="p-5 flex-1 flex flex-col gap-4 overflow-y-auto custom-scrollbar">
                    
                    <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-accent/10 flex items-center justify-center text-accent shrink-0">
                            <i class="bi bi-box-arrow-in-down-left text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <p class="text-[13px] font-bold text-primary-dark">Bank Deposit</p>
                                <span class="text-[13px] font-black text-accent">+$5,000.00</span>
                            </div>
                            <p class="text-[11px] text-gray-500 font-medium mt-0.5">From: Jeddah Main Branch</p>
                            <p class="text-[10px] text-gray-400 mt-1">Today, 10:45 AM</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <i class="bi bi-arrow-left-right text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <p class="text-[13px] font-bold text-primary-dark">Inter-Branch Transfer</p>
                                <span class="text-[13px] font-black text-gray-700">$2,500.00</span>
                            </div>
                            <p class="text-[11px] text-gray-500 font-medium mt-0.5">HQ to Dammam Store</p>
                            <p class="text-[10px] text-gray-400 mt-1">Yesterday, 03:20 PM</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <i class="bi bi-cash text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <p class="text-[13px] font-bold text-primary-dark">Petty Cash Refill</p>
                                <span class="text-[13px] font-black text-primary">-$1,000.00</span>
                            </div>
                            <p class="text-[11px] text-gray-500 font-medium mt-0.5">HQ Main Account</p>
                            <p class="text-[10px] text-gray-400 mt-1">Mon, 09:15 AM</p>
                        </div>
                    </div>

                </div>
                
                <div class="p-4 border-t border-gray-100 bg-gray-50 text-center">
                    <button class="text-[12px] font-bold text-primary-dark hover:text-accent transition-colors">
                        View All History <i class="bi bi-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modals Placeholders -->
    <!-- Transfer Modal -->
    <div x-show="transferModal" x-cloak
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
        @click.self="transferModal = false">
        <div class="bg-white rounded-[1.25rem] w-full max-w-lg max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative">
            <!-- Modal Header -->
            <div class="px-6 py-6 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-white text-xl shadow-inner backdrop-blur-md">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-xl font-bold text-white tracking-tight">Cash Transfer</h2>
                            <p class="text-xs text-primary font-medium mt-0.5">Fill in the transfer details below
                            </p>
                        </div>
                    </div>

                    <button @click="transferModal = false"
                        class="w-8 h-8 bg-white/10 border border-white/10 text-white rounded-lg hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-xs"></i>
                    </button>
                </div>
            </div>

            <div class="px-6 py-6 overflow-y-auto custom-scrollbar flex-grow bg-white">
                <div class="space-y-6">
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">From Account / Branch</label>
                        <select
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option>HQ - Cash In Hand ($25,000.00)</option>
                            <option>HQ - SNB Bank ($120,000.00)</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">To Account / Branch</label>
                        <select
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option>Jeddah Main - Cash In Hand ($12,450.00)</option>
                            <option>Dammam Store - Petty Cash ($800.00)</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Amount</label>
                        <div class="relative group">
                            <input type="number" step="0.01" min="0" placeholder="0.00"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all pr-10">
                            <i class="bi bi-currency-dollar absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Remarks</label>
                        <input type="text" placeholder="Reason for transfer..."
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/80 flex items-center justify-between">
                <button type="button" @click="transferModal = false"
                    class="px-5 py-2.5 bg-primary text-white font-semibold rounded-lg hover:bg-primary/95 transition-all text-[13px] shadow-sm">
                    Cancel
                </button>
                <button type="submit"
                    class="flex items-center gap-2 px-6 py-2.5 bg-accent text-primary font-bold rounded-lg hover:bg-accent/90 transition-all text-[13px] shadow-sm">
                    <i class="bi bi-check2-circle text-base"></i>
                    <span>Confirm Transfer</span>
                </button>
            </div>
        </div>
    </div>

</div>

@endsection


