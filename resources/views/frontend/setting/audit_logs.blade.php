@extends('admin.admin_master')
@section('page_title', 'Audit Logs')

@push('css')
@endpush

@section('admin')

    <div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen font-inter" x-data="{ 
                searchTerm: '',
                statusFilter: ''
            }">

        <!-- Header Section -->
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">System Setting</span>
                    <i class="bi bi-chevron-right text-[10px] text-gray-300"></i>
                    <span class="text-[10px] font-black text-accent uppercase tracking-widest">Operation Security</span>
                </div>
                <h1 class="text-[20px] font-bold text-primary-dark">System Audit Logs</h1>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()"
                    class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-primary-dark font-semibold rounded-[0.5rem] hover:bg-gray-50 transition-all shadow-sm text-sm">
                    <i class="bi bi-printer"></i>
                    Print Report
                </button>
                <button
                    class="flex items-center gap-2 px-5 py-2.5 bg-accent text-primary font-semibold rounded-[0.5rem] hover:bg-accent transition-all shadow-sm text-sm">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export
                </button>
                <button onclick="location.reload()"
                    class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-semibold rounded-[0.5rem] hover:bg-primary/90 transition-all shadow-sm text-sm group">
                    <i class="bi bi-arrow-clockwise group-hover:rotate-180 transition-transform duration-300"></i>
                    Refresh Logs
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Logs -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-[13px] font-medium text-gray-400 mb-1">Total Audit Logs</p>
                    <h3 class="text-[24px] font-black text-primary">{{ number_format($stats['total']) }}</h3>
                    <p class="text-[12px] font-bold text-primary mt-1.5 flex items-center gap-1">
                        <i class="bi bi-graph-up text-[10px]"></i> System-wide activity
                    </p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary">
                    <i class="bi bi-file-text-fill text-lg"></i>
                </div>
            </div>

            <!-- Successful Actions -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-[13px] font-medium text-gray-400 mb-1">Successful Actions</p>
                    <h3 class="text-[24px] font-black text-primary">{{ number_format($stats['success']) }}</h3>
                    <p class="text-[12px] font-bold text-primary mt-1.5 flex items-center gap-1">
                        <i class="bi bi-check-all text-[10px]"></i> Operation healthy
                    </p>
                </div>
                <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent">
                    <i class="bi bi-check-circle-fill text-lg"></i>
                </div>
            </div>

            <!-- Warning Events -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-[13px] font-medium text-gray-400 mb-1">Warning Events</p>
                    <h3 class="text-[24px] font-black text-primary">{{ number_format($stats['warning']) }}</h3>
                    <p class="text-[12px] font-bold text-primary mt-1.5 flex items-center gap-1">
                        <i class="bi bi-info-circle text-[10px]"></i> Requires review
                    </p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary">
                    <i class="bi bi-exclamation-triangle-fill text-lg"></i>
                </div>
            </div>

            <!-- Failed Actions -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-[13px] font-medium text-gray-400 mb-1">Failed Actions</p>
                    <h3 class="text-[24px] font-black text-primary">{{ number_format($stats['failed']) }}</h3>
                    <p class="text-[12px] font-bold text-primary mt-1.5 flex items-center gap-1">
                        <i class="bi bi-shield-exclamation text-[10px]"></i> Attention needed
                    </p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary">
                    <i class="bi bi-x-circle-fill text-lg"></i>
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
                    <input type="text" x-model="searchTerm" placeholder="Search logs (module, action, description)..."
                        class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>

                <!-- Status Filter -->
                <div class="relative min-w-[150px]">
                    <select x-model="statusFilter"
                        class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="success">Success</option>
                        <option value="warning">Warning</option>
                        <option value="failed">Failed</option>
                    </select>
                    <i
                        class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                </div>
            </div>

            <!-- Table Title -->
            <div class="px-5 py-3 flex items-center justify-between border-b border-gray-100 bg-background/50">
                <div class="flex items-center gap-2">
                    <i class="bi bi-list-ul text-primary-dark text-sm"></i>
                    <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">Activity Stream</h2>
                </div>
                <span class="text-[11px] font-semibold text-gray-400 italic">
                    <i class="bi bi-clock-fill me-1"></i> Updated {{ now()->format('H:i:s') }}
                </span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left">
                    <thead>
                        <tr class="bg-white border-b border-gray-100">
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider w-16 text-center">#</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Log ID</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Time</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">User</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Module</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider">Action</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider w-1/3">Description</th>
                            <th class="px-5 py-4 text-[12px] font-black text-primary-dark uppercase tracking-wider text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50/60 transition-colors bg-white group"
                                x-show="(searchTerm === '' || '{{ strtolower($log->module) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($log->action) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($log->description) }}'.includes(searchTerm.toLowerCase())) && (statusFilter === '' || '{{ $log->status }}' === statusFilter)">
                                <td class="px-5 py-4 text-center">
                                    <span class="text-xs font-bold text-primary-dark leading-tight">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-xs font-bold text-primary-dark">#{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-primary-dark leading-tight">{{ $log->created_at->format('M d, Y') }}</span>
                                        <span class="text-[11px] text-gray-500 font-bold leading-tight">{{ $log->created_at->format('h:i:s A') }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    @if($log->user)
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-primary-dark leading-tight">{{ $log->user->name }}</span>
                                    </div>
                                    @else
                                    <span class="text-xs font-bold text-gray-400 leading-tight italic">System</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-xs font-bold text-primary-dark leading-tight">{{ $log->module }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-xs font-bold text-primary-dark leading-tight">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="text-xs font-bold text-primary-dark leading-tight truncate max-w-xs" title="{{ $log->description }}">
                                        {{ $log->description }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="text-xs font-bold text-primary-dark leading-tight">
                                        @if($log->status == 'success')
                                            OK
                                        @elseif($log->status == 'warning')
                                            WARN
                                        @else
                                            FAIL
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-16 text-center text-gray-400">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                        <i class="bi bi-inbox text-2xl"></i>
                                    </div>
                                    <p class="text-[13px] font-bold uppercase tracking-widest text-gray-400">No activity logs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <!-- Standard Laravel Pagination UI -->
                <div class="px-5 py-4 border-t border-gray-100 bg-white">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
