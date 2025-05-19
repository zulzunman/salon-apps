<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CallingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $dataCustomer;
    /**
     * Create a new message instance.
     */
    public function __construct($dataCustomer)
    {
        $this->dataCustomer = $dataCustomer;
    }

    public function build()
    {
        return $this->subject('Informasi Pemanggilan Pelanggan')
                    ->view('customer.email.calling')
                    ->with([
                        'name'  => $this->dataCustomer->customer->name,
                        'time'  => $this->dataCustomer->bookingTime->name,
                        'service'  => $this->dataCustomer->service->name,
                    ]);
    }
}
