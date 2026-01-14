<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test buyer user
        User::updateOrCreate(
            ['email' => 'buyer@test.com'],
            [
                'name' => 'Test Buyer',
                'email' => 'buyer@test.com',
                'password' => Hash::make('password123'),
                'role' => 'buyer',
                'email_verified_at' => now(),
            ]
        );

        // Create test seller user
        User::updateOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name' => 'Test Seller',
                'email' => 'seller@test.com',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'email_verified_at' => now(),
            ]
        );
    }
}
