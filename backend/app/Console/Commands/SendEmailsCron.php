<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendEmailJob;

class SendEmailsCron extends Command
{
    protected $signature = 'emails:send';

    protected $description = 'Send emails to Shops periodically';

    public function handle()
    {
        SendEmailJob::dispatch();
        
        $this->info('Emails sent successfully.');
    }
}