<?php

namespace App\Http\Resources;

use App\Models\Schedule;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'doctor' => $this->doctor,
            'patient' => $this->patient,
            'appointment' => $this->appointment,
            'symptoms' =>$this->symptoms,
            'diagnosis' => $this->diagnosis,
            'prescription' => $this->prescription,
//            $this->mergeWhen($this->appointment->schedule_id, function (){
//                return [
//                    'schedule' => $this->appointment->load('schedule'),
//                ];
//            })
        ];
    }
}
