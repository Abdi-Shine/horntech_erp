<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            ChartOfAccountsSeeder::class, // replaces the old AccountSeeder
            UserTableSeeder::class,
            RoleSeeder::class,
            FeatureSettingsSeeder::class,
            SubscriptionPlanSeeder::class,
        ]);
    }
}
