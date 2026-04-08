import sys

path = r"d:\Horntech\resources\views\admin\body\sidebar.blade.php"
with open(path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

# Look for Company::first()
new_lines = []
skip = 0
for i, line in enumerate(lines):
    if skip > 0:
        skip -= 1
        continue
    if "App\Models\Company::first()" in line and i > 0 and "@php" in lines[i-1]:
        # We found it! Remove previous line (@php), current line, and next line (@endphp)
        new_lines.pop() # Remove @php
        skip = 1 # Skip @endphp
        continue
    new_lines.append(line)

with open(path, 'w', encoding='utf-8') as f:
    f.writelines(new_lines)

print("Done")
