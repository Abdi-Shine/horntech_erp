@extends('admin.admin_master')
@section('page_title', 'All Parties Report')



@section('admin')
<div class="report-premium-container"
     x-data="{
        searchTerm: '',
        partyType: 'All Parties',
        parties: [
            { id: 1, name: 'Ali Farh', email: '---', phone: '---', receivable: 0, payable: 400.00, limit: 0 },
            { id: 2, name: 'Cash Sale', email: '---', phone: '---', receivable: 0, payable: 0, limit: 0 },
            { id: 3, name: 'shilno', email: '---', phone: '97878', receivable: 0, payable: 100.00, limit: 0 },
            { id: 4, name: 'Mohammed Ali Trading', email: 'mohammed@alitrade.com', phone: '+966 50 123 4567', receivable: 12450.00, payable: 0, limit: 50000.00 },
            { id: 5, name: 'Fatima Ahmad Store', email: 'fatima.store@email.com', phone: '+966 50 234 5678', receivable: 8670.00, payable: 0, limit: 30000.00 },
            { id: 6, name: 'Modern Tech Suppliers', email: 'info@moderntech.sa', phone: '+966 50 345 6789', receivable: 0, payable: 15450.00, limit: 0 },
            { id: 7, name: 'Abdullah Electronics', email: 'abdullah@electronics.sa', phone: '+966 50 456 7890', receivable: 5340.00, payable: 0, limit: 20000.00 },
            { id: 8, name: 'Global Import LLC', email: 'sales@globalimport.com', phone: '+966 50 567 8901', receivable: 0, payable: 8900.00, limit: 0 }
        ],
        get filteredParties() {
            return this.parties.filter(p => {
                const matchesSearch = p.name.toLowerCase().includes(this.searchTerm.toLowerCase()) || 
                                     p.phone.includes(this.searchTerm);
                const matchesType = this.partyType === 'All Parties' || 
                                   (this.partyType === 'Customers Only' && p.receivable > 0) ||
                                   (this.partyType === 'Suppliers Only' && p.payable > 0);
                return matchesSearch && matchesType;
            });
        }
     }">
    
    <!-- Header Section -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">All Parties Report</h1>
            <p class="report-premium-subtitle">Comprehensive list of all customers and suppliers</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <button class="report-premium-btn-outline">
                <i class="bi bi-file-earmark-excel text-sm"></i> EXCEL
            </button>
            <a href="{{ route('reports.party_all.pdf') }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Parties</p>
                <h3 class="text-[18px] font-black text-primary">127</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Customers & Suppliers</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-people"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Receivable</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} 45,670</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">To collect</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-down-circle"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Payable</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} 28,450</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">To pay</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-arrow-up-circle"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Net Position</p>
                <h3 class="text-[18px] font-black text-primary">{{ $company->currency ?? 'SAR' }} 17,220</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Positive balance</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-up"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <span class="report-premium-filter-label">Search Party</span>
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" x-model="searchTerm" placeholder="Search by name or phone..." class="report-premium-filter-input !pl-9">
            </div>
        </div>
        <div class="report-premium-filter-group w-auto min-w-[180px]">
            <span class="report-premium-filter-label">Party Type</span>
            <select x-model="partyType" class="report-premium-filter-input">
                <option>All Parties</option>
                <option>Customers Only</option>
                <option>Suppliers Only</option>
                <option>Zero Balance</option>
            </select>
        </div>
        <button type="button" class="report-premium-btn-primary h-[38px] mt-auto">
            <i class="bi bi-funnel"></i> Apply
        </button>
    </form>

    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden mb-6">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Parties Master Ledger Index</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black uppercase tracking-widest text-[9px]">127 Total Entities</span>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="text-center w-12">#</th>
                        <th>Party Master Details</th>
                        <th>Contact / Integration</th>
                        <th class="text-right">Receivables</th>
                        <th class="text-right">Payables</th>
                        <th class="text-right">Credit Ceiling</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(party, index) in filteredParties" :key="party.id">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4 text-[11px] font-black text-gray-400 text-center" x-text="index + 1"></td>
                            <td class="px-5 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-primary-dark uppercase tracking-tight" x-text="party.name"></span>
                                    <template x-if="party.email && party.email !== '---'">
                                        <span class="text-[10px] text-gray-400 italic" x-text="party.email"></span>
                                    </template>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[11px] font-bold text-gray-500 font-mono tracking-tight" x-text="party.phone"></span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-[13px] font-black text-accent font-mono tracking-tighter" x-show="party.receivable > 0" x-text="'SAR ' + party.receivable.toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
                                <span class="text-[11px] text-gray-300 italic" x-show="party.receivable == 0">---</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-[13px] font-black text-primary font-mono tracking-tighter" x-show="party.payable > 0" x-text="'SAR ' + party.payable.toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
                                <span class="text-[11px] text-gray-300 italic" x-show="party.payable == 0">---</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-[13px] font-black text-primary font-mono tracking-tighter" x-show="party.limit > 0" x-text="'SAR ' + party.limit.toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
                                <span class="text-[11px] text-gray-300 italic" x-show="party.limit == 0">---</span>
                            </td>
                        </tr>
                    </template>
                </tbody>
                <tfoot class="bg-primary/5">
                    <tr class="font-black text-primary-dark border-t-2 border-primary/20">
                        <td colspan="3" class="px-5 py-5 text-center">
                            <span class="text-[11px] font-black uppercase tracking-[0.2em] italic text-primary-dark opacity-70">Aggregated Global Balances</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Net Recv.</span>
                            <span class="text-[14px] font-mono font-black text-accent italic leading-none">{{ $company->currency ?? 'SAR' }} 45,670.00</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Net Payb.</span>
                            <span class="text-[14px] font-mono font-black text-primary italic leading-none">{{ $company->currency ?? 'SAR' }} 28,450.00</span>
                        </td>
                        <td class="px-5 py-4 text-right bg-brand-bg/5">
                             <span class="text-[9px] text-gray-400 block font-black uppercase mb-0.5 leading-none">Equity Pos.</span>
                             <span class="text-[15px] font-mono font-black text-accent leading-none tracking-tighter">{{ $company->currency ?? 'SAR' }} 17,220.00</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection


