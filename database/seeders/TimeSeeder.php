<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startTime = strtotime('09:00');
        $endTime = strtotime('17:00');
        $timeSlots = [];

        while ($startTime <= $endTime) {
            $timeSlots[] = [
                'time' => date('H:i', $startTime)
            ];
            $startTime = strtotime('+1 hour', $startTime);
        }

        DB::table('booking_times')->insert($timeSlots);
    }
}
