<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 20) as $i) {
            Customer::create([
                'name' => $faker->name,
                'email' => $faker->unique()->userName . '@gmail.com',
            ]);
        }
    }
}
