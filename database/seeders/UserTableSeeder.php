<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::where('name', 'Horntech LTD')->first();
        if (!$company) {
            $company = Company::create([
                'name' => 'Horntech LTD',
                'email' => 'info@horntech.com',
            ]);
        }
        User::updateOrCreate(
        ['email' => 'admin@horntech.com'],
        [
            'name' => 'System Admin',
            'password' => Hash::make('password'),
            'company_id' => $company->id,
            'role' => 'admin',
            'email_verified_at' => now(),
        ]
        );

        User::updateOrCreate(
        ['email' => 'superadmin@horntech.com'],
        [
            'name' => 'Host Super Admin',
            'password' => Hash::make('password'),
            'company_id' => null,
            'role' => 'Super Admin',
            'email_verified_at' => now(),
        ]
        );
    }
}
