<?php

namespace App\Gates;


use App\Models\PermissionAction;
use App\Models\RolePermissionActions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthGate
{

    static function define()
    {

        Gate::before(function ($user, $ability) {
            if ($user->is_super == 1) {
                return true;
            }
        });

        if (!Schema::hasTable('permission_actions')) {
            return false;
        }
        $permissionActions = PermissionAction::all();
        foreach ($permissionActions as $permissionAction) {
            if (!isset($permissionAction->permission) || !isset($permissionAction->action))
                $flag = false;
            else
                $flag = true;
            $permissionActionIdentifier = ($permissionAction->permission->name) . '-' . ($permissionAction->action->name);
            Gate::define($permissionActionIdentifier, function ($user) use ($permissionAction, $flag) {
                if (!$flag)
                    return false;
                return $rolePermissions = RolePermissionActions::whereIn('role_id', $user->roles->pluck('id'))
                    ->where('permission_actions_id', $permissionAction->id)
                    ->exists();
            });
        }

    }


}
