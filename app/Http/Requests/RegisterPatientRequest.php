<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterPatientRequest extends RegisterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
//                Password::min(8)->mixedCase()->numbers()
            ],
            'phone' => 'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/u',
            'gender' => 'required|in:men,women',
            'address' => 'nullable'
        ];
        return array_merge(parent::rules(), $rules);
    }
}
