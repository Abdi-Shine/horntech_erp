@extends('admin.admin_master')
@section('page_title', 'Sale/Purchase by Party Group')



@section('admin')
<div class="report-premium-container"
     x-data="{
        searchTerm: '',
        groupType: 'All Groups',
        groups: [
            { id: 1, name: 'Main Distributors', sales: 156450.00, purchases: 45000.00 },
            { id: 2, name: 'Retail Partners', sales: 89000.00, purchases: 12000.00 },
            { id: 3, name: 'Wholesale Clients', sales: 245000.00, purchases: 180000.00 },
            { id: 4, name: 'Direct Customers', sales: 12400.00, purchases: 0 },
            { id: 5, name: 'International Suppliers', sales: 0, purchases: 320000.00 },
            { id: 6, name: 'Local Manufacturers', sales: 5000.00, purchases: 95000.00 }
        ],
        get filteredGroups() {
            return this.groups.filter(g => {
                const matchesSearch = g.name.toLowerCase().includes(this.searchTerm.toLowerCase());
                const matchesType = this.groupType === 'All Groups' || 
                                   (this.groupType === 'With Sales' && g.sales > 0) ||
                                   (this.groupType === 'With Purchases' && g.purchases > 0);
                return matchesSearch && matchesType;
            });
        },
        getTotalSales() {
            return this.filteredGroups.reduce((sum, g) => sum + g.sales, 0);
        },
        getTotalPurchases() {
            return this.filteredGroups.reduce((sum, g) => sum + g.purchases, 0);
        }
     }">
    
    <!-- Header Section -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Sale Purchase by Party Group</h1>
            <p class="report-premium-subtitle">Aggregated analysis of transactions grouped by party category</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <button class="report-premium-btn-outline">
                <i class="bi bi-file-earmark-excel text-sm"></i> EXCEL
            </button>
            <a href="{{ route('reports.sales_purchase_by_party_group.pdf') }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
        <!-- Total Group Sales -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Group Sales</p>
                <h3 class="text-[18px] font-black text-primary" x-text="'{{ $company->currency ?? 'SAR' }} ' + getTotalSales().toLocaleString()"></h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Cumulative Revenue</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-briefcase text-lg"></i>
            </div>
        </div>

        <!-- Total Group Purchases -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Group Purchases</p>
                <h3 class="text-[18px] font-black text-primary" x-text="'{{ $company->currency ?? 'SAR' }} ' + getTotalPurchases().toLocaleString()"></h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Cumulative Cost</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-cart-x text-lg"></i>
            </div>
        </div>

        <!-- Group Profitability -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Net Flow</p>
                <h3 class="text-[18px] font-black text-primary" :class="(getTotalSales() - getTotalPurchases()) >= 0 ? 'text-primary' : 'text-primary'"
                    x-text="'{{ $company->currency ?? 'SAR' }} ' + (getTotalSales() - getTotalPurchases()).toLocaleString()"></h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1" :class="(getTotalSales() - getTotalPurchases()) >= 0 ? 'text-primary' : 'text-primary'"
                   x-text="(getTotalSales() >= getTotalPurchases() ? 'Group Net Surplus' : 'Deficit')"></p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-layers text-lg"></i>
            </div>
        </div>

        <!-- Total Groups -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Active Groups</p>
                <h3 class="text-[18px] font-black text-primary" x-text="filteredGroups.length"></h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Defined Categories</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-tag text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group flex-1 min-w-[250px]">
            <span class="report-premium-filter-label">Search Group</span>
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" x-model="searchTerm" placeholder="Search group name..." class="report-premium-filter-input !pl-9">
            </div>
        </div>

        <div class="report-premium-filter-group w-auto min-w-[180px]">
            <span class="report-premium-filter-label">Type Filter</span>
            <select x-model="groupType" class="report-premium-filter-input">
                <option>All Groups</option>
                <option>With Sales</option>
                <option>With Purchases</option>
            </select>
        </div>
        
        <button type="button" class="report-premium-btn-primary h-[38px] mt-auto">
            <i class="bi bi-funnel"></i> Generate
        </button>
    </div>

    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden mb-6">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Group Performance List</h4>
            </div>
            <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black uppercase tracking-widest text-[9px]" x-text="filteredGroups.length + ' Categories Listed'"></span>
        </div>

        <!-- Table Display -->
        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="w-16 text-center">#</th>
                        <th>Group Name</th>
                        <th class="text-right">Aggregated Sales</th>
                        <th class="text-right">Aggregated Purchases</th>
                        <th class="text-right">Net Position</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(group, index) in filteredGroups" :key="group.id">
                        <tr class="hover:bg-gray-50/60 transition-colors bg-white">
                            <td class="px-5 py-4 text-[11px] font-black text-gray-400 text-center" x-text="index + 1"></td>
                            <td class="px-5 py-4">
                                <span class="text-xs font-black text-primary-dark block" x-text="group.name"></span>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Business Vertical</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-xs font-black text-accent font-mono" x-show="group.sales > 0" x-text="'$ ' + group.sales.toLocaleString()"></span>
                                <span class="text-[11px] text-gray-300" x-show="group.sales == 0">---</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-xs font-black text-primary font-mono" x-show="group.purchases > 0" x-text="'$ ' + group.purchases.toLocaleString()"></span>
                                <span class="text-[11px] text-gray-300" x-show="group.purchases == 0">---</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-xs font-black font-mono" :class="(group.sales - group.purchases) >= 0 ? 'text-accent' : 'text-primary'"
                                      x-text="'$ ' + (group.sales - group.purchases).toLocaleString()"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
                <tfoot>
                    <tr class="bg-[#e8f5e9]/50 border-t-2 border-primary/20">
                        <td colspan="2" class="px-5 py-5 text-center">
                            <span class="text-[10px] font-black text-primary-dark uppercase tracking-widest">Grand Totals</span>
                        </td>
                        <td class="px-5 py-5 text-right">
                            <span class="text-[9px] text-gray-500 block font-bold uppercase mb-0.5">Total Sales</span>
                            <span class="text-xs font-black text-accent font-mono" x-text="'{{ $company->currency ?? 'SAR' }} ' + getTotalSales().toLocaleString()"></span>
                        </td>
                        <td class="px-5 py-5 text-right">
                            <span class="text-[9px] text-gray-500 block font-bold uppercase mb-0.5">Total Purchases</span>
                            <span class="text-xs font-black text-primary font-mono" x-text="'{{ $company->currency ?? 'SAR' }} ' + getTotalPurchases().toLocaleString()"></span>
                        </td>
                        <td class="px-5 py-5 text-right">
                             <span class="text-[9px] text-gray-500 block font-bold uppercase mb-0.5">Final Net Surplus</span>
                             <span class="text-xs font-black font-mono" :class="(getTotalSales() - getTotalPurchases()) >= 0 ? 'text-accent' : 'text-primary'"
                                   x-text="'{{ $company->currency ?? 'SAR' }} ' + (getTotalSales() - getTotalPurchases()).toLocaleString()"></span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection


