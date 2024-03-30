<?php

namespace App\Traits;
use App\Models\User;
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
    }

}

