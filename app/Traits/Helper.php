<?php

namespace App\Traits;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;

trait Helper
{
    protected function getUser()
    {
        $user_id = auth()->id();
        return User::find($user_id);
    }

    public function checkAbility(array $permissions)
    {
        $user = $this->getUser();
        if(!($user->hasAnyPermission($permissions) || $user->hasRole('super-admin'))){
            throw UnauthorizedException::forPermissions($permissions);
        }
        return true;
    }

    public function actionsAbility($table)
    {
        $actions = ['update' => true, 'show' => true, 'delete' => true];

        $user = $this->getUser();
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
