<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoadUserCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $cartData = \DB::table('carts')
                ->where('user_id', auth()->id())
                ->value('content');

            if ($cartData) {
                $cartItems = json_decode($cartData, true);
                $cart = \Cart::session(auth()->id());

                foreach ($cartItems as $item) {
//                    dd($item);
                    $cart->add([
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'attributes' => $item['attributes'],
                        'associatedModel' => $item['associatedModel'],
                    ]);
                }
            }
        }

        return $next($request);
    }
}
