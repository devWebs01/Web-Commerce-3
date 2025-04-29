<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'admin',
                'email' => 'admin@testing.com',
                'telp' => '08'.rand(1111111111, 9999999999),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => 'admin',
            ],
            [
                'name' => 'pemilik',
                'email' => 'pemilik@testing.com',
                'telp' => '08'.rand(1111111111, 9999999999),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => 'superadmin',
            ],
            [
                'name' => 'pelanggan',
                'email' => 'pelanggan@testing.com',
                'telp' => '08'.rand(1111111111, 9999999999),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => 'customer', // Mengganti 'customer' menjadi 'customer'
            ],
        ]);
    }
}
