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
                'name'  => 'Horntech LTD',
                'email' => 'info@horntech.com',
            ]);
        }

        // Remove leftover super admin account if it exists
        User::withoutGlobalScopes()->where('email', 'superadmin@horntech.com')->delete();

        User::updateOrCreate(
            ['email' => 'admin@horntech.com'],
            [
                'name'               => 'System Admin',
                'fullname'           => 'System Admin',
                'password'           => Hash::make('Admin@1234'),
                'company_id'         => $company->id,
                'role'               => 'admin',
                'email_verified_at'  => now(),
            ]
        );
    }
}
