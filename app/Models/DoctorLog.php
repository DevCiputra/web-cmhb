<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorLog extends Model
{
    use HasFactory;

    protected $table = 'doctor_logs';

    protected $fillable = [
        'doctor_id',
        'action',
        'action_by',
    ];

    // Relasi ke model Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
