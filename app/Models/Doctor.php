<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization_name',  // Data denormalisasi
        'doctor_education_id',  // Foreign key
        'doctor_polyclinic_id', // Foreign key
    ];

    // Relasi ke tabel DoctorEducation (normalisasi)
    public function education()
    {
        return $this->belongsTo(DoctorEducation::class, 'doctor_education_id');
    }

    // Relasi ke tabel DoctorPolyclinic (normalisasi)
    public function polyclinic()
    {
        return $this->belongsTo(DoctorPolyclinic::class, 'doctor_polyclinic_id');
    }
}
