<?php

namespace App\Http\Requests\DoctorApp\Doctor;

use App\Rules\MobileLength;
use App\Rules\MobileUniqueCustom;
use App\Rules\UpdateProfileMobileUniqueDoctor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMobileRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'country_code' => 'in:sa,eg,SA,EG',
            'mobile' => [ new MobileLength(),new UpdateProfileMobileUniqueDoctor()],
        ];
    }
}
