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

        User::create([
            'first_name' => 'Huda',
            'last_name' => 'Shakir',
            'email' => 'huda@gmail.com',
            'password' => 'password',
            'is_admin' => 1,
            'image' => 'user/1.jpg',
        ]);
    }
}
