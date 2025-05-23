<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id'    => 1,
                'name'  => 'Admin',
                'role'  => 'ADMIN',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                // 'phone' => 089111111111,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id'    => 2,
                'name'  => 'Stylist',
                'role'  => 'STAFF',
                'email' => 'stylist@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                // 'phone' => 089111111111,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id'    => 3,
                'name'  => 'Putri Ayu Lestari',
                'role'  => 'STAFF',
                'email' => 'ayuptr@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                // 'phone' => 089111111111,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id'    => 4,
                'name'  => 'Intan Permata Sari',
                'role'  => 'STAFF',
                'email' => 'intanpsari@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                // 'phone' => 089111111111,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id'    => 5,
                'name'  => 'Dewi Anjani Rahmawati',
                'role'  => 'STAFF',
                'email' => 'dewi238@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                // 'phone' => 089111111111,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
