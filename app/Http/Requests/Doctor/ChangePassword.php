<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'uuid' => 'required|max:36',
            'password' => 'required|min:8|confirmed',
        ];
    }
}
