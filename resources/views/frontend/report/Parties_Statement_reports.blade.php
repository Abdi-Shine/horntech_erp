@extends('admin.admin_master')
@section('page_title', 'Parties Statement')



@section('admin')
<div class="report-premium-container"
     x-data="{
        searchTerm: '',
        partyFilter: '',
        pdfModal: false
     }">
    
    <!-- Page Header -->
    <div class="report-premium-header no-print">
        <div>
            <h1 class="report-premium-title">Party Statement</h1>
            <p class="report-premium-subtitle">Detailed transaction ledger for customers and suppliers</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="report-premium-btn-outline">
                <i class="bi bi-printer text-sm"></i> PRINT
            </button>
            <button class="report-premium-btn-outline">
                <i class="bi bi-file-earmark-excel text-sm"></i> EXCEL
            </button>
            <a href="{{ route('reports.party_statement.pdf') }}" class="report-premium-btn-primary">
                <i class="bi bi-file-earmark-pdf text-sm"></i> EXPORT PDF
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="report-premium-stat-grid">
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
                <p class="text-[12px] text-gray-400 font-medium mb-1">Total Transactions</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format(156) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">This period</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-receipt"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Active Parties</p>
                <h3 class="text-[18px] font-black text-primary">87</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Customers & Suppliers</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-people"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form class="report-premium-filter-bar no-print">
        <div class="report-premium-filter-group flex-1 min-w-[200px]">
            <span class="report-premium-filter-label">Search Activity</span>
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" x-model="searchTerm" placeholder="Search description or ID..." class="report-premium-filter-input !pl-9">
            </div>
        </div>
        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">From Date</span>
            <input type="date" value="2026-01-01" class="report-premium-filter-input">
        </div>
        <div class="report-premium-filter-group w-auto min-w-[150px]">
            <span class="report-premium-filter-label">To Date</span>
            <input type="date" value="2026-03-08" class="report-premium-filter-input">
        </div>
        <div class="report-premium-filter-group w-auto min-w-[180px]">
            <span class="report-premium-filter-label">Select Party</span>
            <select x-model="partyFilter" class="report-premium-filter-input">
                <option value="">All Parties</option>
                <option>Mohammed Ali Trading</option>
                <option>Fatima Ahmad Store</option>
                <option>Abdullah Electronics</option>
            </select>
        </div>
        <button type="button" class="report-premium-btn-primary h-[38px] mt-auto">
            <i class="bi bi-funnel"></i> Generate
        </button>
    </form>

    <!-- Table Section -->
    <div class="report-premium-card overflow-hidden mb-6">
        <!-- Table Title Bar -->
        <div class="px-5 py-4 border-b border-brand-border bg-brand-bg/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="bi bi-list-ul text-primary text-sm"></i>
                <h4 class="text-[11px] font-black text-text-secondary uppercase tracking-widest">Statement Ledger: Mohammed Ali Trading</h4>
            </div>
            <div class="flex items-center gap-3">
                <span class="report-premium-badge report-premium-badge-info !rounded-full italic font-black uppercase tracking-widest text-[9px]">ACTIVE LEDGER</span>
                <span class="report-premium-badge report-premium-badge-warning !rounded-full font-black uppercase tracking-widest text-[9px]">DEBIT BAL: {{ $company->currency ?? 'SAR' }} 12,450.00</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="report-premium-table">
                <thead>
                    <tr>
                        <th class="text-center w-12">#</th>
                        <th>Date</th>
                        <th>Activity/Description</th>
                        <th>Reference</th>
                        <th class="text-right">Debit (In)</th>
                        <th class="text-right">Credit (Out)</th>
                        <th class="text-right">Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-[11px] font-black text-gray-400 text-center">01</td>
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-500">01-Jan-2026</td>
                        <td class="px-5 py-4 text-xs font-black text-primary-dark">Opening Balance</td>
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-400 italic">---</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-primary font-mono">---</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-accent font-mono">{{ $company->currency ?? 'SAR' }} 5,000.00</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-primary font-mono tracking-tighter">{{ $company->currency ?? 'SAR' }} 5,000.00 <span class="text-[9px] opacity-70">CR</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-[11px] font-black text-gray-400 text-center">02</td>
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-500">05-Jan-2026</td>
                        <td class="px-5 py-4 text-xs font-black text-primary-dark">Sales Invoice #INV-2026-001</td>
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-400 italic leading-none opacity-80">12345</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-primary font-mono">{{ $company->currency ?? 'SAR' }} 12,450.00</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-accent font-mono">---</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-primary font-mono tracking-tighter">{{ $company->currency ?? 'SAR' }} 7,450.00 <span class="text-[9px] opacity-70">DR</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-[11px] font-black text-gray-400 text-center">03</td>
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-500">10-Jan-2026</td>
                        <td class="px-5 py-4 text-xs font-black text-primary-dark">Payment Received (Bank Transfer)</td>
                        <td class="px-5 py-4 text-[11px] font-bold text-gray-400 italic leading-none opacity-80">RCV-9988</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-primary font-mono">---</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-accent font-mono">{{ $company->currency ?? 'SAR' }} 7,450.00</td>
                        <td class="px-5 py-4 text-right text-[13px] font-black text-accent font-mono tracking-tighter">{{ $company->currency ?? 'SAR' }} 0.00</td>
                    </tr>
                </tbody>
                <tfoot class="bg-primary/5">
                    <tr class="font-black text-primary-dark border-t-2 border-primary/20">
                        <td colspan="4" class="px-5 py-5 text-center">
                            <span class="text-[11px] font-black uppercase tracking-widest italic text-primary-dark">Period Activity Totals</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-bold uppercase mb-0.5 leading-none">Total Debits</span>
                            <span class="text-[14px] font-mono font-black text-primary italic leading-none">{{ $company->currency ?? 'SAR' }} 12,450.00</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-[9px] text-gray-400 block font-bold uppercase mb-0.5 leading-none">Total Credits</span>
                            <span class="text-[14px] font-mono font-black text-accent italic leading-none">{{ $company->currency ?? 'SAR' }} 12,450.00</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                             <span class="text-[9px] text-gray-400 block font-bold uppercase mb-0.5 leading-none">Net Balance</span>
                             <span class="text-[15px] font-mono font-black text-primary leading-none tracking-tighter">{{ $company->currency ?? 'SAR' }} 0.00</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>
@endsection


