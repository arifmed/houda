<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'user_id',
        'type_consultation',
        'date',
        'symptoms',
        'diagnosis',
        'notes',
        'temperature',
        'heart_rate',
        'weight',
        'height',
        'blood_pressure',
        'repos',
        
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
