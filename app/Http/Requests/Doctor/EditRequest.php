<?php

namespace App\Http\Requests\Doctor;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'uuid' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:doctors,email,'. $this->uuid.',' . 'uuid',
            'mobile' => 'required|numeric|digits_between:9,11|unique:doctors,mobile,'. $this->uuid.',' . 'uuid',
            'doctor_percentage_fees' => 'required',
            'password' => 'nullable|min:8|confirmed',
        ];
    }
}
