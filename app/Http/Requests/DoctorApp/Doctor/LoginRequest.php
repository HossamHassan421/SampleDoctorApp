<?php

namespace App\Http\Requests\DoctorApp\Doctor;

use App\Rules\MobileLength;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            // 'email' => 'required',
            // 'password' => 'required',
            'country_code' => 'required|in:sa,eg,SA,EG',
            'mobile' => ['required', new MobileLength()],
        ];

    }
}
