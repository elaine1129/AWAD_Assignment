<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientAppointmentRequest extends FormRequest
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
            "doctor_id" => "required|exists:App\Models\Doctor,id",
            "schedule_id" => "required|exists:App\Models\Schedule,id",
            "timeslot" => "required|numeric",
            "condition"=>"required"
        ];
    }
}
