<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';
    protected $fillable = ['customer_id', 'service_id', 'booking_time_id', 'status', 'booking_date'];
    protected $casts = [
        'booking_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function bookingTime()
    {
        return $this->belongsTo(BookingTime::class);
    }

    public function getFullDateTimeAttribute()
    {
        $dateTime = Carbon::parse($this->booking_date->format('Y-m-d') . ' ' . $this->bookingTime->time->format('H:i:s'));

        // Pastikan timezone WIB
        return $dateTime->setTimezone('Asia/Jakarta');
    }

    // Method untuk mendapatkan waktu reminder (15 menit sebelum) dalam WIB
    public function getReminderTimeAttribute()
    {
        return $this->full_date_time->copy()->subMinutes(15);
    }

    // Method untuk mendapatkan waktu dalam UTC (untuk queue delay)
    public function getReminderTimeUtcAttribute()
    {
        return $this->reminder_time->utc();
    }
}
