<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\FeatureSetting;
use Illuminate\Database\Seeder;

class FeatureSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            // Sales
            ['feature_key' => 'pos', 'category' => 'sales', 'title' => 'POS System', 'description' => 'Enable point of sale interface for retail transactions', 'is_enabled' => true],
            ['feature_key' => 'quotations', 'category' => 'sales', 'title' => 'Sales Quotations', 'description' => 'Create and manage sales quotations for customers', 'is_enabled' => true],
            ['feature_key' => 'invoice', 'category' => 'sales', 'title' => 'Invoice Generation', 'description' => 'Automatic invoice creation and printing', 'is_enabled' => true],
            ['feature_key' => 'loyalty', 'category' => 'sales', 'title' => 'Customer Loyalty Program', 'description' => 'Points-based loyalty and rewards system', 'is_enabled' => false],
            ['feature_key' => 'returns', 'category' => 'sales', 'title' => 'Sales Returns', 'description' => 'Handle product returns and refunds', 'is_enabled' => true],
            
            // Inventory
            ['feature_key' => 'multibranch', 'category' => 'inventory', 'title' => 'Multi-Branch Support', 'description' => 'Track inventory across multiple branches', 'is_enabled' => true],
            ['feature_key' => 'multiwarehouse', 'category' => 'inventory', 'title' => 'Multi-Warehouse', 'description' => 'Manage multiple warehouses per branch', 'is_enabled' => true],
            ['feature_key' => 'transfers', 'category' => 'inventory', 'title' => 'Stock Transfers', 'description' => 'Transfer stock between locations', 'is_enabled' => true],
            ['feature_key' => 'adjustments', 'category' => 'inventory', 'title' => 'Stock Adjustments', 'description' => 'Manual stock reconciliation features', 'is_enabled' => true],
            ['feature_key' => 'alerts', 'category' => 'inventory', 'title' => 'Low Stock Alerts', 'description' => 'Notifications for low inventory levels', 'is_enabled' => true],
            ['feature_key' => 'barcode', 'category' => 'inventory', 'title' => 'Barcode Scanning', 'description' => 'Enable barcode/SKU scanning features', 'is_enabled' => false],
            
            // Purchase
            ['feature_key' => 'po', 'category' => 'purchase', 'title' => 'Purchase Orders', 'description' => 'Manage external procurement workflows', 'is_enabled' => true],
            ['feature_key' => 'grn', 'category' => 'purchase', 'title' => 'Goods Receipt (GRN)', 'description' => 'Track received goods from suppliers', 'is_enabled' => true],
            ['feature_key' => 'vendors', 'category' => 'purchase', 'title' => 'Vendor Management', 'description' => 'Centralized supplier directory', 'is_enabled' => true],
            ['feature_key' => 'vendorpay', 'category' => 'purchase', 'title' => 'Vendor Payments', 'description' => 'Account payable and payment tracking', 'is_enabled' => true],
            
            // HR
            ['feature_key' => 'employees', 'category' => 'hr', 'title' => 'Employee Profiles', 'description' => 'Digital personnel records system', 'is_enabled' => true],
            ['feature_key' => 'payroll', 'category' => 'hr', 'title' => 'Payroll Processing', 'description' => 'Calculate and issue staff salaries', 'is_enabled' => true],
            ['feature_key' => 'attendance', 'category' => 'hr', 'title' => 'Attendance Tracker', 'description' => 'Working hours and clock-in logs', 'is_enabled' => true],
            ['feature_key' => 'leave', 'category' => 'hr', 'title' => 'Leave Management', 'description' => 'Time-off requests and approvals', 'is_enabled' => true],
            
            // Finance
            ['feature_key' => 'expenses', 'category' => 'finance', 'title' => 'Expense Tracking', 'description' => 'Register and categorize business costs', 'is_enabled' => true],
            ['feature_key' => 'ledger', 'category' => 'finance', 'title' => 'General Ledger', 'description' => 'Complete double-entry accounting records', 'is_enabled' => false],
            ['feature_key' => 'coa', 'category' => 'finance', 'title' => 'Chart of Accounts', 'description' => 'Custom financial account structure', 'is_enabled' => false],
            
            // Reports
            ['feature_key' => 'salesreports', 'category' => 'reports', 'title' => 'Sales Analytics', 'description' => 'Advanced sales performance reporting', 'is_enabled' => true],
            ['feature_key' => 'inventoryreports', 'category' => 'reports', 'title' => 'Stock Reports', 'description' => 'Movement and valuation analysis', 'is_enabled' => true],
            ['feature_key' => 'financialreports', 'category' => 'reports', 'title' => 'Financial Statements', 'description' => 'P&L and Balance Sheet generation', 'is_enabled' => true],
        ];

        // Seed for every existing company so this seeder works for existing installs
        $companyIds = Company::pluck('id');

        foreach ($companyIds as $companyId) {
            foreach ($features as $feature) {
                FeatureSetting::withoutGlobalScopes()->updateOrCreate(
                    ['company_id' => $companyId, 'feature_key' => $feature['feature_key']],
                    array_merge($feature, ['company_id' => $companyId])
                );
            }
        }
    }
}
