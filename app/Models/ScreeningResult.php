<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScreeningResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['patient_id', 'total_score', 'classification'];

    // Menghubungkan ke pasien
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Menentukan klasifikasi berdasarkan total_score
    public function classification()
    {
        return $this->belongsTo(ScreeningClassification::class);
    }
}
