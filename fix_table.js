const fs = require('fs');

const path = 'd:\\Bilkheyr\\resources\\views\\frontend\\account\\Account_management.blade.php';
let text = fs.readFileSync(path, 'utf8');

const startMarker = '<!-- Table Header -->';
const endMarker = '<!-- Pagination -->';

const startIndex = text.indexOf(startMarker);
const endIndex = text.indexOf(endMarker);

if (startIndex === -1 || endIndex === -1) {
    console.error("Markers not found!");
    process.exit(1);
}

const replacement = `<!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr class="text-[10px] font-black text-primary uppercase tracking-widest">
                                <th class="px-5 py-4">Date</th>
                                <th class="px-5 py-4">Ref No.</th>
                                <th class="px-5 py-4">Type</th>
                                <th class="px-5 py-4">Account</th>
                                <th class="px-5 py-4">Description</th>
                                <th class="px-5 py-4 text-right">Amount (SAR)</th>
                                <th class="px-5 py-4">Category</th>
                                <th class="px-5 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($transactions as $trx)
                            <tr class="hover-row transition-all duration-200">
                                <td class="px-5 py-3 align-middle">
                                    <div class="font-bold text-gray-900">{{ \\Carbon\\Carbon::parse($trx->date)->format('d M') }}</div>
                                    <div class="text-[10px] text-gray-500">{{ \\Carbon\\Carbon::parse($trx->created_at)->format('h:i A') }}</div>
                                </td>
                                <td class="px-5 py-3 align-middle">
                                    <div class="font-mono font-bold text-primary text-xs">{{ $trx->reference }}</div>
                                </td>
                                <td class="px-5 py-3 align-middle">
                                    @if(str_starts_with($trx->reference, 'DEP-'))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-green-50 text-green-700 text-[10px] font-black tracking-widest uppercase border border-green-200">
                                        <i class="bi bi-arrow-down-circle"></i> DEPOSIT
                                    </span>
                                    @elseif(str_starts_with($trx->reference, 'WTH-'))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-rose-50 text-rose-700 text-[10px] font-black tracking-widest uppercase border border-rose-200">
                                        <i class="bi bi-arrow-up-circle"></i> WITHDRAW
                                    </span>
                                    @elseif(str_starts_with($trx->reference, 'TRF-'))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-primary/10 text-primary text-[10px] font-black tracking-widest uppercase border border-primary/20">
                                        <i class="bi bi-arrow-left-right"></i> TRANSFER
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-[10px] font-black tracking-widest uppercase border border-amber-200">
                                        <i class="bi bi-pencil-square"></i> ADJUST
                                    </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 align-middle">
                                    @php
                                        // Attempt to identify the main bank account linked to the entry
                                        // Usually Bank Account is either DEBITED (Deposit) or CREDITED (Withdrawal)
                                        // Bank accounts are type 'bank' or 'cash'
                                        $bankItem = $trx->items->first(function($item) use ($bankAccounts) {
                                            return $bankAccounts->contains('id', $item->account_id);
                                        });
                                    @endphp
                                    @if($bankItem)
                                    <div class="font-bold text-gray-900 text-sm">{{ $bankItem->account->code }}</div>
                                    <div class="text-xs text-gray-500">{{ $bankItem->account->name }}</div>
                                    @else
                                    <div class="text-xs text-gray-400">Multiple Accounts</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 align-middle">
                                    <div class="font-semibold text-gray-900 text-sm">{{ $trx->description }}</div>
                                </td>
                                <td class="px-5 py-3 align-middle text-right">
                                    @if(str_starts_with($trx->reference, 'WTH-') || str_starts_with($trx->reference, 'ADJ-'))
                                    <div class="font-bold text-rose-600 text-base">-{{ number_format($trx->total_amount, 2) }}</div>
                                    @else
                                    <div class="font-bold text-green-600 text-base">+{{ number_format($trx->total_amount, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 align-middle">
                                    @php
                                        // The "Category" account is the other account in the entry
                                        $catItem = $trx->items->first(function($item) use ($bankAccounts) {
                                            return !$bankAccounts->contains('id', $item->account_id);
                                        });
                                    @endphp
                                    @if($catItem)
                                    <div class="text-xs font-bold text-gray-700">{{ $catItem->account->name }}</div>
                                    <div class="text-[10px] text-gray-500 uppercase">{{ $catItem->account->category }}</div>
                                    @else
                                    <div class="text-xs text-gray-500">Various</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 align-middle text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-600 rounded hover:bg-primary/10 hover:text-primary transition-all text-sm border border-gray-200">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-600 rounded hover:bg-primary/10 hover:text-primary transition-all text-sm border border-gray-200">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-5 py-8 text-center bg-gray-50/50">
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm border border-gray-100">
                                        <i class="bi bi-journal-x text-2xl text-gray-400"></i>
                                    </div>
                                    <div class="text-gray-900 font-bold">No Transactions Found</div>
                                    <div class="text-xs text-gray-500 mt-1">There are no banking activities recorded yet.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>\n                `;

text = text.substring(0, startIndex) + replacement + text.substring(endIndex);

fs.writeFileSync(path, text, 'utf8');
console.log('Table replaced successfully.');
