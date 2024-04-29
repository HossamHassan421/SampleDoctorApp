<?php

namespace App\Http\Requests\DoctorApp\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|max:30',
            'email' => 'email|unique:doctors,email,'.\Auth::guard('api-doctor')->user()->uuid.',' . 'uuid',
            'gender' => 'in:1,2',

        ];
    }
}
