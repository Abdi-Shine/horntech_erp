const fs = require('fs');

const path = 'd:\\Bilkheyr\\resources\\views\\frontend\\account\\account_management.blade.php';
let text = fs.readFileSync(path, 'utf8');

// Summary Cards Replacement
// Total Balance
text = text.replace(
    /<div class="text-xl font-display font-bold">\$ 1,183,100<\/div>/,
    '<div class="text-xl font-display font-bold">SAR {{ number_format($totalBalance, 2) }}</div>'
);
text = text.replace(
    /<div class="text-\[10px\] text-white\/90 mt-2">10 Active Accounts<\/div>/,
    '<div class="text-[10px] text-white/90 mt-2">{{ $activeAccounts }} Active Accounts</div>'
);

// Deposits
text = text.replace(
    /<div class="text-base font-display font-black text-primary">\$ 485,000<\/div>/,
    '<div class="text-base font-display font-black text-primary">SAR {{ number_format($depositsAmount, 2) }}</div>'
);
text = text.replace(
    /<div class="text-\[10px\] text-gray-400 mt-1\.5">24 Transactions<\/div>/,
    '<div class="text-[10px] text-gray-400 mt-1.5">{{ $depositsCount }} Transactions</div>'
);

// Withdrawals
text = text.replace(
    /<div class="text-base font-display font-black text-red-500">\$ 328,500<\/div>/,
    '<div class="text-base font-display font-black text-red-500">SAR {{ number_format($withdrawalsAmount, 2) }}</div>'
);
text = text.replace(
    /<div class="text-\[10px\] text-gray-400 mt-1\.5">18 Transactions<\/div>/,
    '<div class="text-[10px] text-gray-400 mt-1.5">{{ $withdrawalsCount }} Transactions</div>'
);

// Transfers
text = text.replace(
    /<div class="text-base font-display font-black text-primary">\$ 125,000<\/div>/,
    '<div class="text-base font-display font-black text-primary">SAR {{ number_format($transfersAmount, 2) }}</div>'
);
text = text.replace(
    /<div class="text-\[10px\] text-gray-400 mt-1\.5">8 Transactions<\/div>/,
    '<div class="text-[10px] text-gray-400 mt-1.5">{{ $transfersCount }} Transactions</div>'
);

// Adjustments
text = text.replace(
    /<div class="text-base font-display font-black text-amber-600">\$ 2,450<\/div>/,
    '<div class="text-base font-display font-black text-amber-600">SAR {{ number_format($adjustmentsAmount, 2) }}</div>'
);
text = text.replace(
    /<div class="text-\[10px\] text-gray-400 mt-1\.5">3 Transactions<\/div>/,
    '<div class="text-[10px] text-gray-400 mt-1.5">{{ $adjustmentsCount }} Transactions</div>'
);

fs.writeFileSync(path, text, 'utf8');
console.log('Summary cards updated.');
