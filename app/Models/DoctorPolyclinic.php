<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DoctorPolyclinic extends Model
{
    use HasFactory;

    protected $table = 'doctor_polyclinics';

    protected $fillable = ['name', 'icon'];

    // public function getIconAttribute($value)
    // {
    //     if ($value) {
    //         return  Storage::url("doctor_polyclinics/" . $value);
    //     }
    //     return null;
    // }

    public function getIconAttribute($value)
    {
        return env('ASSET_URL'). "/uploads/".$value;
    }

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
