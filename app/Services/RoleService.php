<?php

namespace App\Services;


use App\Models\Permission;
use App\Models\PermissionAction;
use App\Models\Role;
use App\Models\RolePermissionActions;
use App\Models\UserRole;
use App\Services\UserService;
use Illuminate\Validation\ValidationException;

class RoleService
{
    public static function create($data)
    {

        \DB::beginTransaction();
        try {
            $model = new Role;
            $model->created_by = auth()->user()->id;
            $model = self::buildModel($model, $data);
            $model->save();

            self::saveToRolePermissionAction($data, $model);

            \DB::commit();
            return $model;
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
            return false;
        }
    }

    private static function buildModel($model, $data)
    {
        $model->name = $data->name;
        $restrictions = array_keys($data->restrictions_checked, '0');
        if (!empty($restrictions)) {
            $model->restrictions = $restrictions;
        } else {
            $model->restrictions = null;
        }
        return $model;
    }

    public static function edit($uuid)
    {
        $model = Role::where('uuid', $uuid)->firstOrFail();
        return $model;
    }

    public static function update($data)
    {
        \DB::beginTransaction();
        try {
            $model = Role::where('uuid', $data->uuid)->firstOrFail();
            $model->updated_by = auth()->user()->id;
            $model = self::buildModel($model, $data);
            $model->save();

            self::saveToRolePermissionAction($data, $model);

            \DB::commit();
            return $model;
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
            return false;
        }
    }

    public static function listing($model, $request)
    {
        $restrictions = UserService::getRestrictions();
        if ($restrictions != null) {
            $permission = Permission::where('name', 'role')->first();

            if (in_array($permission->uuid, $restrictions))
                $model = $model->accessibility();
        }
        $model = self::search($model, $request);
        $model = $model->sortable()->orderByDesc('id')->paginate(20);
        return $model;
    }

    public static function listingAll()
    {
        $model = Role::all();
        return $model;
    }

    private static function search($model, $request)
    {
        if ($request->name != '') {
            $model = $model->where('name', 'like', '%' . $request->name . '%');
        }
        return $model;
    }

    public static function deleteRecord($request)
    {
        $record = Role::where('uuid', $request->uuid)->firstOrFail();
        if ($record->users()->exists()) {
            throw ValidationException::withMessages(['related_user_exist_error' => trans('errors.related_user_exist_error')]);
        }
        $rolePermissionActions = RolePermissionActions::where('role_id', $record->id)->get();
        $rolePermissionActions->each->delete();
        $record->delete();
    }

    private static function saveToRolePermissionAction($data, $model)
    {
        $listOfIds = [];
        $user = \Auth::user();
        if ($user->is_super == 1)
            $rolePermissionActions = 'all';
        else {
            $rolePermissionActions = RolePermissionActions::whereIn('role_id', $user->roles->pluck('id'))
                ->groupBy('permission_actions_id')
                ->pluck('permission_actions_id');
        }


        foreach ($data['permission_actions'] as $permissionActionUuid) {
            $record = PermissionAction::where('uuid', $permissionActionUuid)->first();
            if ($rolePermissionActions != 'all') {
                if (!$rolePermissionActions->contains($record->id)) {
                    continue;
                }
            }

            $rolePermissionAction = RolePermissionActions::firstOrCreate(
                [
                    'role_id' => $model->id,
                    'permission_actions_id' => $record->id,
                ]
            );

            $rolePermissionAction->save();
            $listOfIds[] = $rolePermissionAction->id;
        }

        RolePermissionActions::where('role_id', $model->id)
            ->whereNotIn('id', $listOfIds)
            ->delete();
    }
}
