<?php

namespace App\Http\Resources\DoctorApp\Doctor;

use App\Http\Resources\BaseResource;

class InfoResource extends BaseResource
{

    public function toArray($request)
    {
        $role = '';
        if($this->type=='1'){
            $role = 'doctor';
        }elseif($this->type=='2'){
            $role = 'groomer';
        }
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "image" => $this->profilePicture(),
            "is_active" => $this->is_active,
            "is_verified" => $this->is_verified,
            "roles" => [$role],
            "credit" => floatval($this->credit),
            "debit" => floatval($this->debit),
        ];
    }
}
