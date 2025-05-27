<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPhoto extends Model
{
    use HasFactory;
    protected $table = 'doctor_photos';

    protected $fillable = [
        'doctor_id',
        'name',
        'mime_type',
    ];

    public function getNameAttribute($value)
    {
        if ($value) {
            return secure_url("storage/doctor/photos/$this->doctor_id/$value");
        }
        return null;
    }

    // Relasi ke model Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
