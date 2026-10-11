<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consultation;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $consultations = Consultation::with('patient')->latest()->get();
        return response()->json($consultations,200);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required',
            'date' => 'required',
            'type_consultation' => 'required',
            'symptoms' => 'required',
            'notes' => 'nullable',
            'diagnosis' => 'required',
            'temperature' => 'nullable',
            'heart_rate' => 'nullable',
            'weight' => 'nullable',
            'height' => 'nullable',
            'blood_pressure' => 'nullable',
            'repos' => 'nullable',
        ]);

        $validated['user_id'] = auth()->id();
        $consultation = Consultation::create($validated);
        return response()->json($consultation,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $consultation = Consultation::find($id);
        $consultation->patient()->get();
        $consultation->user()->get();
        return response()->json($consultation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $consultation = Consultation::find($id);
        $consultation->update($request->all());
        $consultation->user()->associate($request->user());
        $consultation->patient()->associate($request->patient());
        $consultation->save();
        return response()->json($consultation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $consultation = Consultation::find($id);
        $consultation->delete();
        
        return response()->json($consultation);
    }
}
