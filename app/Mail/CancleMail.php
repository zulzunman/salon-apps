<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancleMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $call;
    /**
     * Create a new message instance.
     */
    public function __construct($call)
    {
        $this->call = $call;
    }

    public function build()
    {
        return $this->subject('Informasi Pelayanan Salon')
                    ->view('customer.email.cancel')
                    ->with([
                        'name'  => $this->call->customer->name,
                        'time'  => $this->call->bookingTime->time,
                        'date'  => $this->call->booking_date,
                        'service'  => $this->call->service->name,
                    ]);
    }
}
