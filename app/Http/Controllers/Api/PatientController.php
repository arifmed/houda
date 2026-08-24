<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Resources\PatientResource;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(20);

        return response()->json([
    'success' => true,
    'message' => 'Patients retrieved successfully',

    'data' => PatientResource::collection(
        $patients->items()
    ),

    'meta' => [
        'current_page' => $patients->currentPage(),
        'per_page' => $patients->perPage(),
        'total' => $patients->total(),
        'last_page' => $patients->lastPage(),
    ],
]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'emergency_phone' => ['nullable', 'string', 'max:20'],
            'allergies' => ['nullable', 'string'],
        ]);

        $patient = Patient::create($validated);

        return response()->json([
    'success' => true,
    'message' => 'Patient created successfully',

    'data' => new PatientResource($patient),
], 201);
    }

    public function show(Patient $patient)
    {
        return response()->json([
    'success' => true,
    'message' => 'Patient details retrieved successfully',

    'data' => new PatientResource(
        $patient->load([
            'appointments',
            'consultations',
            'prescriptions',
        ])
    ),
]);
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'emergency_phone' => ['nullable', 'string', 'max:20'],
            'allergies' => ['nullable', 'string'],
        ]);

        $patient->update($validated);

        return response()->json([
    'success' => true,
    'message' => 'Patient updated successfully',

    'data' => new PatientResource($patient),
]);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

       return response()->json([
    'success' => true,
    'message' => 'Patient deleted successfully',
]);
    }
}