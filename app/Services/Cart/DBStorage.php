<?php

namespace App\Services\Cart;
use App\Models\Cart;
use Darryldecode\Cart\CartCollection;

class DBStorage
{

    public function has($key)
    {
        return Cart::find($key);
    }


    public function get($key)
    {
        if($this->has($key))
        {
            $cart = Cart::find($key);
            \Log::info('Raw cart data for key ' . $key . ': ', [$cart->content]); // تسجيل البيانات الخام
            if (is_array($cart->content)) {
                return new CartCollection(Cart::find($key)->content);
            } else {
                \Log::warning('Cart data is not an array for key ' . $key);
                return new CartCollection([]);
            }

        }
        else
        {
            return [];
        }
    }


    public function put($key, $value)
    {
        if($row = Cart::find($key))
        {
            // update
            $row->content = $value instanceof \Darryldecode\Cart\CartCollection
                ? $value->toArray()
                : $value;
            $row->created_at = now();
            $row->updated_at = now();
            $row->save();
        }
        else
        {
            Cart::create([
                'id' => $key,
                'content' => $value instanceof \Darryldecode\Cart\CartCollection
                    ? $value->toArray()
                    : $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function forget($key)
    {
        Cart::where('id', $key)->delete();
    }
}
