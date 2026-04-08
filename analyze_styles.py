import os
import re

directory = r'd:\Bilkheyr\resources\views\frontend'
files_to_check = [
    r'd:\Bilkheyr\resources\views\frontend\subscribers\plans_pricing.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\setting\capital_deposit.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\setting\backup_restore.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\sales\sales_pos.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\sales\sales_invoice.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\sales\sales_edit.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\sales\add_invoice_sales.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\transaction_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\summary_stock_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\stock_details_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\sale_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\sale_purchase_item_category_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\sale_purchase_by_party_group_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\sales_purchase_by_party_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\purchase_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\profit_loss_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Parties_Statement_reports_bak.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\party_wise_profit_Loss_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Parties_Statement_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Item_wise_profit_Loss_report.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Low_stock_summary_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Item_wise_discount_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Item_report_by_party.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Item_details_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Item_category_wise_profit_loss_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\expense_item_report.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\expense_category_report.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\bill_wise_profit_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\Balance_sheet_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\cash_flow_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\report\all_parties_reports.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\purchase\edit_purchase_bill.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\purchase\purchase_bill.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\purchase\purchase_order.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\purchase\purchase_return.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\purchase\purchase_expenses.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\expense\cash_loan.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\expense\payroll_generate.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\expense\payroll_list.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\expense\payroll_detail.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\dashboard\store_performance_dashboard.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\dashboard\sales_analytics_dashboard.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\dashboard\inventory_overview_dashboard.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\branch\cash_management.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\dashboard\financial_snapshot_dashboard.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\dashboard\company_overview_dashboard.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\branch\branches.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\branch\branch_store_transfer.blade.php',
    r'd:\Bilkheyr\resources\views\frontend\dashboard\branch_performance_dashboard.blade.php'
]

# Patterns to match common redundant styles
redundant_patterns = [
    r'\[x-cloak\]\s*{\s*display:\s*none\s*!important;\s*}',
    r'\.custom-scrollbar::-webkit-scrollbar\s*{\s*width:\s*6px;\s*height:\s*6px;\s*}',
    r'\.custom-scrollbar::-webkit-scrollbar-track\s*{\s*background:\s*transparent;\s*}',
    r'\.custom-scrollbar::-webkit-scrollbar-thumb\s*{\s*background:\s*rgba\(0,\s*65,\s*97,\s*0\.15\);\s*border-radius:\s*10px;\s*}',
    r'\.custom-scrollbar::-webkit-scrollbar-thumb:hover\s*{\s*background:\s*rgba\(0,\s*65,\s*97,\s*0\.3\);\s*}',
    r'.no-print\s*{\s*@media\s*print\s*{\s*display:\s*none\s*!important;\s*}\s*}',
    r'\.report-card-hover\s*{\s*transition:\s*all\s*0\.3s\s*ease;\s*}',
    r'\.report-card-hover:hover\s*{\s*transform:\s*translateY\(-5px\);\s*box-shadow:\s*0\s*15px\s*30px\s*-10px\s*rgba\(0,\s*65,\s*97,\s*0\.15\);\s*border-color:\s*#99CC33;\s*}'
]

results = []

for file_path in files_to_check:
    if not os.path.exists(file_path):
        continue
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
        
    style_blocks = re.findall(r'<style>(.*?)<\/style>', content, re.DOTALL)
    if not style_blocks:
        continue
        
    for block in style_blocks:
        cleaned_block = block.strip()
        is_cleanable = True
        
        # Check if the block ONLY contains redundant patterns
        temp_block = cleaned_block
        for pattern in redundant_patterns:
            temp_block = re.sub(pattern, '', temp_block, flags=re.DOTALL).strip()
            
        if temp_block:
            results.append(f"UNIQUE: {file_path}")
            # print(f"UNIQUE CONTENT IN {file_path}:\n{temp_block}\n---")
        else:
            results.append(f"REDUNDANT: {file_path}")

for res in results:
    print(res)
