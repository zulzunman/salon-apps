<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';
    protected $fillable = ['customer_id', 'service_id', 'booking_time_id', 'status'];

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
}
