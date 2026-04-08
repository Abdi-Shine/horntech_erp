@extends('admin.admin_master')
@section('page_title', 'Financial Snapshot')

@push('css')
@endpush

@section('admin')
<div class="p-6 space-y-6">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center">
                    <i class="bi bi-bank2 text-primary text-lg"></i>
                </div>
                <h1 class="text-[22px] font-black text-primary-dark tracking-tight">Financial Snapshot</h1>
            </div>
            <p class="text-[12px] text-text-secondary font-medium ml-12 italic">Liquidity position, P&L summary, and treasury balance at a glance</p>
        </div>
        <form action="{{ route('financial_snapshot_dashboard') }}" method="GET" class="flex items-center gap-3">
            <div class="flex items-center bg-white border border-brand-border rounded-xl px-3 py-2 shadow-sm gap-2">
                <i class="bi bi-calendar3 text-primary text-sm"></i>
                <select name="date_range" onchange="this.form.submit()" class="bg-transparent border-none text-[12px] font-bold text-primary-dark focus:ring-0 cursor-pointer">
                    <option value="last_7_days" {{ $dateRange=='last_7_days'?'selected':'' }}>Last 7 Days</option>
                    <option value="this_month" {{ $dateRange=='this_month'?'selected':'' }}>This Month</option>
                    <option value="this_year" {{ $dateRange=='this_year'?'selected':'' }}>This Year</option>
                </select>
            </div>
            <button class="bg-primary text-white text-[11px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl hover:bg-primary/90 transition-all flex items-center gap-2">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </form>
    </div>

    {{-- ── KPI CARDS ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Treasury Balance --}}
        <div class="relative bg-primary-dark rounded-2xl p-6 overflow-hidden shadow-lg kpi-card-hover">
            <div class="absolute top-0 right-0 w-28 h-28 bg-secondary/10 rounded-full -translate-y-10 translate-x-10"></div>
            <div class="relative">
                <div class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center text-primary-dark mb-4">
                    <i class="bi bi-bank2 text-xl"></i>
                </div>
                <p class="text-[10px] font-black opacity-60 uppercase tracking-widest mb-1 text-white">Treasury Liquidity</p>
                <h3 class="text-2xl font-black text-secondary">{{ number_format($totalBankBalance, 2) }}</h3>
                <p class="text-[9px] opacity-50 text-white mt-1">{{ $company->currency ?? 'SAR' }} Available</p>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Period Revenue</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($revenue, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                <i class="bi bi-graph-up-arrow text-xl"></i>
            </div>
        </div>

        {{-- Expenses --}}
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Period Expenses</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($expenses, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-graph-down-arrow text-xl"></i>
            </div>
        </div>

        {{-- Net Profit --}}
        @php $margin = $revenue > 0 ? ($netProfit / $revenue) * 100 : 0; @endphp
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
            <div>
                <p class="text-[12px] text-gray-400 font-medium mb-1">Net Profit</p>
                <h3 class="text-[18px] font-black text-primary">{{ number_format($netProfit, 2) }}</h3>
                <p class="text-xs font-bold text-primary-dark mt-1.5">{{ number_format($margin, 1) }}% margin · {{ $company->currency ?? 'SAR' }}</p>
            </div>
            <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                <i class="bi bi-piggy-bank text-xl"></i>
            </div>
        </div>
    </div>

    {{-- ── CHARTS ROW ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- P&L Pie --}}
        <div class="bg-white rounded-2xl border border-brand-border shadow-sm p-6">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-1.5 h-5 bg-secondary rounded-full"></div>
                <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Revenue vs Expenses Breakdown</h3>
            </div>
            <div class="grid grid-cols-2 gap-8 items-center">
                <div class="h-[220px]">
                    <canvas id="financeChart"></canvas>
                </div>
                <div class="space-y-5">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-3 h-3 rounded-full bg-secondary flex-shrink-0"></span>
                            <span class="text-[10px] font-black text-text-secondary uppercase tracking-wider">Revenue</span>
                        </div>
                        <p class="text-[18px] font-black text-primary-dark">{{ number_format($revenue, 2) }}</p>
                        <p class="text-[9px] text-text-secondary">{{ $company->currency ?? 'SAR' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-3 h-3 rounded-full bg-primary/10 flex-shrink-0"></span>
                            <span class="text-[10px] font-black text-text-secondary uppercase tracking-wider">Expenses</span>
                        </div>
                        <p class="text-[18px] font-black text-primary-dark">{{ number_format($expenses, 2) }}</p>
                        <p class="text-[9px] text-text-secondary">{{ $company->currency ?? 'SAR' }}</p>
                    </div>
                    <div class="pt-3 border-t border-brand-border/50">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-3 h-3 rounded-full bg-primary flex-shrink-0"></span>
                            <span class="text-[10px] font-black text-text-secondary uppercase tracking-wider">Net Profit</span>
                        </div>
                        <p class="text-[20px] font-black {{ $netProfit >= 0 ? 'text-accent' : 'text-primary' }}">{{ number_format($netProfit, 2) }}</p>
                        <p class="text-[9px] text-text-secondary">{{ number_format(abs($margin), 1) }}% {{ $netProfit >= 0 ? 'profit margin' : 'loss margin' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bank Accounts Ledger --}}
        <div class="bg-white rounded-2xl border border-brand-border shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-brand-border flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-primary-dark rounded-full"></div>
                    <h3 class="text-[13px] font-black text-primary-dark uppercase tracking-wider">Treasury Balances</h3>
                </div>
                <span class="text-[10px] font-bold text-text-secondary bg-brand-bg/30 px-3 py-1 rounded-full">{{ $bankBalances->count() }} Accounts</span>
            </div>
            <div class="flex-1 overflow-y-auto">
                <table class="w-full text-left">
                    <thead class="bg-brand-bg/20 border-b border-brand-border sticky top-0">
                        <tr class="text-[10px] font-black text-primary-dark uppercase tracking-widest">
                            <th class="px-6 py-3">Account / Institution</th>
                            <th class="px-6 py-3 text-right">Balance</th>
                            <th class="px-6 py-3 text-center">Currency</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-border/40">
                        @forelse($bankBalances as $acc)
                        <tr class="acc-row transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-xl flex items-center justify-center text-primary flex-shrink-0">
                                        <i class="bi bi-bank text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[12px] font-black text-primary-dark">{{ $acc->name }}</p>
                                        <p class="text-[9px] font-bold text-text-secondary uppercase">{{ $acc->bank_name ?? 'Internal' }} {{ $acc->account_number ? '· '.$acc->account_number : '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-black text-[14px] text-primary-dark">{{ number_format($acc->balance, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-0.5 bg-brand-bg/30 text-text-secondary text-[9px] font-black rounded uppercase">{{ $acc->currency ?? $company->currency ?? 'SAR' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center opacity-40">
                                    <i class="bi bi-bank2 text-4xl mb-2 text-primary"></i>
                                    <span class="text-[12px] font-bold italic">No bank accounts configured.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($bankBalances->count())
                    <tfoot class="bg-primary/5 border-t-2 border-primary/20">
                        <tr>
                            <td class="px-6 py-3 text-[11px] font-black text-primary-dark uppercase">Total Treasury</td>
                            <td class="px-6 py-3 text-right font-black text-primary-dark text-[14px]">{{ number_format($totalBankBalance, 2) }}</td>
                            <td class="px-6 py-3 text-center text-[9px] font-black text-text-secondary uppercase">{{ $company->currency ?? 'SAR' }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('financeChart').getContext('2d');
    const profit = {{ $netProfit > 0 ? $netProfit : 0 }};
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Revenue', 'Expenses', 'Net Profit'],
            datasets: [{
                data: [{{ $revenue }}, {{ $expenses }}, profit],
                backgroundColor: ['#99CC33','#e11d48','#004161'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#004161',
                    callbacks: { label: ctx => ' ' + ctx.label + ': ' + parseFloat(ctx.raw).toLocaleString() + ' {{ $company->currency ?? "SAR" }}' }
                }
            }
        }
    });
});
</script>
@endpush

