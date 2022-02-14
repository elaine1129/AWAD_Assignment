<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Support\Facades\Gate;

class RegisterDoctorRequest extends RegisterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('admin-access');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'expertise' => 'string|nullable',
            'image' => 'nullable|image',
        ];
        return array_merge(parent::rules(), $rules);
    }
}
