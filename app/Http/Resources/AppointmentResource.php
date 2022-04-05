<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'id' => $this->id,
            'patient' => $this->patient->only('name', 'id', 'email'),
            'doctor' => $this->doctor->only('name', 'id'),
            'schedule' => $this->schedule != null ?? $this->when($this->schedule != null, $this->schedule->all()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'date' => $this->when($this->schedule, Carbon::parse($this->date)->format('d/m/Y')),
            'timeslot' => $this->schedule != null ? $this->timeslot : false,
            'time' => $this->schedule != null ? $this->time : false,
            'condition' => $this->condition,
        ];
    }
}
