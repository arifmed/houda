<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
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
            'gender' => 'required|in:male,female,M,F,Homme,Femme',
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:200'],
            'allergies' => ['nullable', 'string'],
            'chronic_diseases' => ['nullable', 'string'],
        ]);

        $patient = Patient::create($validated);
        $patient->user()->associate($request->user());
        $patient->save();
        return response()->json($patient, 201);
    }

    public function show($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            
            return response()->json($patient);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found',
            ], 404);
        }
    }
    

    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);
        $patient->update($request->all());
        $patient->user()->associate($request->user());
        $patient->save();
        return response()->json($patient, 200);
    }

    public function destroy($id)
{
    $patient = Patient::find($id);

    // التحقق مما إذا كان المريض غير موجود
    if (!$patient) {
        return response()->json([
            'success' => false,
            'message' => 'المريض غير موجود أو تم حذفه مسبقاً.'
        ], 404);
    }

    $patient->delete();

    return response()->json([
        'success' => true,
        'message' => 'تم حذف المريض بنجاح.',
        'data' => $patient
    ], 200);
}
}