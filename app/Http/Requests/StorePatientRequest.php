<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:100'
            ],

            'last_name' => [
                'required',
                'string',
                'max:100'
            ],

            'date_of_birth' => [
                'nullable',
                'date'
            ],

            'gender' => [
                'nullable',
                'in:male,female,other'
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30'
            ],

            'email' => [
                'nullable',
                'email'
            ],

            'address' => [
                'nullable',
                'string'
            ],

            'blood_type' => [
                'nullable',
                'string'
            ],

            'emergency_contact' => [
                'nullable',
                'string'
            ],

            'emergency_phone' => [
                'nullable',
                'string'
            ],

            'allergies' => [
                'nullable',
                'string'
            ],
        ];
    }
}