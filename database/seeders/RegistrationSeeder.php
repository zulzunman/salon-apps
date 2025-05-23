<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Registration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            'PENDING' => 5,
            'CALLING' => 5,
            'SERVING' => 5,
            'COMPLETED' => 5,
        ];

        $customer_id = 8;
        $bookingTimeUsage = [];

        foreach ($statuses as $status => $count) {
            for ($i = 0; $i < $count; $i++) {

                // booking_time_id logic
                if ($status === 'PENDING') {
                    do {
                        $booking_time_id = rand(1, 9);
                        $bookingTimeUsage[$booking_time_id] = $bookingTimeUsage[$booking_time_id] ?? 0;
                    } while ($bookingTimeUsage[$booking_time_id] >= 3);
                    $bookingTimeUsage[$booking_time_id]++;
                } else {
                    $booking_time_id = rand(1, 9);
                }

                Registration::create([
                    'customer_id' => $customer_id++,
                    'service_id' => rand(1, 7),
                    'status' => $status,
                    'booking_time_id' => $booking_time_id,
                    'called_at' => $status !== 'PENDING' ? now() : null,
                    'canceled_at' => $status === 'CANCELED' ? now() : null,
                ]);
            }
        }
    }
}
