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
        // Ensure Horntech LTD company exists
        $company = Company::where('name', 'Horntech LTD')->first();
        if (!$company) {
            $company = Company::create([
                'name'  => 'Horntech LTD',
                'email' => 'info@horntech.com',
            ]);
        }

        // Company owner admin — uses regular /dashboard
        User::withoutGlobalScopes()->updateOrCreate(
            ['email' => 'admin@horntech.com'],
            [
                'name'              => 'System Admin',
                'fullname'          => 'System Admin',
                'password'          => Hash::make('Admin@1234'),
                'company_id'        => $company->id,
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Super Admin — no company, uses /host/dashboard
        User::withoutGlobalScopes()->updateOrCreate(
            ['email' => 'superadmin@horntech.com'],
            [
                'name'              => 'Super Admin',
                'fullname'          => 'Super Admin',
                'password'          => Hash::make('SuperAdmin@1234'),
                'company_id'        => null,
                'role'              => 'Super Admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
