<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DoctorPhoto extends Model
{
    use HasFactory;
    protected $table = 'doctor_photos';

    protected $fillable = [
        'doctor_id',
        'name',
        'mime_type',
    ];

    // Relasi ke model Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function getNameAttribute($value)
    {
        if ($value) {
            return Storage::url("/doctor/photos/$this->doctor_id/$value");
        }
        return null;
    }

}
