<?php

namespace App\Jobs;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelIfNotServed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $registrationId;
    protected $model;

    public function __construct($registrationId)
    {
        $this->registrationId = $registrationId;
    }

    public function handle()
    {
        $registration = Registration::find($this->registrationId);

        // Jika masih berstatus CALLING setelah 15 menit, ubah jadi CANCELED
        if ($registration && $registration->status === 'CALLING') {
            $registration->status = 'CANCELED';
            $registration->save();
        }
    }
}
