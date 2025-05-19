<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTime extends Model
{
    use HasFactory;

    protected $table = 'booking_times';
    protected $fillable = ['time'];

    public function registration()
    {
        return $this->hasMany(Registration::class);
    }
}
