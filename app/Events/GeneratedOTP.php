<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GeneratedOTP
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $otp;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $otp)
    {
        $this->otp = $otp;
        $this->user = $user;
    }
}
