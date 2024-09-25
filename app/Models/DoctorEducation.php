<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorEducation extends Model
{
    use HasFactory;

    protected $table = 'doctor_educations';

    protected $fillable = ['name'];

    // Relasi ke dokter
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
