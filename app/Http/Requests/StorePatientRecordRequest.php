<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StorePatientRecordRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'doctor_id'=>Auth::user()->id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                "doctor_id" => 'required|exists:App\Models\Doctor,id',
                "patient_id" => 'required|exists:App\Models\Patient,id',
                "appointment_id" => 'nullable|exists:App\Models\Appointment,id',
                "symptoms" => 'required|string',
                "diagnosis" => 'required|string',
                "prescription" => 'required|string',

//                "patient-appointments_length"=> 'exclude'
        ];
    }
}
