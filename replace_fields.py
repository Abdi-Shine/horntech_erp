import re

path = r'd:\Bilkheyr\resources\views\frontend\account\Account_management.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    text = f.read()

parts = text.split('<!-- Deposit Modal -->')
pre_modals = parts[0]
modals = '<!-- Deposit Modal -->' + parts[1]

# 1. Update Section Headers
def replace_header(match):
    icon = match.group(1)
    # Some older icons have 'text-secondary mr-2', so we strip classes and just get the icon name
    icon_match = re.search(r'bi-[\w-]+', icon)
    icon_name = icon_match.group(0) if icon_match else 'bi-bank2'
    
    title = match.group(2).strip()
    
    return f'''<div class="p-4 bg-gray-50/50 border border-gray-200 rounded-xl space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-primary/10 rounded-md flex items-center justify-center">
                            <i class="bi {icon_name} text-primary text-[10px]"></i>
                        </div>
                        <span class="text-[10px] font-black text-primary-dark uppercase tracking-widest">{title}</span>
                    </div>'''

modals = re.sub(
    r'<div>\s*<h3 class="text-lg font-display font-bold text-primary mb-4 flex items-center">\s*(<i class="bi [^"]+"></i>)\s*([^<]+)\s*</h3>',
    replace_header,
    modals
)


# 2. Update grid gaps from gap-4 to gap-3
modals = modals.replace('grid md:grid-cols-2 gap-4', 'grid grid-cols-1 md:grid-cols-2 gap-3 pt-2')

# 3. Update all divs holding inputs to have space-y-1.5 for label spacing
modals = re.sub(r'<div>\s*<label', r'<div class="space-y-1.5">\n                            <label', modals)
modals = re.sub(r'<div class="md:col-span-2">\s*<label', r'<div class="md:col-span-2 space-y-1.5">\n                            <label', modals)

# 4. Update Labels
modals = re.sub(
    r'<label class="block text-xs font-bold text-gray-600 uppercase mb-2">([^<]*?)<span class="text-red-500">',
    r'<label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">\1<span class="text-rose-500">',
    modals
)

modals = re.sub(
    r'<label class="block text-xs font-bold text-gray-600 uppercase mb-2">([^<]*?)</label>',
    r'<label class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">\1</label>',
    modals
)

# 5. Update Inputs and Selects styling
# The existing inputs look like: `w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium`
# Or have specific variations. Let's do a targeted replace for their common classes.

modals = re.sub(r'px-4 py-3 border-2', 'px-3 py-2 bg-white border', modals)
modals = re.sub(r'font-medium', 'text-xs font-bold text-gray-700', modals)

# Specifically for <select> blocks we can add appearance-none cursor-pointer
modals = re.sub(r'<select(.*?)class="(.*?)"(.*?)>', r'<select\1class="\2 appearance-none cursor-pointer"\3>', modals)

# Specifically for readonly inputs (like current balance)
modals = re.sub(r'bg-gray-50 font-bold text-lg', 'bg-gray-50 text-xs font-bold text-gray-700', modals)


# 6. Apply Accounting Preview specific changes
# They were previously: `<div class="bg-gray-50 rounded-lg border-2 border-gray-200 p-4">`
# Change to match the new grey wrapper: `<div class="p-4 bg-gray-50/50 border border-gray-200 rounded-xl space-y-3">`
# And header for it:
def replace_preview_header(match):
    title = match.group(1).strip()
    return f'''<div class="flex items-center gap-2 mb-2">
                        <div class="w-6 h-6 bg-primary/10 rounded-md flex items-center justify-center">
                            <i class="bi bi-calculator text-primary text-[10px]"></i>
                        </div>
                        <span class="text-[10px] font-black text-primary-dark uppercase tracking-widest">{title}</span>
                    </div>'''

modals = re.sub(
    r'<div class="bg-gray-50 rounded-lg border-2 border-gray-200 p-4">\s*<h4 class="text-sm font-bold text-primary mb-3 flex items-center gap-2">\s*<i class="bi bi-calculator"></i>\s*([^<]+)\s*</h4>',
    lambda m: '<div class="p-4 bg-gray-50/50 border border-gray-200 rounded-xl space-y-2">\n                    ' + replace_preview_header(m),
    modals
)

# Ensure inner rows in preview use appropriate spacing
modals = re.sub(r'<div class="flex justify-between items-center p-2 bg-white rounded">', '<div class="flex justify-between items-center p-2 border border-gray-100 bg-white rounded-lg text-xs">', modals)
modals = re.sub(r'<div class="flex justify-between items-center p-3 bg-white rounded">', '<div class="flex justify-between items-center p-2 border border-gray-100 bg-white rounded-lg text-xs">', modals)
modals = re.sub(r'<div class="flex justify-between items-center p-3 bg-primary/10 rounded">', '<div class="flex justify-between items-center p-3 border border-primary/20 bg-primary/10 rounded-lg text-xs mt-2">', modals)

# 7. Update the Warning Box format
modals = re.sub(r'<div class="bg-red-50 rounded-lg border-2 border-red-200 p-4">', '<div class="bg-rose-50 rounded-xl border border-rose-100 p-4">', modals)
modals = re.sub(r'text-red-600', 'text-rose-500', modals)
modals = re.sub(r'text-red-800', 'text-rose-800', modals)

# 8. Button font sizes in the footer
modals = re.sub(r'text-sm shadow-sm">', 'text-xs shadow-sm">', modals)

with open(path, 'w', encoding='utf-8') as f:
    f.write(pre_modals + modals)

print("Modal contents successfully normalized to branding model.")
