<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CallingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $dataCustomer;

    public function __construct($dataCustomer)
    {
        $this->dataCustomer = $dataCustomer;
    }

    public function build()
    {
        return $this->subject('Informasi Pemanggilan Pelanggan')
            ->view('customer.email.calling')
            ->with([
                'name'    => $this->dataCustomer->customer->name,
                'antri'   => $this->dataCustomer->queue_number,
                'service' => $this->dataCustomer->service->name,
            ]);
    }
}
