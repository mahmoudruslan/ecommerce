<?php

namespace App\Listeners;

use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SaveCartToDatabase
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $cartContent = CartFacade::session($userId)->getContent()->toArray();

            \DB::table('carts')->updateOrInsert(
                ['user_id' => $userId],
                ['content' => json_encode($cartContent)]
            );


        }
    }
}
