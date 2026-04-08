@extends('admin.admin_master')
@section('page_title', 'Payroll Detail')



@section('admin')
<div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen no-print">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <div>
            <h1 class="text-[20px] font-bold text-primary-dark">Payroll Detail: {{ $payroll->month_year }}</h1>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-1">Status: {{ $payroll->status }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('payroll.index') }}" 
                class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-[0.5rem] hover:bg-gray-50 transition-all shadow-sm text-sm">
                <i class="bi bi-arrow-left"></i>
                Back to List
            </a>
            <button onclick="window.print()"
                class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-semibold rounded-[0.5rem] hover:bg-primary/90 transition-all shadow-sm text-sm">
                <i class="bi bi-printer"></i>
                Print Payslips
            </button>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total Staff</p>
            <h3 class="text-[18px] font-black text-primary">{{ $payroll->total_employees }}</h3>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-1">Gross Total</p>
            <h3 class="text-[18px] font-black text-primary">{{ $currency }} {{ number_format($payroll->total_gross, 2) }}</h3>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-1">Deductions</p>
            <h3 class="text-[18px] font-black text-primary">{{ $currency }} {{ number_format($payroll->total_deductions, 2) }}</h3>
        </div>
        <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-1">Net Payout</p>
            <h3 class="text-[18px] font-black text-accent">{{ $currency }} {{ number_format($payroll->total_net, 2) }}</h3>
        </div>
    </div>

    <!-- Detailed Breakdowns -->
    <div class="bg-white rounded-[1rem] border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">Salary Disbursement Report</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider">Employee</th>
                        <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">Basic</th>
                        <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">Bonus</th>
                        <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">OT</th>
                        <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right text-primary">Deductions</th>
                        <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">Net Payable</th>
                        <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($payroll->items as $item)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-5 py-4">
                                <p class="text-xs font-bold text-primary-dark">{{ $item->employee->full_name }}</p>
                                <p class="text-[10px] text-gray-400 font-medium">{{ $item->employee->designation }}</p>
                            </td>
                            <td class="px-5 py-4 text-right text-xs font-bold">{{ number_format($item->basic_salary, 2) }}</td>
                            <td class="px-5 py-4 text-right text-xs font-bold text-accent">{{ number_format($item->bonus, 2) }}</td>
                            <td class="px-5 py-4 text-right text-xs font-bold text-primary">{{ number_format($item->overtime, 2) }}</td>
                            <td class="px-5 py-4 text-right text-xs font-bold text-primary">{{ number_format($item->deductions, 2) }}</td>
                            <td class="px-5 py-4 text-right text-xs font-black text-primary-dark">{{ $currency }} {{ number_format($item->net_salary, 2) }}</td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded border {{ $item->status == 'Paid' ? 'bg-accent/10 text-accent border-accent/20' : 'bg-primary/10 text-primary border-primary/20' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Print Version Payload (Payslips) -->
<div class="print-only">
    @foreach($payroll->items as $item)
        <div class="payslip-container p-10 border-2 border-gray-400 m-4 rounded-xl mb-20">
            <h1 class="text-2xl font-black text-center mb-6">Payslip - {{ $payroll->month_year }}</h1>
            <div class="grid grid-cols-2 gap-10 mb-8 border-b pb-8">
                <div>
                    <p class="text-sm font-bold text-gray-400 uppercase">Employee Details</p>
                    <p class="text-lg font-black">{{ $item->employee->full_name }}</p>
                    <p class="text-md">{{ $item->employee->designation }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-400 uppercase">Payroll Status</p>
                    <p class="text-lg font-black uppercase text-primary">{{ $payroll->status }}</p>
                    <p class="text-md font-bold">Paid on: {{ $payroll->paid_date ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-bold">Basic Salary</p>
                    <p class="text-lg font-black">{{ $currency }} {{ number_format($item->basic_salary, 2) }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-bold">Bonus & OT</p>
                    <p class="text-lg font-black text-accent">{{ $currency }} {{ number_format($item->bonus + $item->overtime, 2) }}</p>
                </div>
                <div class="bg-primary/10 p-4 rounded-lg">
                    <p class="text-sm font-bold">Total Deductions</p>
                    <p class="text-lg font-black text-primary">{{ $currency }} {{ number_format($item->deductions, 2) }}</p>
                </div>
                <div class="bg-primary p-4 rounded-lg text-white">
                    <p class="text-sm font-bold">NET SALARY</p>
                    <p class="text-2xl font-black">{{ $currency }} {{ number_format($item->net_salary, 2) }}</p>
                </div>
            </div>
            <div class="mt-20 flex justify-between">
                <div class="border-t border-black px-10 pt-2 text-sm font-bold">Employee Signature</div>
                <div class="border-t border-black px-10 pt-2 text-sm font-bold">Authorized Signatory</div>
            </div>
        </div>
        <div class="page-break page-break-after-always"></div>
    @endforeach
</div>
@endsection


