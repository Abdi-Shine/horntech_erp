const fs = require('fs');
const path = require('path');

const filePath = path.resolve('d:\\Bilkheyr\\resources\\views\\frontend\\account\\Account_management.blade.php');

let text = fs.readFileSync(filePath, 'utf8');

const parts = text.split('<!-- Deposit Modal -->');
if (parts.length < 2) {
    console.log("Deposit Modal not found");
    process.exit(1);
}

const preModals = parts[0];
let modals = '<!-- Deposit Modal -->' + parts[1];

// 1. Update Section Headers
modals = modals.replace(/<div>\s*<h3 class="text-lg font-display font-bold text-primary mb-4 flex items-center">\s*(<i class="bi ([^"]+)"><\/i>)\s*([^<]+)\s*<\/h3>/g,
    (match, fullIcon, iconName, title) => {
        // Fallback for messy classes
        const cleanIcon = iconName.includes(' ') ? iconName.split(' ')[0] : iconName;
        return `<div class="p-4 bg-gray-50/50 border border-gray-200 rounded-xl space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-primary/10 rounded-md flex items-center justify-center">
                            <i class="bi ${cleanIcon} text-primary text-[10px]"></i>
                        </div>
                        <span class="text-[10px] font-black text-primary-dark uppercase tracking-widest">${title.trim()}</span>
                    </div>`;
    }
);

// 2. Grids
modals = modals.replace(/grid md:grid-cols-2 gap-4/g, 'grid grid-cols-1 md:grid-cols-2 gap-3 pt-2');

// 3. Spacing on divs containing labels
modals = modals.replace(/<div>\s*<label/g, '<div class="space-y-1.5">\n                            <label');
modals = modals.replace(/<div class="md:col-span-2">\s*<label/g, '<div class="md:col-span-2 space-y-1.5">\n                            <label');

// 4. Labels
modals = modals.replace(/<label class="block text-xs font-bold text-gray-600 uppercase mb-2">([^<]*?)<span class="text-red-500">/g, '<label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">$1<span class="text-rose-500">');
modals = modals.replace(/<label class="block text-xs font-bold text-gray-600 uppercase mb-2">([^<]*?)<\/label>/g, '<label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">$1</label>');

// 5. Inputs styling
modals = modals.replace(/px-4 py-3 border-2/g, 'px-3 py-2 bg-white border');
modals = modals.replace(/font-medium/g, 'text-xs font-bold text-gray-700');
modals = modals.replace(/<select(.*?)class="(.*?)"(.*?)>/g, '<select$1class="$2 appearance-none cursor-pointer"$3>');
modals = modals.replace(/bg-gray-50 font-bold text-lg/g, 'bg-gray-50 text-xs font-bold text-gray-700');

// 6. Accounting Preview Blocks
modals = modals.replace(/<div class="bg-gray-50 rounded-lg border-2 border-gray-200 p-4">\s*<h4 class="text-sm font-bold text-primary mb-3 flex items-center gap-2">\s*<i class="bi bi-calculator"><\/i>\s*([^<]+)\s*<\/h4>/g,
    (match, title) => {
        return `<div class="p-4 bg-gray-50/50 border border-gray-200 rounded-xl space-y-2">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-6 h-6 bg-primary/10 rounded-md flex items-center justify-center">
                            <i class="bi bi-calculator text-primary text-[10px]"></i>
                        </div>
                        <span class="text-[10px] font-black text-primary-dark uppercase tracking-widest">${title.trim()}</span>
                    </div>`;
    }
);

modals = modals.replace(/<div class="flex justify-between items-center p-2 bg-white rounded">/g, '<div class="flex justify-between items-center p-2 border border-gray-100 bg-white rounded-lg text-xs">');
modals = modals.replace(/<div class="flex justify-between items-center p-3 bg-white rounded">/g, '<div class="flex justify-between items-center p-2 border border-gray-100 bg-white rounded-lg text-xs">');
modals = modals.replace(/<div class="flex justify-between items-center p-3 bg-primary\/10 rounded">/g, '<div class="flex justify-between items-center p-3 border border-primary/20 bg-primary/10 rounded-lg text-xs mt-2">');

// 7. Warning Box
modals = modals.replace(/<div class="bg-red-50 rounded-lg border-2 border-red-200 p-4">/g, '<div class="bg-rose-50 rounded-xl border border-rose-100 p-4">');
modals = modals.replace(/text-red-600/g, 'text-rose-500');
modals = modals.replace(/text-red-800/g, 'text-rose-800');

// 8. Adjustments to footer buttons
modals = modals.replace(/text-sm shadow-sm">/g, 'text-xs shadow-sm">');

// 9. Inner wrapper
modals = modals.replace(/<form class="p-6 space-y-6">/g, '<form class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">');
modals = modals.replace(/class="bg-white rounded-2xl max-w-3xl w-full max-h-\[90vh\] overflow-y-auto"/g, 'class="bg-white rounded-[1rem] w-full max-w-3xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative" @click.away="closeModal()"');


fs.writeFileSync(filePath, preModals + modals, 'utf8');

console.log("Successfully rebuilt modal inner structure.");
