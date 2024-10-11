<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    use HasFactory;

    protected $table = 'blood_groups';

    protected $fillable = [
        'name',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class); // Relasi belongsTo karena hanya satu BloodGroup untuk setiap pasien
    }
}
