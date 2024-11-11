<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnsweredScreening extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'stress_score',
        'stress_classification',
        'depression_score',
        'depression_classification',
        'anxiety_score',
        'anxiety_classification',
        'total_distress_score',
        'total_distress_classification'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function responses()
    {
        return $this->hasMany(PatientScreeningResponse::class, 'answered_id');
    }
}
