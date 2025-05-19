<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrasiMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Informasi Booking Pelayanan Salon')
                    ->view('customer.email.regist')
                    ->with([
                        'name'  => $this->data->customer->name,
                        'time'  => $this->data->bookingTime->name,
                        'service'  => $this->data->service->name,
                    ]);
    }
}
