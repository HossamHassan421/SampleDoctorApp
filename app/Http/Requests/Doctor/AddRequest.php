<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:doctors,email',
            'mobile' => 'required|digits_between:9,11|unique:doctors,mobile',
            'doctor_percentage_fees' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'schedule_type' => 'required|in:1,2,3,4',
            'working_schedule' => 'required|array',

        ];
    }
}
