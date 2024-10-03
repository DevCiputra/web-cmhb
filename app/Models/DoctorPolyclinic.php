<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPolyclinic extends Model
{
    use HasFactory;

    protected $table = 'doctor_polyclinics';

    protected $fillable = ['name'];

    // Relasi ke tabel Doctor
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'doctor_polyclinic_id');
    }

    public static function search($query)
    {
        return self::where('name', 'LIKE', "%{$query}%"); // Pencarian berdasarkan nama poliklinik
    }
    
    
}
