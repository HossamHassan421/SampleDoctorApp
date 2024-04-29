<?php

namespace App\Http\Resources\DoctorApp\Doctor;

use App\Http\Resources\BaseResource;

class UpdatePasswordSuccessResource extends BaseResource
{

    public function toArray($request)
    {
        return [
            "message" => trans('system.password_changed_successfully'),
        ];
    }
}
