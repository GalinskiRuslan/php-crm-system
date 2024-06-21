<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'qK5pI@example.com',
            'password' => bcrypt('qwerty1234'),
            'phone' => '0000000000',
            'role' => 'admin',
        ]);
    }
}
