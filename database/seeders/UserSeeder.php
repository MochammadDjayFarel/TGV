<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'AdminDjay',
            'password' => Hash::make('Admin'),
            'role' => 'admin',
        ]);

        User::updateOrCreate([
            'email' => 'staff@gmail.com',
        ], [
            'name' => 'staffDjay',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
        ]);

        // Create user for admin access
        User::updateOrCreate([
            'email' => 'user@gmail.com',
        ], [
            'name' => 'User Admin',
            'password' => Hash::make('User123'),
            'role' => 'user',
        ]);
    }
}
