<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'last_name' => 'Test',
            'first_name' => 'User',
            'middle_name' => 'Testovich',
            'phone' => '+998901234567',
        ]);

        \App\Models\User::factory()->create([
            'last_name' => 'Admin',
            'first_name' => 'Test',
            'middle_name' => 'User',
            'phone' => '998999999999',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}
