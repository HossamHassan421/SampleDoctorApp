<?php

namespace App\Http\Requests\DoctorApp\Doctor;

use App\Rules\MobileLength;
use Illuminate\Foundation\Http\FormRequest;

class DeleteAccountRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => 'required',
            'delete_reason' => 'required',
        ];
    }
}
