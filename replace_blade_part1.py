import re

path = r"d:\Bilkheyr\resources\views\frontend\account\Account_management.blade.php"

with open(path, 'r', encoding='utf-8') as f:
    html = f.read()

# 1. SUMMARY STATS
html = html.replace('$ 1,183,100', 'SAR {{ number_format($totalBalance, 2) }}')
html = html.replace('10 Active Accounts', '{{ $activeAccounts }} Active Accounts')

html = html.replace('$ 485,000', 'SAR {{ number_format($depositsAmount, 2) }}')
html = html.replace('24 Transactions', '{{ $depositsCount }} Transactions')

html = html.replace('$ 328,500', 'SAR {{ number_format($withdrawalsAmount, 2) }}')
html = html.replace('18 Transactions', '{{ $withdrawalsCount }} Transactions')

html = html.replace('$ 125,000', 'SAR {{ number_format($transfersAmount, 2) }}')
html = html.replace('8 Transactions', '{{ $transfersCount }} Transactions')

html = html.replace('$ 2,450', 'SAR {{ number_format($adjustmentsAmount, 2) }}')
html = html.replace('3 Transactions', '{{ $adjustmentsCount }} Transactions')

# 2. TRANSACTION LOOP
# Let's extract everything inside `<div class="divide-y divide-gray-200">` and clear it all, then put the @foreach loop
start_marker = '<div class="divide-y divide-gray-200">'
end_marker = '<!-- Pagination -->'

start_idx = html.find(start_marker) + len(start_marker)
end_idx = html.find(end_marker)

loop_content = """
                    @forelse($transactions as $trx)
                    <div class="grid grid-cols-12 gap-4 px-6 py-4 hover-row items-center">
                        <div class="col-span-1">
                            <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($trx->date)->format('d M') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($trx->created_at)->format('h:i A') }}</div>
                        </div>
                        <div class="col-span-1">
                            <div class="font-mono font-bold text-primary text-sm">{{ $trx->reference }}</div>
                        </div>
                        <div class="col-span-1">
                            @if(str_starts_with($trx->reference, 'DEP-'))
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold flex items-center gap-1">
                                <i class="bi bi-arrow-down-circle"></i> DEPOSIT
                            </span>
                            @elseif(str_starts_with($trx->reference, 'WTH-'))
                            <span class="px-2 py-1 bg-rose-100 text-rose-700 rounded text-xs font-bold flex items-center gap-1">
                                <i class="bi bi-arrow-up-circle"></i> WITHDRAW
                            </span>
                            @elseif(str_starts_with($trx->reference, 'TRF-'))
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold flex items-center gap-1">
                                <i class="bi bi-arrow-left-right"></i> TRANSFER
                            </span>
                            @else
                            <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-bold flex items-center gap-1">
                                <i class="bi bi-pencil-square"></i> ADJUST
                            </span>
                            @endif
                        </div>
                        <div class="col-span-2">
                            @php
                                $bankItem = $trx->items->whereIn('account_id', $bankAccounts->pluck('id'))->first();
                            @endphp
                            @if($bankItem)
                            <div class="font-bold text-gray-900">{{ $bankItem->account->code }}</div>
                            <div class="text-xs text-gray-500">{{ $bankItem->account->name }}</div>
                            @endif
                        </div>
                        <div class="col-span-3">
                            <div class="font-semibold text-gray-900">{{ $trx->description }}</div>
                        </div>
                        <div class="col-span-1 text-right">
                            @if(str_starts_with($trx->reference, 'WTH-') || str_starts_with($trx->reference, 'ADJ-'))
                            <div class="font-bold text-rose-600 text-lg">{{ number_format($trx->total_amount, 2) }}</div>
                            @else
                            <div class="font-bold text-primary text-lg">+{{ number_format($trx->total_amount, 2) }}</div>
                            @endif
                        </div>
                        <div class="col-span-2">
                            <div class="text-sm font-semibold text-gray-700">Journal Entry</div>
                        </div>
                        <div class="col-span-1 flex items-center justify-center gap-2">
                            <button class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition-all text-xs border border-blue-200">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500 font-medium">No transactions found.</div>
                    @endforelse
                </div>
                """

html = html[:start_idx] + loop_content + "                " + html[end_idx:]

with open(path, 'w', encoding='utf-8') as f:
    f.write(html)
