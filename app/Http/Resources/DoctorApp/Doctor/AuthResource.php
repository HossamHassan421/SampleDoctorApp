<?php

namespace App\Http\Resources\DoctorApp\Doctor;

use App\Http\Resources\BaseResource;

class AuthResource extends BaseResource
{

    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "image" => $this->profilePicture(),
            "is_active" => $this->is_active,
            "is_verified" => $this->is_verified,
            "reset_password_flag" => $this->reset_password_flag,
            "token" => $this->createToken('doctor_user_token')->accessToken,
        ];
    }
}
