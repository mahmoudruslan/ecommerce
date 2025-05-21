<?php

namespace App\Listeners;

use App\Events\GeneratedOTP;
use App\Notifications\SendOTPNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOTP
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\GeneratedOTP  $event
     * @return void
     */
    public function handle(GeneratedOTP $event)
    {
        $user = $event->user;
        $otp = $event->otp;
        $user->notify(new SendOTPNotification($otp));
    }
}
