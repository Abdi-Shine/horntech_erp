<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivatedMail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:200'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => ['required', 'string', 'max:255', 'unique:companies,name'],
        ]);

        // Create a new company (tenant) for this registrant
        $company = \App\Models\Company::create([
            'name'                => $request->company_name,
            'industry'            => $request->industry,
            'employee_count'      => $request->company_size,
            'vat_number'          => $request->vat_number,
            'registration_number' => $request->cr_number,
            'address'             => $request->address,
            'city'                => $request->city,
            'country'             => $request->country ?: 'Saudi Arabia',
            'postal_code'         => $request->postal_code,
        ]);

        // Use withoutGlobalScopes because the user is not authenticated yet,
        // so the BelongsToTenant creating hook cannot auto-assign company_id.
        // We also set email_verified_at immediately so the company admin can
        // access the dashboard right away without an email verification wall.
        $user = User::withoutGlobalScopes()->create([
            'name'              => $request->name,
            'fullname'          => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => 'admin',
            'company_id'        => $company->id,
            'email_verified_at' => now(),
        ]);

        // Send customized activation email with credentials
        Mail::to($user->email)->send(new AccountActivatedMail(
            $company->name,
            $user->email,
            $request->password
        ));

        // Seed default roles for this company so the admin can assign them to staff
        $allActions = ['view', 'create', 'edit', 'delete'];
        $modules = [
            'Dashboard', 'Sales & POS', 'Customers', 'Suppliers',
            'Products', 'Purchases', 'Accounting', 'HR',
            'Reports', 'Settings',
        ];
        $fullPermissions = array_fill_keys($modules, $allActions);
        $viewOnlyPermissions = array_fill_keys($modules, ['view']);

        $defaultRoles = [
            ['name' => 'Manager',   'description' => 'Full access to all modules',       'permissions' => $fullPermissions],
            ['name' => 'Cashier',   'description' => 'Sales and POS access',              'permissions' => array_fill_keys(['Dashboard', 'Sales & POS', 'Customers', 'Products'], $allActions)],
            ['name' => 'Accountant','description' => 'Accounting and reports access',     'permissions' => array_fill_keys(['Dashboard', 'Accounting', 'Reports'], $allActions)],
            ['name' => 'Staff',     'description' => 'View-only access to all modules',   'permissions' => $viewOnlyPermissions],
        ];

        foreach ($defaultRoles as $roleData) {
            \App\Models\Role::withoutGlobalScopes()->create(array_merge($roleData, [
                'company_id' => $company->id,
            ]));
        }

        // Seed default feature flags for this company
        $defaultFeatures = [
            ['feature_key' => 'pos',              'category' => 'sales',     'title' => 'POS System',              'is_enabled' => true],
            ['feature_key' => 'invoice',          'category' => 'sales',     'title' => 'Invoice Generation',      'is_enabled' => true],
            ['feature_key' => 'returns',          'category' => 'sales',     'title' => 'Sales Returns',           'is_enabled' => true],
            ['feature_key' => 'multibranch',      'category' => 'inventory', 'title' => 'Multi-Branch Support',    'is_enabled' => true],
            ['feature_key' => 'transfers',        'category' => 'inventory', 'title' => 'Stock Transfers',         'is_enabled' => true],
            ['feature_key' => 'adjustments',      'category' => 'inventory', 'title' => 'Stock Adjustments',       'is_enabled' => true],
            ['feature_key' => 'alerts',           'category' => 'inventory', 'title' => 'Low Stock Alerts',        'is_enabled' => true],
            ['feature_key' => 'po',               'category' => 'purchase',  'title' => 'Purchase Orders',         'is_enabled' => true],
            ['feature_key' => 'vendors',          'category' => 'purchase',  'title' => 'Vendor Management',       'is_enabled' => true],
            ['feature_key' => 'vendorpay',        'category' => 'purchase',  'title' => 'Vendor Payments',         'is_enabled' => true],
            ['feature_key' => 'employees',        'category' => 'hr',        'title' => 'Employee Profiles',       'is_enabled' => true],
            ['feature_key' => 'payroll',          'category' => 'hr',        'title' => 'Payroll Processing',      'is_enabled' => true],
            ['feature_key' => 'expenses',         'category' => 'finance',   'title' => 'Expense Tracking',        'is_enabled' => true],
            ['feature_key' => 'salesreports',     'category' => 'reports',   'title' => 'Sales Analytics',         'is_enabled' => true],
            ['feature_key' => 'inventoryreports', 'category' => 'reports',   'title' => 'Stock Reports',           'is_enabled' => true],
            ['feature_key' => 'financialreports', 'category' => 'reports',   'title' => 'Financial Statements',    'is_enabled' => true],
        ];

        foreach ($defaultFeatures as $feature) {
            \App\Models\FeatureSetting::withoutGlobalScopes()->create(array_merge($feature, [
                'company_id' => $company->id,
            ]));
        }

        // Seed default chart of accounts for this company
        $accountDefs = [
            ['code' => '1000', 'name' => 'Assets',                'category' => 'assets',      'type' => 'parent',     'parent_code' => null],
            ['code' => '1010', 'name' => 'Current Assets',        'category' => 'assets',      'type' => 'parent',     'parent_code' => '1000'],
            ['code' => '1011', 'name' => 'Cash on Hand',          'category' => 'assets',      'type' => 'cash',       'parent_code' => '1010'],
            ['code' => '1020', 'name' => 'Bank Accounts',         'category' => 'assets',      'type' => 'parent',     'parent_code' => '1010'],
            ['code' => '1030', 'name' => 'Accounts Receivable',   'category' => 'assets',      'type' => 'receivable', 'parent_code' => '1010'],
            ['code' => '1400', 'name' => 'Inventory Asset',       'category' => 'assets',      'type' => 'inventory',  'parent_code' => '1010'],
            ['code' => '2000', 'name' => 'Liabilities',           'category' => 'liabilities', 'type' => 'parent',     'parent_code' => null],
            ['code' => '2010', 'name' => 'Current Liabilities',   'category' => 'liabilities', 'type' => 'parent',     'parent_code' => '2000'],
            ['code' => '2011', 'name' => 'Accounts Payable',      'category' => 'liabilities', 'type' => 'payable',    'parent_code' => '2010'],
            ['code' => '3000', 'name' => 'Equity',                'category' => 'equity',      'type' => 'parent',     'parent_code' => null],
            ['code' => '3010', 'name' => 'Opening Balance Equity','category' => 'equity',      'type' => 'equity',     'parent_code' => '3000'],
            ['code' => '4000', 'name' => 'Revenue',               'category' => 'revenue',     'type' => 'parent',     'parent_code' => null],
            ['code' => '4010', 'name' => 'Sales Revenue',         'category' => 'revenue',     'type' => 'revenue',    'parent_code' => '4000'],
            ['code' => '5000', 'name' => 'Expenses',              'category' => 'expenses',    'type' => 'parent',     'parent_code' => null],
            ['code' => '5010', 'name' => 'Operating Expenses',    'category' => 'expenses',    'type' => 'operating',  'parent_code' => '5000'],
        ];
        $accountIds = [];
        foreach ($accountDefs as $def) {
            $parentId = $def['parent_code'] ? ($accountIds[$def['parent_code']] ?? null) : null;
            $acct = \App\Models\Account::withoutGlobalScopes()->create([
                'code'       => $def['code'],
                'name'       => $def['name'],
                'category'   => $def['category'],
                'type'       => $def['type'],
                'parent_id'  => $parentId,
                'balance'    => 0,
                'company_id' => $company->id,
            ]);
            $accountIds[$def['code']] = $acct->id;
        }

        // Seed a default HQ branch so the company can operate immediately
        \App\Models\Branch::withoutGlobalScopes()->create([
            'company_id' => $company->id,
            'name'       => $company->name . ' - HQ',
            'code'       => 'BR-HQ',
            'level'      => 'Headquarters',
            'is_active'  => true,
        ]);

        // Note: We do NOT fire Registered event because the admin email is
        // pre-verified above — firing it would send a verification email
        // and redirect to the verify-email page, blocking dashboard access.

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
