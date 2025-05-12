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
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                // 'role'  => 'ADMIN',
                // 'phone' => 089111111111,
                'created_at' => now(),
                'updated_at' => now()
            ]
            // [
            //     'id'    => 2,
            //     'name'  => 'Stylist',
            //     'email' => 'stylist@example.com',
            //     'email_verified_at' => now(),
            //     'password' => Hash::make('12345678'),
            //     'role'  => 'STYLIST',
            //     'phone' => 089111111111,
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'id'    => 3,
            //     'name'  => 'Customer',
            //     'email' => 'customer@example.com',
            //     'email_verified_at' => now(),
            //     'password' => Hash::make('12345678'),
            //     'role'  => 'CUSTOMER',
            //     'phone' => 089111111111,
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]
        ]);
    }
}
