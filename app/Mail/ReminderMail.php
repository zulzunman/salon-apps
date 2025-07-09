<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $booking;
    /**
     * Create a new message instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Informasi Pengingat Pelayanan')
                    ->view('customer.email.reminder')
                    ->with([
                        'name' => $this->booking->customer->name,
                        'service' => $this->booking->service->name ?? '-',
                        'time' => $this->booking->bookingTime->time,
                        'date' => $this->booking->booking_date,
                    ]);
    }
}
