<?php

namespace App\Http\Requests\DoctorApp\Doctor;

use App\Rules\MobileLength;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password'=>'required',
            'new_password' => 'required|confirmed|string|min:8',
            // 'new_password' => 'required|confirmed|string|min:8|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}$/',
        ];
    }
}
