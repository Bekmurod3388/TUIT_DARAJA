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

        \App\Models\User::factory()->create([
            'last_name' => 'test',
            'first_name' => 'testov',
            'middle_name' => 'testovich',
            'phone' => '998901234567',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        \App\Models\User::factory()->create([
            'last_name' => 'Admin',
            'first_name' => 'Test',
            'middle_name' => 'User',
            'phone' => '998999999999',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
