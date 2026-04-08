@extends('admin.admin_master')
@section('page_title', 'Low Stock Alerts')

@section('admin')
<div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <div>
            <h1 class="text-[20px] font-bold text-primary-dark">Low Stock Alerts</h1>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Alerts -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Low Stock Alerts</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['total'] }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Total alerts found</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-down-arrow text-lg"></i>
            </div>
        </div>

        <!-- Critical Risks -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Critical Risks</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['critical'] }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                    <i class="bi bi-exclamation-triangle-fill text-[10px]"></i> Urgent action
                </p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-shield-exclamation text-lg"></i>
            </div>
        </div>

        <!-- Warning Levels -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Warning Levels</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['warning'] }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                    <i class="bi bi-info-circle-fill text-[10px]"></i> Need attention
                </p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-megaphone text-lg"></i>
            </div>
        </div>

        <!-- Affected Branches -->
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Affected Branches</p>
                <h3 class="text-[18px] font-black text-primary">{{ $stats['branches'] }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">Impacted locations</p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-building-up text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Table Section -->
    <div class="bg-white rounded-[1rem] border border-gray-200/80 shadow-sm overflow-hidden mb-6">
        <!-- Filter Bar -->
        <form action="{{ route('low-stock.view') }}" method="GET">
            <div class="p-4 border-b border-gray-100 flex items-center gap-3 overflow-x-auto custom-scrollbar whitespace-nowrap">
                <!-- Search -->
                <div class="relative group flex-1 min-w-[200px]">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-primary transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search products..."
                        class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>

                <!-- Branch Filter -->
                <div class="relative min-w-[200px]">
                    <select name="branch_id" onchange="this.form.submit()"
                        class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">All Locations</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                </div>

                <!-- Threat Level Filter -->
                <div class="relative min-w-[180px]">
                    <select name="threat_level" onchange="this.form.submit()"
                        class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">Threat Level</option>
                        <option value="critical" {{ request('threat_level') == 'critical' ? 'selected' : '' }}>Critical</option>
                        <option value="warning" {{ request('threat_level') == 'warning' ? 'selected' : '' }}>Warning</option>
                    </select>
                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                </div>

                @if(request()->anyFilled(['search', 'threat_level', 'branch_id']))
                    <a href="{{ route('low-stock.view') }}" 
                        class="w-9 h-9 flex items-center justify-center bg-primary/10 text-primary rounded-[0.5rem] hover:bg-primary hover:text-white transition-all flex-shrink-0 shadow-sm border border-primary/10" 
                        title="Clear All Filters">
                        <i class="bi bi-x-lg text-sm"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Table Title Bar -->
        <div class="px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50">
            <i class="bi bi-list-ul text-primary text-sm"></i>
            <h2 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Alert Registry</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider w-16 text-center">#</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Product</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Location</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Current Stock</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Min Level</th>
                        <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Threat Level</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($lowStockProducts as $stock)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                            {{ str_pad(($lowStockProducts->currentPage() - 1) * $lowStockProducts->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                            {{ $stock->product_name }}
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark">
                            <div class="flex items-center gap-2">
                                {{ $stock->branch_name ?? 'Primary Vault' }}
                            </div>
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                            {{ $stock->quantity }} Units
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-primary-dark text-center">
                            {{ $stock->low_stock_threshold ?? 10 }}
                        </td>
                        <td class="px-5 py-4 text-[12px] font-semibold text-center">
                            @if($stock->quantity <= 5)
                                <span class="text-[11px] font-black text-primary uppercase tracking-widest">Critical</span>
                            @else
                                <span class="text-[11px] font-black text-primary uppercase tracking-widest">Warning</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <i class="bi bi-shield-check text-2xl text-accent"></i>
                            </div>
                            <p class="text-[13px] font-bold uppercase tracking-widest text-gray-400">No stock alerts found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-[11px] font-black text-gray-400 uppercase tracking-widest">
                Showing {{ $lowStockProducts->firstItem() ?? '0' }} to {{ $lowStockProducts->lastItem() ?? '0' }} of {{ $lowStockProducts->total() }} Entries
            </div>
            <div class="flex items-center gap-2">
                @if ($lowStockProducts->onFirstPage())
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm">
                        <i class="bi bi-chevron-left text-[10px]"></i>
                    </button>
                @else
                    <a href="{{ $lowStockProducts->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 transition-all shadow-sm">
                        <i class="bi bi-chevron-left text-[10px]"></i>
                    </a>
                @endif

                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-black text-xs shadow-md shadow-primary/20">
                    {{ $lowStockProducts->currentPage() }}
                </button>

                @if ($lowStockProducts->hasMorePages())
                    <a href="{{ $lowStockProducts->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 transition-all shadow-sm">
                        <i class="bi bi-chevron-right text-[10px]"></i>
                    </a>
                @else
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm">
                        <i class="bi bi-chevron-right text-[10px]"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
