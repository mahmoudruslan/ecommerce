<?php

namespace App\Traits;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;


trait Helper
{
    public function checkAbility(array $permissions)
    {

        $user_id = auth()->id();
        $user = User::findOrFail($user_id);
        if(!($user->hasAnyPermission($permissions) || $user->hasRole('super-admin'))){
            throw UnauthorizedException::forPermissions($permissions);
        }
        return true;
    }

    public function userHasPermission($permission)
    {
        $user_id = auth()->id();
        $user = User::findOrFail($user_id);
        if(!($user->hasAnyPermission([$permission]) || $user->hasRole('super-admin'))){
            return false;
        }
        return true;
    }

}

