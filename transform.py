import sys
import re

file_path = 'd:/Bilkheyr/resources/views/frontend/expense/add_all_expenses.blade.php'

# read original from backup
with open(file_path + '.backup', 'r', encoding='utf-8') as f:
    content = f.read()

# Extract styles
style_match = re.search(r'<style>(.*?)</style>', content, re.DOTALL)
styles = style_match.group(1) if style_match else ''
styles = re.sub(r'\* \{.*?\}', '', styles, flags=re.DOTALL)
styles = re.sub(r'body \{.*?\}', '', styles, flags=re.DOTALL)

# Extract Main Container until end of body
main_match = re.search(r'(<!-- Main Container -->.*?<!-- Bootstrap 5 JS -->)', content, re.DOTALL)
main_content = main_match.group(1) if main_match else ''
main_content = main_content.replace('<!-- Bootstrap 5 JS -->', '')

# Extract scripts
script_match = re.search(r'<!-- Bootstrap 5 JS -->(.*?)</body', content, re.DOTALL)
scripts = script_match.group(1) if script_match else ''

new_content = f"""@extends('admin.admin_master')

@push('css')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
{styles}    </style>
@endpush

@section('admin')
{main_content}
@endsection

@push('scripts')
    <!-- Bootstrap 5 JS -->
{scripts}
@endpush
"""

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(new_content)
