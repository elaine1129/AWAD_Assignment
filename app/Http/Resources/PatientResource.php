<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "ic" => $this->data['ic'],
            "phone" => $this->data['phone'],
            "gender" => $this->data['gender'],
            "address" => $this->data['address'],

            "appointments"=>$this->appointment,
            "patient_records"=>$this->patient_records
        ];
    }
}
