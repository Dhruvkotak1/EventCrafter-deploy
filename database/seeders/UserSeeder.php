<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Organizer with known credentials
        User::create([
            'name' => 'Organizer One',
            'email' => 'organizer@example.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
        ]);

        // 5 fake customers
        User::factory()->count(5)->create([
            'role' => 'customer',
        ]);
    }
}
