<?php

use App\Models\User;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Darryldecode\Cart\Facades\CartFacade as Cart;


    // note :  super-admin role have all permissions and roles
    function userAbility(array $permissions)
    {
        $user_id = auth()->id();
        $user = User::find($user_id); //get user from model

        if(!in_array('super-admin', $user->getRoleNames()->toArray())) // if user is not super-admin
        {
            $user_permissions = $user->getAllPermissions()->pluck('name')->toArray();// get all user permissions
            foreach ($permissions as  $permission){
                if(in_array($permission, $user_permissions))
                {
                    //if user have permissions from required permissions => push this permissions in identical_permissions array
                    $identical_permissions[] = $permission;
                }
            }
            if (empty($identical_permissions)) {// if user dose not have any permissions from required permissions => return exception
                throw UnauthorizedException::forPermissions($permissions);
            }
            return $identical_permissions;
        }else{
            return ['super-admin'];
        }
    }

    function checkAbility(string $permission, array $permissions)
    {
        //if the require permission exists in user permissions
        if(in_array($permission, $permissions) || $permissions[0] == 'super-admin')
        {
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
        $cart = [];
        $cart['count'] = Cart::session('cart')->getContent()->count();
        $cart['total'] = Cart::session('cart')->getTotal();
        $cart['subTotal'] = Cart::session('cart')->getSubTotal();
        $cart_collection = Cart::session('cart')->getContent()->reverse();
        foreach ($cart_collection as $item) {
            $cart['items'][] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'associatedModel' => $item->associatedModel,
                'created_at' => $item->attributes->created_at,

                ];
            }
        return $cart;
    }
