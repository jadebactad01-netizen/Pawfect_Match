<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create a development administrator account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@pawfect.test',
            ],
            [
                'name' => 'Pawfect Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }
}