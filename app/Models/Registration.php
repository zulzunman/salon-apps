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
    protected $fillable = ['customer_id', 'service_id', 'status', 'queue_number', 'called_at'];
    protected $casts = [
        'called_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'PENDING' => 'Menunggu',
            'CALLING' => 'Dipanggil',
            'SERVING' => 'Sedang Dilayani',
            'COMPLETED' => 'Selesai',
            'CANCELED' => 'Dibatalkan'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // Helper method untuk mendapatkan waktu tunggu
    public function getWaitingTimeAttribute()
    {
        if ($this->status === 'PENDING') {
            return Carbon::parse($this->created_at)->diffForHumans(null, true);
        }
        return null;
    }

    // Method untuk check apakah sudah timeout saat dipanggil
    public function isCallTimeout()
    {
        if ($this->status === 'CALLING' && $this->called_at) {
            return Carbon::parse($this->called_at)->addMinutes(15)->isPast();
        }
        return false;
    }
}
