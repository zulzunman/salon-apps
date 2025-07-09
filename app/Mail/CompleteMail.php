<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompleteMail extends Mailable
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
        return $this->subject('Informasi Pelayanan Salon')
                    ->view('customer.email.complete')
                    ->with([
                        'name'  => $this->dataCustomer->customer->name,
                        'antri'  => $this->dataCustomer->queue_number,
                        'service'  => $this->dataCustomer->service->name,
                    ]);
    }
}
