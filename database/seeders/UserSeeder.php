<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'phonenumber' => '1234567890',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'created_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@test.com',
            'phonenumber' => '1234567890',
            'email_verified_at' => now(),
            'password' => Hash::make('user1234'),
            'is_admin' => false,
            'created_at' => now(),
        ]);
    }
}
