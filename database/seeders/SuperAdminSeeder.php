<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Create the default Super Administrator account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'superadmin@pawfect.com',
            ],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
            ]
        );
    }
}