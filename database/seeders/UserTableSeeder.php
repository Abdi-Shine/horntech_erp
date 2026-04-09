<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
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
