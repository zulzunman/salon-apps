<?php

namespace App\Jobs;

use App\Mail\ReminderMail;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReminderEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bookingId;

    public function __construct(Registration $bookingId)
    {
        $this->bookingId = $bookingId;
    }

    public function handle()
    {
        // Cek apakah reminder sudah dikirim
        if ($this->bookingId->reminder_sent) {
            return;
        }

        $currentTime = Carbon::now('Asia/Jakarta');
        $bookingIdTime = $this->bookingId->full_date_time;

        // Log untuk debugging
        \Log::info('Sending reminder', [
            'current_time_wib' => $currentTime->format('Y-m-d H:i:s T'),
            'bookingId_time_wib' => $bookingIdTime->format('Y-m-d H:i:s T'),
            'reminder_time_wib' => $this->bookingId->reminder_time->format('Y-m-d H:i:s T')
        ]);

        // Kirim email
        Mail::to($this->bookingId->email)
            ->send(new ReminderMail($this->bookingId));

        // Update status reminder
        $this->bookingId->update(['reminder_sent' => true]);
    }
}
