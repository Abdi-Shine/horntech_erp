import re

with open('resources/views/frontend/report/Parties_Statement_reports_bak.blade.php', 'r', encoding='utf-8') as f:
    html = f.read()

css_match = re.search(r'<style>(.*?)</style>', html, re.DOTALL)
css = css_match.group(1) if css_match else ''
css_lines = []
for line in css.split('\n'):
    if any(cls in line for cls in ['.sidebar', '.header', '.user', '.main-content', '@media (max-width', 'body {']):
        continue
    css_lines.append(line)

main_content_match = re.search(r'<main class="main-content">(.*?)</main>', html, re.DOTALL)
main_content = main_content_match.group(1) if main_content_match else ''

blade_content = f"""@extends('admin.admin_master')

@push('css')
<style>
{chr(10).join(css_lines)}
</style>
@endpush

@section('admin')
<div class="page-content">
{main_content}
</div>
@endsection
"""

with open('resources/views/frontend/report/Parties_Statement_reports.blade.php', 'w', encoding='utf-8') as f:
    f.write(blade_content)
