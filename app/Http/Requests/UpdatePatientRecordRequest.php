<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRecordRequest extends FormRequest
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
        return [
            "doctor_id"=>'exclude',
            "patient_id"=> 'exclude',
            "appointment_id" => 'nullable|exists:App\Models\Appointment,id',
            "symptoms" => 'required|string',
            "diagnosis" => 'required|string',
            "prescription" => 'required|string',
        ];
    }
}
