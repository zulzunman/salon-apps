<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Cukur Rambut Pria',
                'price' => 25000,
                'duration' => 30,
                'description' => 'Potong rambut khusus pria dengan gaya sesuai keinginan.'
            ],
            [
                'name' => 'Cukur Rambut Wanita',
                'price' => 35000,
                'duration' => 45,
                'description' => 'Potong rambut wanita dengan teknik profesional dan modern.'
            ],
            [
                'name' => 'Cuci + Blow',
                'price' => 30000,
                'duration' => 40,
                'description' => 'Paket cuci rambut dan blow untuk tampilan lebih rapi dan segar.'
            ],
            [
                'name' => 'Creambath',
                'price' => 50000,
                'duration' => 60,
                'description' => 'Perawatan rambut dengan krim untuk menutrisi dan melembutkan.'
            ],
            [
                'name' => 'Hair Mask',
                'price' => 60000,
                'duration' => 60,
                'description' => 'Masker rambut untuk mengembalikan kesehatan dan kilau alami rambut.'
            ],
            [
                'name' => 'Coloring Rambut',
                'price' => 120000,
                'duration' => 90,
                'description' => 'Pewarnaan rambut dengan berbagai pilihan warna berkualitas.'
            ],
            [
                'name' => 'Smoothing',
                'price' => 150000,
                'duration' => 120,
                'description' => 'Meluruskan rambut agar tampak halus, lembut, dan mudah diatur.'
            ],
        ];

        DB::table('services')->insert($services);
    }
}
