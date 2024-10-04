<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'specialization_name',  // Data denormalisasi
        'doctor_polyclinic_id', // Foreign key
        'address'
    ];

    // Relasi ke tabel DoctorPolyclinic (normalisasi)
    public function polyclinic()
    {
        return $this->belongsTo(DoctorPolyclinic::class, 'doctor_polyclinic_id');
    }

    // Relasi ke tabel DoctorPhoto
    public function photos()
    {
        return $this->hasMany(DoctorPhoto::class, 'doctor_id');
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }

    // Relasi ke tabel DoctorEducation
    public function education()
    {
        return $this->hasOne(DoctorEducation::class, 'doctor_id');
    }

    public function medias()
    {
        return $this->hasMany(DoctorMedia::class, 'doctor_id');
    }

    public static function search($query)
    {
        return self::with(['polyclinic', 'education'])
        ->where('name', 'LIKE', "%{$query}%")
        ->orWhere('specialization_name', 'LIKE', "%{$query}%")
        ->orWhereHas('polyclinic', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })
            ->orWhereHas('education', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            });
    }
}
