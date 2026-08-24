<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with([
            'patient',
            'doctor.user',
        ]);

        if ($request->filled('date')) {
            $query->whereDate(
                'appointment_date',
                $request->date
            );
        }

        if ($request->filled('doctor_id')) {
            $query->where(
                'doctor_id',
                $request->doctor_id
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $appointments = $query
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $appointments,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => [
                'required',
                'exists:patients,id'
            ],

            'doctor_id' => [
                'required',
                'exists:doctors,id'
            ],

            'appointment_date' => [
                'required',
                'date'
            ],

            'start_time' => [
                'required',
                'date_format:H:i'
            ],

            'end_time' => [
                'nullable',
                'date_format:H:i',
                'after:start_time'
            ],

            'status' => [
                'nullable',
                'in:pending,confirmed,completed,cancelled,no_show'
            ],

            'reason' => [
                'nullable',
                'string'
            ],

            'notes' => [
                'nullable',
                'string'
            ],
        ]);

        $appointment = Appointment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'data' => $appointment->load([
                'patient',
                'doctor.user'
            ]),
        ], 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json([
            'success' => true,
            'data' => $appointment->load([
                'patient',
                'doctor.user',
                'consultation',
            ]),
        ]);
    }

    public function update(
        Request $request,
        Appointment $appointment
    ) {
        $validated = $request->validate([
            'appointment_date' => ['sometimes', 'date'],
            'start_time' => ['sometimes', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'status' => [
                'sometimes',
                'in:pending,confirmed,completed,cancelled,no_show'
            ],
            'reason' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $appointment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Appointment updated successfully',
            'data' => $appointment->fresh(),
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully',
        ]);
    }
}