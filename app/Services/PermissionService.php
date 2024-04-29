<?php

namespace App\Services;


use App\Models\Action;
use App\Models\Permission;
use App\Models\PermissionAction;

class PermissionService
{
    public static function create($data)
    {
        \DB::beginTransaction();
        try {
            $model = new Permission;
            $model = self::buildModel($model, $data);
            $model->save();

            self::saveToPermissionAction($data, $model);

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
        return $model;
    }

    public static function edit($uuid)
    {
        $model = Permission::where('uuid', $uuid)->firstOrFail();
        return $model;
    }

    public static function update($data)
    {
        \DB::beginTransaction();
        try {
            $model = Permission::where('uuid', $data->uuid)->firstOrFail();
            $model = self::buildModel($model, $data);
            $model->save();

            self::saveToPermissionAction($data, $model);

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
        $model = self::search($model, $request);
        $model = $model->sortable()->orderByDesc('id')->paginate(20);
        return $model;
    }

    public static function listingAll()
    {
        $model = Permission::all();
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
        $record = Permission::where('uuid', $request->uuid)->firstOrFail();
        $permissionAction = PermissionAction::where('permission_id', $record->id)->get();
        $permissionAction->each->delete();
        $record->delete();
    }

    private static function saveToPermissionAction($data, $model)
    {
        $listOfIds = [];
        foreach ($data->actions as $uuid=>$value) {
            $record = Action::where('uuid', $uuid)->firstOrFail();
            $permissionAction = PermissionAction::firstOrCreate(
                [
                    'permission_id' => $model->id,
                    'action_id' => $record->id,
                ]
            );
            $listOfIds[] = $permissionAction->id;
        }
        PermissionAction::where('permission_id', $model->id)
            ->whereNotIn('id', $listOfIds)
            ->delete();
    }



}
