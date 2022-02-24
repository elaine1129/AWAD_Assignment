<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'id'=>$this->id,
            'patient'=>$this->patient->only('name','id','email'),
            'doctor'=>$this->doctor->only('name','id'),
            'schedule'=>$this->when($this->schedule, $this->schedule),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'timeslot' => $this->when($this->schedule, $this->timeslot),
            'condition' =>$this->condition,
        ];
        
    }

}
