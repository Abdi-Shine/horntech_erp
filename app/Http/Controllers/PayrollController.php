<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Employee;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    private function currencySymbol(): string
    {
        $company = Company::find(Auth::user()->company_id);
        $map = ['SAR' => '﷼', 'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'AED' => 'د.إ', 'KWD' => 'د.ك'];
        return $map[$company->currency ?? ''] ?? ($company->currency ?? '$');
    }

    public function index()
    {
        $payrolls = Payroll::with(['branch', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        $branches = Branch::all();
        $currency = $this->currencySymbol();

        return view('frontend.expense.payroll_list', compact('payrolls', 'branches', 'currency'));
    }

    public function create()
    {
        $branches  = Branch::all();
        $employees = Employee::where('status', 'active')->get();
        $currency  = $this->currencySymbol();

        return view('frontend.expense.payroll_generate', compact('branches', 'employees', 'currency'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month_year'              => 'required|string',
            'branch_id'               => 'nullable|exists:branches,id',
            'items'                   => 'required|array',
            'items.*.employee_id'     => 'required|exists:employees,id',
        ]);

        try {
            DB::beginTransaction();

            $cid           = Auth::user()->company_id;
            $totalGross    = 0;
            $totalDeductions = 0;
            $totalNet      = 0;

            foreach ($request->items as $item) {
                $totalGross      += $item['gross_salary'] ?? 0;
                $totalDeductions += $item['deductions']   ?? 0;
                $totalNet        += $item['net_salary']   ?? 0;
            }

            $payroll = Payroll::create([
                'month_year'       => $request->month_year,
                'branch_id'        => $request->branch_id,
                'total_employees'  => count($request->items),
                'total_gross'      => $totalGross,
                'total_deductions' => $totalDeductions,
                'total_net'        => $totalNet,
                'status'           => 'Draft',
                'company_id'       => $cid,
            ]);

            foreach ($request->items as $item) {
                PayrollItem::create([
                    'payroll_id'   => $payroll->id,
                    'employee_id'  => $item['employee_id'],
                    'basic_salary' => $item['basic_salary'] ?? 0,
                    'bonus'        => $item['bonus']        ?? 0,
                    'overtime'     => $item['overtime']     ?? 0,
                    'deductions'   => $item['deductions']   ?? 0,
                    'gross_salary' => $item['gross_salary'] ?? 0,
                    'net_salary'   => $item['net_salary']   ?? 0,
                ]);
            }

            // Journal Entry on Draft creation:
            // Dr Salaries Expense = total_gross
            //   Cr Salaries Payable    = total_net
            //   Cr Deductions Payable  = total_deductions (if > 0)
            $salaryExpenseAccount = Account::query()
                ->where('company_id', $cid)
                ->where('category', 'expenses')
                ->where(function ($q) {
                    $q->where('code', '5210')
                      ->orWhere('code', '5100')
                      ->orWhere('name', 'like', '%Salaries%')
                      ->orWhere('name', 'like', '%Salary%')
                      ->orWhere('name', 'like', '%Wages%');
                })
                ->first();

            $salariesPayableAccount = Account::query()
                ->where('company_id', $cid)
                ->where(function ($q) {
                    $q->where('code', '2140')
                      ->orWhere('code', '2200')
                      ->orWhere('name', 'like', '%Accrued Salaries%')
                      ->orWhere('name', 'like', '%Salaries Payable%')
                      ->orWhere('name', 'like', '%Wages Payable%');
                })
                ->first();

            $deductionsPayableAccount = Account::query()
                ->where('company_id', $cid)
                ->where(function ($q) {
                    $q->where('code', '2210')
                      ->orWhere('name', 'like', '%Deductions Payable%')
                      ->orWhere('name', 'like', '%Payroll Deductions%');
                })
                ->first();

            if ($salaryExpenseAccount && $salariesPayableAccount) {
                $entry = JournalEntry::query()->create([
                    'entry_number' => 'JE-PR-' . date('Ymd') . '-' . str_pad($payroll->id, 5, '0', STR_PAD_LEFT),
                    'date'         => now()->toDateString(),
                    'reference'    => 'PAY-' . $payroll->id,
                    'description'  => 'Payroll: ' . $payroll->month_year,
                    'status'       => 'posted',
                    'total_amount' => $totalGross,
                    'company_id'   => $cid,
                    'created_by'   => Auth::id(),
                    'branch_id'    => $request->branch_id,
                ]);

                // Dr Salaries Expense = total_gross
                JournalItem::query()->create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $salaryExpenseAccount->id,
                    'company_id'       => $cid,
                    'description'      => 'Payroll expense ' . $payroll->month_year,
                    'debit'            => $totalGross,
                    'credit'           => 0,
                ]);

                // Cr Salaries Payable = total_net
                JournalItem::query()->create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $salariesPayableAccount->id,
                    'company_id'       => $cid,
                    'description'      => 'Net salaries payable ' . $payroll->month_year,
                    'debit'            => 0,
                    'credit'           => $totalNet,
                ]);

                // Cr Deductions Payable = total_deductions (if account exists and deductions > 0)
                if ($totalDeductions > 0 && $deductionsPayableAccount) {
                    JournalItem::query()->create([
                        'journal_entry_id' => $entry->id,
                        'account_id'       => $deductionsPayableAccount->id,
                        'company_id'       => $cid,
                        'description'      => 'Payroll deductions payable ' . $payroll->month_year,
                        'debit'            => 0,
                        'credit'           => $totalDeductions,
                    ]);
                } elseif ($totalDeductions > 0) {
                    // Fallback: add deductions to salaries payable credit
                    JournalItem::query()->create([
                        'journal_entry_id' => $entry->id,
                        'account_id'       => $salariesPayableAccount->id,
                        'company_id'       => $cid,
                        'description'      => 'Payroll deductions ' . $payroll->month_year,
                        'debit'            => 0,
                        'credit'           => $totalDeductions,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('payroll.index')->with('success', 'Payroll generated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error generating payroll: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $payroll  = Payroll::with(['items.employee', 'branch', 'approvedBy'])->findOrFail($id);
        $currency = $this->currencySymbol();

        return view('frontend.expense.payroll_detail', compact('payroll', 'currency'));
    }

    public function approve($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->update([
            'status'      => 'Approved',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Payroll approved successfully.');
    }

    public function markAsPaid($id)
    {
        try {
            DB::beginTransaction();

            $payroll = Payroll::with('items')->findOrFail($id);
            $cid     = Auth::user()->company_id;

            $payroll->update([
                'status'    => 'Paid',
                'paid_date' => now(),
            ]);

            $payroll->items()->update(['status' => 'Paid', 'payment_date' => now()]);

            // Prefer Cash on Hand (1110), then any cash type, then bank
            $cashAccount = Account::query()
                ->where('company_id', $cid)
                ->where('category', 'assets')
                ->where(function ($q) {
                    $q->where('code', '1110')
                      ->orWhere('type', 'cash')
                      ->orWhere('type', 'bank')
                      ->orWhere('name', 'like', '%Cash on Hand%')
                      ->orWhere('name', 'like', '%Cash%');
                })
                ->orderByRaw("CASE WHEN code = '1110' THEN 0 WHEN type = 'cash' THEN 1 WHEN type = 'bank' THEN 2 ELSE 3 END")
                ->first();

            // Debit side: Salaries Payable if exists, else Salary Expense
            $debitAccount = Account::query()
                ->where('company_id', $cid)
                ->where(function ($q) {
                    $q->where('code', '2140')
                      ->orWhere('code', '2200')
                      ->orWhere('name', 'like', '%Accrued Salaries%')
                      ->orWhere('name', 'like', '%Salaries Payable%')
                      ->orWhere('name', 'like', '%Wages Payable%');
                })
                ->first();

            // Fallback: use salary expense account directly
            if (!$debitAccount) {
                $debitAccount = Account::query()
                    ->where('company_id', $cid)
                    ->where('category', 'expenses')
                    ->where(function ($q) {
                        $q->where('code', '5210')
                          ->orWhere('name', 'like', '%Salaries%')
                          ->orWhere('name', 'like', '%Wages%');
                    })
                    ->first();
            }

            if ($debitAccount && $cashAccount) {
                $entry = JournalEntry::query()->create([
                    'entry_number' => 'JE-PP-' . date('Ymd') . '-' . str_pad($payroll->id, 5, '0', STR_PAD_LEFT),
                    'date'         => now()->toDateString(),
                    'reference'    => 'PAY-PAID-' . $payroll->id,
                    'description'  => 'Payroll payment: ' . $payroll->month_year,
                    'status'       => 'posted',
                    'total_amount' => $payroll->total_net,
                    'company_id'   => $cid,
                    'created_by'   => Auth::id(),
                ]);

                // Dr Salaries Payable (or Salary Expense) = total_net
                JournalItem::query()->create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $debitAccount->id,
                    'company_id'       => $cid,
                    'description'      => 'Payroll payment ' . $payroll->month_year,
                    'debit'            => $payroll->total_net,
                    'credit'           => 0,
                ]);

                // Cr Cash on Hand = total_net
                JournalItem::query()->create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $cashAccount->id,
                    'company_id'       => $cid,
                    'description'      => 'Payroll payment ' . $payroll->month_year,
                    'debit'            => 0,
                    'credit'           => $payroll->total_net,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Payroll marked as paid.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error marking payroll as paid: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $payroll = Payroll::findOrFail($id);

            if ($payroll->status == 'Paid') {
                return back()->with('error', 'Cannot delete a paid payroll.');
            }

            // Reverse journal entries if they exist
            $entry = JournalEntry::query()->where('reference', 'PAY-' . $payroll->id)->first();
            if ($entry) {
                foreach ($entry->items as $item) {
                    $item->delete();
                }
                $entry->delete();
            }

            $payroll->delete();

            DB::commit();
            return back()->with('success', 'Payroll deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting payroll: ' . $e->getMessage());
        }
    }
}
