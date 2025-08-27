<?php

use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;
//use Darryldecode\Cart\Facades\CartFacade as Cart;


// note :  super-admin role have all permissions and roles
function userAbility(array $permissions)
{
//    throw UnauthorizedException::forPermissions($permissions);

    $user_id = auth()->id();
    $user = User::find($user_id); //get user from model

    if (!in_array('super-admin', $user->getRoleNames()->toArray())) // if user is not super-admin
    {
        $user_permissions = $user->getAllPermissions()->pluck('name')->toArray(); // get all user permissions
        foreach ($permissions as  $permission) {
            if (in_array($permission, $user_permissions)) {
                //if user have permissions from required permissions => push this permissions in identical_permissions array
                $identical_permissions[] = $permission;
            }
        }
        if (empty($identical_permissions)) { // if user does not have any permissions from required permissions => return exception
            throw UnauthorizedException::forPermissions($permissions);
        }
        return $identical_permissions;
    } else {
        return ['super-admin'];
    }
}

function checkAbility(string $permission, array $permissions)
{
    //if the require permission exists in user permissions
    if (in_array($permission, $permissions) || $permissions[0] == 'super-admin') {
        return true;
    }
    return false;
}
function getCurrency()
{
    echo ' EGP ';
}

function checkImg($img_src)
{
    $image_src =  File::exists($img_src) ?
        asset($img_src) :
        asset('storage/images/products/no-img.svg');
    return $image_src;
}
function cartData()
{
    $userId = auth()->id();

    $cart = $userId
        ? CartFacade::session($userId)
        : CartFacade::session('cart');

    if ($cart->getContent()->count() > 0) {
        $cartData['count'] = $cart->getContent()->count();
        $cartData['total'] = $cart->getTotal();
        $cartData['subTotal'] = $cart->getSubTotal();
        $cart_collection = $cart->getContent()->reverse();
        foreach ($cart_collection as $item) {
            $cartData['items'][] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'associatedModel' => (array) $item->associatedModel,
                'size_id' => $item->attributes->size_id,
                'size_name' => $item->attributes->size_name,
            ];
        }
        return $cartData;
    }else{
        return [];
    }


}
function currentLang()
{
    return app()->getLocale();
}

function addToCart($product, $size, $quantity)
{

    $userId = auth()->id(); // null if guest

    $cart = $userId
        ? \Cart::session($userId) // For logged-in users
        : \Cart::session('cart');

    $cart->add([
        'id' => $product->id,
        'name' => $product->name_ar,
        'price' => $product->price,
        'quantity' => $quantity,
        'associatedModel' => $product->toArray(),
        'attributes' => [
            'size_id' => $size->id,
            'size_name' => $size->name,
        ]
    ]);

}
function updateCart($product, $size_id, $quantity)
{
    $product_id = $product->id;
    $cartItems = \Cart::session(auth()->id() ?? 'cart')->getContent();
    $existingItem = $cartItems->filter(function ($item) use ($product_id, $size_id) {
        return $item->id == $product_id;
    })->first();

    \Cart::session(auth()->id() ?? 'cart')->update($existingItem->id, [
        'quantity' =>  $quantity,
        'price' => $product->price
    ]);
}

