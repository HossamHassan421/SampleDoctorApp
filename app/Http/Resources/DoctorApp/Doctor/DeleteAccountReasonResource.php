<?php

namespace App\Http\Resources\DoctorApp\Doctor;

use App\Http\Resources\BaseResource;

class DeleteAccountReasonResource extends BaseResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "reason_en" => $this->reason_en,
            "reason_ar" => $this->reason_ar,
        ];
    }
}
