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
            ['name' => 'Cukur Rambut Pria', 'price' => 25000, 'duration' => 30],
            ['name' => 'Cukur Rambut Wanita', 'price' => 35000, 'duration' => 45],
            ['name' => 'Cuci + Blow', 'price' => 30000, 'duration' => 40],
            ['name' => 'Creambath', 'price' => 50000, 'duration' => 60],
            ['name' => 'Hair Mask', 'price' => 60000, 'duration' => 60],
            ['name' => 'Coloring Rambut', 'price' => 120000, 'duration' => 90],
            ['name' => 'Smoothing', 'price' => 150000, 'duration' => 120],
        ];

        DB::table('services')->insert($services);
    }
}
