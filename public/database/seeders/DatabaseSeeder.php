<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User - Already Verified
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@finance.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Regular User - Need to verify email
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@finance.test',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(), // Set to now for testing, remove this line for real verification requirement
        ]);

        // Create Default Categories for User
        $incomeCategories = [
            ['name' => 'Gaji', 'color' => '#10b981'],
            ['name' => 'Bonus', 'color' => '#14b8a6'],
            ['name' => 'Investasi', 'color' => '#0ea5e9'],
            ['name' => 'Bisnis', 'color' => '#f59e0b'],
        ];

        $expenseCategories = [
            ['name' => 'Makan', 'color' => '#ef4444'],
            ['name' => 'Transport', 'color' => '#f97316'],
            ['name' => 'Hiburan', 'color' => '#a855f7'],
            ['name' => 'Belanja', 'color' => '#ec4899'],
            ['name' => 'Listrik/Air', 'color' => '#6366f1'],
            ['name' => 'Internet', 'color' => '#06b6d4'],
        ];

        foreach ($incomeCategories as $category) {
            Category::create([
                'user_id' => $user->id,
                'name' => $category['name'],
                'type' => 'income',
                'color' => $category['color'],
            ]);
        }

        foreach ($expenseCategories as $category) {
            Category::create([
                'user_id' => $user->id,
                'name' => $category['name'],
                'type' => 'expense',
                'color' => $category['color'],
            ]);
        }
    }
}

