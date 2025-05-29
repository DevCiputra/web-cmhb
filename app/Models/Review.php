<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'rating',
        'message',
        'name_pasien'
    ];

    public function doctors() {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    // ✅ OPTION 2: Proper Eloquent Relationship (Lebih Bagus)
    public function getDoctorUserAttribute()
    {
        return $this->doctors?->user ?? collect();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('UTC')->setTimezone('Asia/Makassar')->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('UTC')->setTimezone('Asia/Makassar')->format('Y-m-d H:i');
    }
}
