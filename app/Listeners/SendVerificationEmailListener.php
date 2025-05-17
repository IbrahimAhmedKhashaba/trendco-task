<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Jobs\SendVerificationEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerificationEmailListener implements ShouldQueue
{
    public function handle(UserRegistered $event)
    {
        SendVerificationEmailJob::dispatch($event->user);
    }
}
