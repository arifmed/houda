<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'appointment_date' =>
                $this->appointment_date?->format('Y-m-d'),

            'start_time' => $this->start_time,
            'end_time' => $this->end_time,

            'status' => $this->status,

            'reason' => $this->reason,
            'notes' => $this->notes,

            'patient' => new PatientResource(
                $this->whenLoaded('patient')
            ),

            'doctor' => new DoctorResource(
                $this->whenLoaded('doctor')
            ),

            'created_at' =>
                $this->created_at?->toISOString(),
        ];
    }
}