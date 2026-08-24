<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,

            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),

            'gender' => $this->gender,

            'phone' => $this->phone,
            'email' => $this->email,

            'address' => $this->address,

            'blood_type' => $this->blood_type,

            'emergency_contact' => $this->emergency_contact,
            'emergency_phone' => $this->emergency_phone,

            'allergies' => $this->allergies,

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}