<?php

namespace App\Http\Resources\DoctorApp\Doctor;

use App\Http\Resources\BaseResource;

class OtpResource extends BaseResource
{

    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
        ];
    }
}
