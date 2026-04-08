import re

path = r'd:\Bilkheyr\resources\views\frontend\account\Account_management.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    text = f.read()

# 1. Update Modal Containers
text = text.replace('class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto"',
                    'class="bg-white rounded-[1rem] w-full max-w-3xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative"')

# 2. Update `<form class="p-6 space-y-6">` to include overflow
text = text.replace('<form class="p-6 space-y-6">', '<form class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-5 bg-white">')

# 3. Update Modal Headers
# Deposit
text = re.sub(
    r'<div class="sticky top-0 bg-primary p-6 rounded-t-2xl text-white">.*?<h2 class="text-2xl font-display font-bold flex items-center gap-2">\s*<i class="bi bi-arrow-down-circle"></i>\s*Record Deposit\s*</h2>\s*<p class="text-sm text-white/80 mt-1">Add money to bank account</p>\s*</div>\s*<button onclick="closeDepositModal\(\)" class="w-10 h-10 flex items-center justify-center hover:bg-white/20 rounded-lg transition-all">\s*<i class="bi bi-x-lg text-xl"></i>\s*</button>\s*</div>\s*</div>',
    r'''<!-- Modal Header (Customer Style) -->
            <div class="px-5 py-4 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 border border-white/10 rounded-lg flex items-center justify-center text-white text-lg shadow-inner backdrop-blur-md">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-base font-bold text-white tracking-tight">Record Deposit</h2>
                            <p class="text-[10px] text-blue-100/70 font-medium mt-0.5">Add money to bank account</p>
                        </div>
                    </div>
                    
                    <button onclick="closeDepositModal()" 
                        class="w-7 h-7 bg-white/10 border border-white/10 text-white rounded-md hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-[10px]"></i>
                    </button>
                </div>
            </div>''',
    text, flags=re.DOTALL
)

# Withdraw
text = re.sub(
    r'<div class="sticky top-0 bg-primary p-6 rounded-t-2xl text-white">.*?<h2 class="text-2xl font-display font-bold flex items-center gap-2">\s*<i class="bi bi-arrow-up-circle"></i>\s*Record Withdrawal\s*</h2>\s*<p class="text-sm text-white/80 mt-1">Remove money from bank account</p>\s*</div>\s*<button onclick="closeWithdrawModal\(\)" class="w-10 h-10 flex items-center justify-center hover:bg-white/20 rounded-lg transition-all">\s*<i class="bi bi-x-lg text-xl"></i>\s*</button>\s*</div>\s*</div>',
    r'''<!-- Modal Header (Customer Style) -->
            <div class="px-5 py-4 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 border border-white/10 rounded-lg flex items-center justify-center text-white text-lg shadow-inner backdrop-blur-md">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-base font-bold text-white tracking-tight">Record Withdrawal</h2>
                            <p class="text-[10px] text-blue-100/70 font-medium mt-0.5">Remove money from bank account</p>
                        </div>
                    </div>
                    
                    <button onclick="closeWithdrawModal()" 
                        class="w-7 h-7 bg-white/10 border border-white/10 text-white rounded-md hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-[10px]"></i>
                    </button>
                </div>
            </div>''',
    text, flags=re.DOTALL
)

# Transfer
text = re.sub(
    r'<div class="sticky top-0 bg-primary p-6 rounded-t-2xl text-white">.*?<h2 class="text-2xl font-display font-bold flex items-center gap-2">\s*<i class="bi bi-arrow-left-right"></i>\s*Transfer Between Accounts\s*</h2>\s*<p class="text-sm text-white/80 mt-1">Move money between bank accounts</p>\s*</div>\s*<button onclick="closeTransferModal\(\)" class="w-10 h-10 flex items-center justify-center hover:bg-white/20 rounded-lg transition-all">\s*<i class="bi bi-x-lg text-xl"></i>\s*</button>\s*</div>\s*</div>',
    r'''<!-- Modal Header (Customer Style) -->
            <div class="px-5 py-4 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 border border-white/10 rounded-lg flex items-center justify-center text-white text-lg shadow-inner backdrop-blur-md">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-base font-bold text-white tracking-tight">Transfer Between Accounts</h2>
                            <p class="text-[10px] text-blue-100/70 font-medium mt-0.5">Move money between bank accounts</p>
                        </div>
                    </div>
                    
                    <button onclick="closeTransferModal()" 
                        class="w-7 h-7 bg-white/10 border border-white/10 text-white rounded-md hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-[10px]"></i>
                    </button>
                </div>
            </div>''',
    text, flags=re.DOTALL
)

# Adjustment
text = re.sub(
    r'<div class="sticky top-0 bg-primary p-6 rounded-t-2xl text-white">.*?<h2 class="text-2xl font-display font-bold flex items-center gap-2">\s*<i class="bi bi-pencil-square"></i>\s*Bank Balance Adjustment\s*</h2>\s*<p class="text-sm text-white/80 mt-1">Correct or adjust account balance</p>\s*</div>\s*<button onclick="closeAdjustmentModal\(\)" class="w-10 h-10 flex items-center justify-center hover:bg-white/20 rounded-lg transition-all">\s*<i class="bi bi-x-lg text-xl"></i>\s*</button>\s*</div>\s*</div>',
    r'''<!-- Modal Header (Customer Style) -->
            <div class="px-5 py-4 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 border border-white/10 rounded-lg flex items-center justify-center text-white text-lg shadow-inner backdrop-blur-md">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-base font-bold text-white tracking-tight">Bank Balance Adjustment</h2>
                            <p class="text-[10px] text-blue-100/70 font-medium mt-0.5">Correct or adjust account balance</p>
                        </div>
                    </div>
                    
                    <button onclick="closeAdjustmentModal()" 
                        class="w-7 h-7 bg-white/10 border border-white/10 text-white rounded-md hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-[10px]"></i>
                    </button>
                </div>
            </div>''',
    text, flags=re.DOTALL
)


# Add Account
text = re.sub(
    r'<div class="sticky top-0 bg-primary p-6 rounded-t-2xl text-white">.*?<h2 class="text-2xl font-display font-bold">Add New Bank Account</h2>\s*<p class="text-sm text-white/80 mt-1">Register a new bank account</p>\s*</div>\s*<button onclick="closeAddAccountModal\(\)" class="w-10 h-10 flex items-center justify-center hover:bg-white/20 rounded-lg transition-all">\s*<i class="bi bi-x-lg text-xl"></i>\s*</button>\s*</div>\s*</div>',
    r'''<!-- Modal Header (Customer Style) -->
            <div class="px-5 py-4 bg-primary relative overflow-hidden shrink-0">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 border border-white/10 rounded-lg flex items-center justify-center text-white text-lg shadow-inner backdrop-blur-md">
                            <i class="bi bi-bank"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-base font-bold text-white tracking-tight">Add New Bank Account</h2>
                            <p class="text-[10px] text-blue-100/70 font-medium mt-0.5">Register a new bank account</p>
                        </div>
                    </div>
                    
                    <button onclick="closeAddAccountModal()" 
                        class="w-7 h-7 bg-white/10 border border-white/10 text-white rounded-md hover:bg-white/20 transition-all flex items-center justify-center shadow-sm">
                        <i class="bi bi-x-lg text-[10px]"></i>
                    </button>
                </div>
            </div>''',
    text, flags=re.DOTALL
)

# 4. Update Modal Footers
def replace_footer(match):
    close_fn = match.group(1)
    btn_text = match.group(2)
    return f'''<!-- Modal Footer (Customer Style) -->
                <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/80 flex items-center justify-between shrink-0">
                    <button type="button" onclick="{close_fn}()" 
                        class="px-4 py-2 bg-white border border-gray-200 text-gray-600 font-semibold rounded-lg hover:bg-gray-50 transition-all text-xs">
                        Cancel Window
                    </button>
                    <button type="submit" 
                        class="flex items-center gap-2 px-5 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-all text-xs shadow-sm">
                        <i class="bi bi-check2-circle text-base"></i>
                        <span>{btn_text}</span>
                    </button>
                </div>'''

text = re.sub(
    r'<div class="flex gap-3 pt-4 border-t-2">\s*<button type="button" onclick="([a-zA-Z0-9_]+)\(\)" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-50 transition-all">\s*Cancel\s*</button>\s*<button type="submit" class="flex-1 px-6 py-3 bg-primary text-white rounded-lg font-bold hover:bg-primary-dark transition-all shadow-lg">\s*<i class="bi bi-check-lg mr-2"></i>\s*([^<]+)\s*</button>\s*</div>',
    replace_footer,
    text
)

text = re.sub(
    r'<div class="flex gap-3 pt-4 border-t-2">\s*<button type="button" onclick="([a-zA-Z0-9_]+)\(\)" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-50 transition-all">\s*Cancel\s*</button>\s*<button type="submit" class="flex-1 px-6 py-3 text-white rounded-lg font-bold transition-all shadow-lg bg-primary hover:bg-primary-dark">\s*<i class="bi bi-check-lg mr-2"></i>\s*([^<]+)\s*</button>\s*</div>',
    replace_footer,
    text
)


with open(path, 'w', encoding='utf-8') as f:
    f.write(text)

print("Modal styling completely aligned to branding model.")
