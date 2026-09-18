<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '+1234567890',

            'address' => 'Admin Street 123',
            'status' => 'active',
        ]);

        // Optional: Create a regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '+0987654321',

            'address' => 'User Street 456',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'trainer User',
            'email' => 'trainer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'phone' => '+1234567890',

            'address' => 'trainer Street 123',
            'status' => 'active',
        ]);

        // Optional: Create a regular user
        User::create([
            'name' => 'member User',
            'email' => 'member@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'phone' => '+0987654321',

            'address' => 'member Street 456',
            'status' => 'active',
        ]);
    }
}
