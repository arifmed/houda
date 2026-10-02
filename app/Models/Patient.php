<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'address',
        'blood_type',
        'emergency_contact',
        'emergency_phone',
        'allergies',
        'chronic_diseases',
        'user_id',
        
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function labResults()
    {
        return $this->hasMany(LabResult::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}