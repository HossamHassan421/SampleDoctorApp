<?php

namespace App\Http\Requests\DoctorApp\Doctor;

use App\Rules\MobileLength;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'uuid' => 'required',
            'otp' => 'required|digits:4',
        ];
    }
}
