<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SubscriptionPlan::create([
            'name' => 'Starter',
            'description' => 'Perfect for small retail shops and single-location businesses',
            'price' => 299,
            'billing_cycle' => 'monthly',
            'max_users' => 3,
            'storage_limit_gb' => 2,
            'features' => ['1 Branch', 'Up to 3 Users', '500 Products limit', 'Basic Inventory', 'Single POS Terminal'],
            'status' => 'active',
            'is_popular' => false,
        ]);

        \App\Models\SubscriptionPlan::create([
            'name' => 'Business',
            'description' => 'Ideal for growing businesses with multiple locations',
            'price' => 899,
            'billing_cycle' => 'monthly',
            'max_users' => 15,
            'storage_limit_gb' => 20,
            'features' => ['Up to 5 Branches', 'Up to 15 Users', 'Unlimited Products', 'Multi-Warehouse', 'Inter-Branch Transfers', 'Purchase Workflow'],
            'status' => 'active',
            'is_popular' => true,
        ]);

        \App\Models\SubscriptionPlan::create([
            'name' => 'Enterprise',
            'description' => 'For large retail chains and complex operations',
            'price' => 2999,
            'billing_cycle' => 'monthly',
            'max_users' => 999,
            'storage_limit_gb' => 100,
            'features' => ['Unlimited Branches', 'Unlimited Users', 'API Access', 'ERP Integration', 'AI-Powered Forecasting', 'Dedicated Account Manager'],
            'status' => 'active',
            'is_popular' => false,
        ]);
    }
}
