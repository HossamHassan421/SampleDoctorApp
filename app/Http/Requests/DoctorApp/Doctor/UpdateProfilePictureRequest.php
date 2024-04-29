<?php

namespace App\Http\Requests\DoctorApp\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePictureRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' =>'required|mimes:jpeg,jpg,png|max:5120',
        ];
    }
}
