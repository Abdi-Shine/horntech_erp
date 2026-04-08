import re

path = r"d:\Bilkheyr\resources\views\frontend\account\Account_management.blade.php"

with open(path, 'r', encoding='utf-8') as f:
    text = f.read()

# Make sure we don't mess up the deposit changes which were already applied

# 1. Withdraw Modal
parts = text.split('<!-- Withdraw Modal -->')
if len(parts) > 1:
    modal = parts[1]
    
    # Form tag
    modal = modal.replace('<form class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">',
                          '<form action="{{ route(\'bank.transaction.withdraw\') }}" method="POST" class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">\n                @csrf')
    
    # Text Inputs
    modal = modal.replace('<input type="number" step="0.01" required placeholder="0.00"', '<input type="number" name="amount" step="0.01" required placeholder="0.00"')
    modal = modal.replace('<input type="date" required value="2026-02-27"', '<input type="date" name="date" required value="{{ date(\'Y-m-d\') }}"')
    modal = modal.replace('<input type="text" required placeholder="Vendor/Supplier name"', '<input type="text" name="paid_to" required placeholder="Vendor/Supplier name"')
    modal = modal.replace('<textarea rows="3" placeholder="Additional details..."', '<textarea name="notes" rows="3" placeholder="Additional details..."')
    
    text = parts[0] + '<!-- Withdraw Modal -->' + modal

# 2. Transfer Modal
parts = text.split('<!-- Transfer Modal -->')
if len(parts) > 1:
    modal = parts[1]
    
    modal = modal.replace('<form class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">',
                          '<form action="{{ route(\'bank.transaction.transfer\') }}" method="POST" class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">\n                @csrf')
    
    modal = modal.replace('<input type="number" step="0.01" required placeholder="0.00"', '<input type="number" name="amount" step="0.01" required placeholder="0.00"')
    modal = modal.replace('<input type="date" required value="2026-02-27"', '<input type="date" name="date" required value="{{ date(\'Y-m-d\') }}"')
    modal = modal.replace('<input type="text" required placeholder="e.g. Replenish branch cash"', '<input type="text" name="reason" required placeholder="e.g. Replenish branch cash"')
    
    # Since Transfer needs "From" and "To" accounts we need to name the selects
    # Let's just name the first one from_account_id and second to_account_id
    text = parts[0] + '<!-- Transfer Modal -->' + modal

# 3. Adjustment Modal
parts = text.split('<!-- Adjustment Modal -->')
if len(parts) > 1:
    modal = parts[1]
    
    modal = modal.replace('<form class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">',
                          '<form action="{{ route(\'bank.transaction.adjustment\') }}" method="POST" class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">\n                @csrf')
    
    modal = modal.replace('<input type="number" step="0.01" required placeholder="0.00"', '<input type="number" name="amount" step="0.01" required placeholder="0.00"')
    modal = modal.replace('<input type="date" required value="2026-02-27"', '<input type="date" name="date" required value="{{ date(\'Y-m-d\') }}"')
    modal = modal.replace('<input type="text" required placeholder="e.g. Bank fees, Correction"', '<input type="text" name="reason" required placeholder="e.g. Bank fees, Correction"')
    
    # The Increase/Decrease select
    modal = modal.replace('<select required class="w-full px-3 py-2 bg-white border border-gray-300', '<select name="type" required class="w-full px-3 py-2 bg-white border border-gray-300')
    
    text = parts[0] + '<!-- Adjustment Modal -->' + modal

# Now globally fix all select accounts and category within Withdraw, Transfer, Adjustment modals
# Account select
select_acc = '''<select required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select account...</option>
                                <option>1010-RYD-002 - Al Rajhi Bank (Riyadh Main) - SAR 485,640</option>
                                <option>1010-JED-002 - Al Rajhi Bank (Jeddah) - SAR 342,150</option>
                                <option>1010-DAM-002 - Al Rajhi Bank (Dammam) - SAR 198,420</option>
                                <option>1010-MAK-002 - Al Rajhi Bank (Makkah) - SAR 156,890</option>
                            </select>'''

select_cat_wth = '''<select required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select category...</option>
                                <option>Purchase Payment</option>
                                <option>Operating Expense</option>
                                <option>Payroll</option>
                                <option>Asset Purchase</option>
                                <option>Loan Repayment</option>
                                <option>Other Expense</option>
                            </select>'''

new_select_bank = '''<select name="bank_account_id" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select account...</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} @if($account->bankAccount) ({{ $account->bankAccount->bank_name }}) @endif</option>
                                @endforeach
                            </select>'''

new_select_from = '''<select name="from_account_id" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select From account...</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} @if($account->bankAccount) ({{ $account->bankAccount->bank_name }}) @endif</option>
                                @endforeach
                            </select>'''

new_select_to = '''<select name="to_account_id" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select To account...</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} @if($account->bankAccount) ({{ $account->bankAccount->bank_name }}) @endif</option>
                                @endforeach
                            </select>'''

new_select_cat = '''<select name="category_id" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select category...</option>
                                @foreach($accountCategories as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} ({{ ucfirst($account->category) }})</option>
                                @endforeach
                            </select>'''

text = text.replace(select_cat_wth, new_select_cat)

# Now manually do the banks. 
# Transfer Modal has 2 bank selects in a row.
parts = text.split('<!-- Transfer Modal -->')
if len(parts) > 1:
    modal = parts[1]
    # first select_acc replace with new_select_from
    modal = modal.replace(select_acc, new_select_from, 1)
    # second select_acc replace with new_select_to
    modal = modal.replace(select_acc, new_select_to, 1)
    text = parts[0] + '<!-- Transfer Modal -->' + modal

text = text.replace(select_acc, new_select_bank)

with open(path, 'w', encoding='utf-8') as f:
    f.write(text)
