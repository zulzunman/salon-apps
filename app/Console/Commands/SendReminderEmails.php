<?php

namespace App\Console\Commands;

use App\Http\Controllers\RegistrationController;
use Illuminate\Console\Command;

class SendReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info("⏰ Menjalankan SendReminderEmails dari command");

        $controller = new RegistrationController();
        $controller->sendReminderEmails();
    }
}
