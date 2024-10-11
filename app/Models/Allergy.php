<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    use HasFactory;

    // Definisikan nama tabel (jika nama tabel tidak mengikuti konvensi Laravel)
    protected $table = 'allergies';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'name',
        'patient_id',
    ];

    // Definisikan hubungan dengan model `Patient`
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
