<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add indexes on company_id for all tenant-scoped tables.
     * Every query filtered by TenantScope uses this column, so indexes
     * prevent full-table scans as data grows per tenant.
     */
    public function up(): void
    {
        $tables = [
            'users',
            'roles',
            'employees',
            'accounts',
            'journal_entries',
            'journal_items',
            'categories',
            'units',
            'brands',
            'products',
            'product_stocks',
            'sales_orders',
            'sales_order_items',
            'purchase_orders',
            'purchase_order_items',
            'purchase_bills',
            'purchase_bill_items',
            'supplier_payments',
            'supplier_payment_details',
            'audit_logs',
            'backups',
            'store_transfers',
            'stores',
            'branches',
            'customers',
            'suppliers',
            'payment_ins',
            'purchase_expenses',
            'expenses',
            'purchase_returns',
            'purchase_return_items',
            'stock_movements',
            'shareholders',
            'payrolls',
        ];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) continue;
            if (!Schema::hasColumn($table, 'company_id')) continue;

            $existingIndexes = collect(Schema::getIndexes($table))
                ->pluck('name')
                ->all();

            $indexName = $table . '_company_id_index';
            if (!in_array($indexName, $existingIndexes)) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->index('company_id');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'users', 'roles', 'employees', 'accounts', 'journal_entries',
            'journal_items', 'categories', 'units', 'brands', 'products',
            'product_stocks', 'sales_orders', 'sales_order_items',
            'purchase_orders', 'purchase_order_items', 'purchase_bills',
            'purchase_bill_items', 'supplier_payments', 'supplier_payment_details',
            'audit_logs', 'backups', 'store_transfers', 'stores', 'branches',
            'customers', 'suppliers', 'payment_ins', 'purchase_expenses',
            'expenses', 'purchase_returns', 'purchase_return_items',
            'stock_movements', 'shareholders', 'payrolls',
        ];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) continue;
            if (!Schema::hasColumn($table, 'company_id')) continue;

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropIndex(['company_id']);
            });
        }
    }
};
