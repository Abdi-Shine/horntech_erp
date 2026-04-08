@extends('admin.admin_master')
@section('page_title', 'Generate Payroll')



@section('admin')
<div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen" x-data="payrollGenerator()">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <div>
            <h1 class="text-[20px] font-bold text-primary-dark">Generate Payroll</h1>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-1">Salary Computation</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('payroll.index') }}" 
                class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-[0.5rem] hover:bg-gray-50 transition-all shadow-sm text-sm">
                <i class="bi bi-arrow-left"></i>
                Back to List
            </a>
            <button @click="submitForm" :disabled="items.length === 0"
                class="flex items-center gap-2 px-6 py-2.5 bg-accent text-primary font-black rounded-[0.5rem] hover:bg-accent transition-all shadow-sm text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="bi bi-check2-circle text-lg"></i>
                Generate Official Payroll
            </button>
        </div>
    </div>

    <form id="payrollForm" action="{{ route('payroll.store') }}" method="POST">
        @csrf
        
        <!-- Selection Bar -->
        <div class="bg-white rounded-[1rem] border border-gray-100 p-5 shadow-sm mb-6 flex flex-wrap gap-6 items-end">
            <div class="space-y-1.5 min-w-[200px]">
                <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Select Month/Year <span class="text-primary">*</span></label>
                <input type="month" name="month_year" x-model="month_year" required
                    class="w-full px-4 py-2.5 bg-gray-50 border border-transparent rounded-[0.5rem] text-xs font-bold text-primary-dark focus:bg-white focus:border-primary outline-none transition-all">
            </div>

            <div class="space-y-1.5 min-w-[220px]">
                <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Target Branch</label>
                <div class="relative">
                    <select name="branch_id" x-model="branch_id" @change="filterEmployees"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-transparent rounded-[0.5rem] text-xs font-bold text-primary-dark focus:bg-white focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[10px]"></i>
                </div>
            </div>

            <div class="ml-auto flex items-center gap-6">
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Total Net Payable</p>
                    <h2 class="text-[20px] font-black text-primary">{{ $currency }} <span x-text="formatNumber(totalNet)"></span></h2>
                </div>
            </div>
        </div>

        <!-- Payroll Table -->
        <div class="bg-white rounded-[1rem] border border-gray-200/80 shadow-sm overflow-hidden mb-6">
            <div class="px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50">
                <i class="bi bi-people-fill text-primary-dark text-sm"></i>
                <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">Employee List & Salary Breakdown</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider w-12 text-center">#</th>
                            <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider">Employee</th>
                            <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">Basic Salary</th>
                            <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">Bonus</th>
                            <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">Overtime</th>
                            <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">Deductions</th>
                            <th class="px-5 py-4 text-[11px] font-black text-primary-dark uppercase tracking-wider text-right">Net Payable</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(item, index) in items" :key="item.employee_id">
                            <tr class="hover:bg-gray-50/40 transition-colors">
                                <td class="px-5 py-4 text-xs font-black text-primary/40 text-center" x-text="(index+1).toString().padStart(2,'0')"></td>
                                <input type="hidden" :name="'items['+index+'][employee_id]'" :value="item.employee_id">
                                <input type="hidden" :name="'items['+index+'][gross_salary]'" :value="item.gross_salary">
                                <input type="hidden" :name="'items['+index+'][net_salary]'" :value="item.net_salary">
                                
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary/5 border border-primary/10 flex items-center justify-center text-primary font-bold text-[10px]" x-text="item.name.charAt(0)"></div>
                                        <div>
                                            <p class="text-xs font-bold text-primary-dark leading-tight" x-text="item.name"></p>
                                            <p class="text-[10px] text-gray-400 font-medium mt-0.5" x-text="item.designation || 'Staff'"></p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <input type="number" step="0.01" :name="'items['+index+'][basic_salary]'" x-model.number="item.basic_salary" @input="calculateTotals(item)"
                                        class="w-24 px-3 py-2 bg-gray-50 border border-transparent rounded-md text-xs font-bold text-right text-primary-dark focus:bg-white focus:border-primary outline-none transition-all input-no-spinner">
                                </td>

                                <td class="px-5 py-4">
                                    <input type="number" step="0.01" :name="'items['+index+'][bonus]'" x-model.number="item.bonus" @input="calculateTotals(item)"
                                        class="w-24 px-3 py-2 bg-gray-50 border border-transparent rounded-md text-xs font-bold text-right text-accent focus:bg-white focus:border-primary outline-none transition-all input-no-spinner">
                                </td>

                                <td class="px-5 py-4">
                                    <input type="number" step="0.01" :name="'items['+index+'][overtime]'" x-model.number="item.overtime" @input="calculateTotals(item)"
                                        class="w-24 px-3 py-2 bg-gray-50 border border-transparent rounded-md text-xs font-bold text-right text-primary focus:bg-white focus:border-primary outline-none transition-all input-no-spinner">
                                </td>

                                <td class="px-5 py-4">
                                    <input type="number" step="0.01" :name="'items['+index+'][deductions]'" x-model.number="item.deductions" @input="calculateTotals(item)"
                                        class="w-24 px-3 py-2 bg-gray-50 border border-transparent rounded-md text-xs font-bold text-right text-primary focus:bg-white focus:border-primary outline-none transition-all input-no-spinner">
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <span class="text-xs font-black text-primary-dark" x-text="'$ ' + formatNumber(item.net_salary)"></span>
                                </td>
                            </tr>
                        </template>
                        <template x-if="items.length === 0">
                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-300">
                                            <i class="bi bi-person-x text-xl"></i>
                                        </div>
                                        <p class="text-[13px] font-bold text-gray-400 uppercase tracking-widest">Select branch or ensure employees are active</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function payrollGenerator() {
        return {
            month_year: '{{ now()->format('Y-m') }}',
            branch_id: '',
            employees: @json($employees),
            items: [],
            totalNet: 0,

            init() {
                this.filterEmployees();
            },

            filterEmployees() {
                const branchVal = this.branch_id;
                // Since employees branch field might be string (branch name from migration) or id... 
                // In your Employee module it seems to be string 'branch'. 
                // But branches table exists. Let's try to match by name if possible or just show all if no branch selected.
                // Assuming $employees passed from controller contains all active.
                
                this.items = this.employees.map(emp => ({
                    employee_id: emp.id,
                    name: emp.full_name,
                    designation: emp.designation,
                    basic_salary: parseFloat(emp.salary) || 0,
                    bonus: 0,
                    overtime: 0,
                    deductions: 0,
                    gross_salary: parseFloat(emp.salary) || 0,
                    net_salary: parseFloat(emp.salary) || 0,
                    branch_name: emp.branch
                }));

                // If branch filter is active, filter items
                if (branchVal) {
                    // find branch name
                    const branchName = document.querySelector('select[name="branch_id"] option:checked').text;
                    this.items = this.items.filter(i => i.branch_name === branchName);
                }

                this.recalculateTotalNet();
            },

            calculateTotals(item) {
                item.gross_salary = (item.basic_salary || 0) + (item.bonus || 0) + (item.overtime || 0);
                item.net_salary = item.gross_salary - (item.deductions || 0);
                this.recalculateTotalNet();
            },

            recalculateTotalNet() {
                this.totalNet = this.items.reduce((sum, item) => sum + (item.net_salary || 0), 0);
            },

            formatNumber(num) {
                return parseFloat(num).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            },

            submitForm() {
                if (!this.month_year) {
                    Swal.fire('Error', 'Please select a Month/Year.', 'error');
                    return;
                }
                Swal.fire({
                    title: 'Generate Payroll?',
                    text: 'This will create official salary records for the selected month.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#004161',
                    confirmButtonText: 'Yes, Generate!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('payrollForm').submit();
                    }
                });
            }
        }
    }
</script>
@endpush


