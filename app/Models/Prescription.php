<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'medication_id',
        'patient_id',
        'consultation_id',
        'dosage',
        'frequency',
        'duration',
        'instructions',
    ];



    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }


}