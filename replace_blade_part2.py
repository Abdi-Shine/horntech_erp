import re

path = r"d:\Bilkheyr\resources\views\frontend\account\Account_management.blade.php"

with open(path, 'r', encoding='utf-8') as f:
    html = f.read()

def replace_selects(content):
    # Fix the Bank Account select
    bank_account_rgx = re.compile(
        r'<select required.*?name=["\']bank_account_id["\'].*?>.*?</select>', re.DOTALL)
    new_bank_select = '''<select name="bank_account_id" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select account...</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} @if($account->bankAccount) ({{ $account->bankAccount->bank_name }}) @endif</option>
                                @endforeach
                            </select>'''
    
    # We don't have name="bank_account_id" yet! Let's just fix the forms first.
    return content

# But wait, the original html forms don't have action attributes and name attributes.
# Deposit Modal Form
html = html.replace('<form class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">', 
                   '<form action="{{ route(\'bank.transaction.deposit\') }}" method="POST" class="p-5 overflow-y-auto custom-scrollbar flex-grow space-y-4 bg-white">\n                @csrf')

# The fields inside Deposit Modal:
# Bank Account select
html = re.sub(r'<select required.*?<option>1010-RYD-002.*?</select>', 
              '''<select name="bank_account_id" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select account...</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} @if($account->bankAccount) ({{ $account->bankAccount->bank_name }}) @endif</option>
                                @endforeach
                            </select>''', html, flags=re.DOTALL)

# Inputs in Deposit
html = html.replace('<input type="number" step="0.01" required placeholder="0.00"', '<input type="number" step="0.01" name="amount" required placeholder="0.00"')
html = html.replace('<input type="date" required value="2026-02-27"', '<input type="date" name="date" required value="{{ date(\'Y-m-d\') }}"')
html = html.replace('<input type="text" required placeholder="Customer/Company name"', '<input type="text" name="received_from" required placeholder="Customer/Company name"')
html = html.replace('<textarea rows="3" placeholder="Additional details..."', '<textarea rows="3" name="notes" placeholder="Additional details..."')

# Category Select
html = re.sub(r'<select required.*?<option>Sales Revenue.*?</select>', 
              '''<select name="category_id" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-xs font-bold text-gray-700 appearance-none cursor-pointer">
                                <option value="">Select category...</option>
                                @foreach($accountCategories as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} ({{ ucfirst($account->category) }})</option>
                                @endforeach
                            </select>''', html, flags=re.DOTALL)

with open(path, 'w', encoding='utf-8') as f:
    f.write(html)
