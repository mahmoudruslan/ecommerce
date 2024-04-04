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

    public function actionsAbility($table)
    {
        $actions['update'] = true;
        $actions['show'] = true;
        $actions['delete'] = true;
        $user_id = auth()->id();
        $user = User::findOrFail($user_id);
        
        if(!($user->hasAnyPermission('update-'. $table) || $user->hasRole('super-admin'))){
            $actions['update'] = false;
        }
        if(!($user->hasAnyPermission('show-'. $table) || $user->hasRole('super-admin'))){
            $actions['show'] = false;
        }
        if(!($user->hasAnyPermission('delete-'. $table) || $user->hasRole('super-admin'))){
            $actions['delete'] = false;
        }
        return $actions;
    }

}

