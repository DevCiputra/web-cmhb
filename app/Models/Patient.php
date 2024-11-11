<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'medical_record_id',
        'user_id',
        'profile_picture',
        'dob', 
        'gender',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function bloodGroup()
    {
        return $this->hasOne(BloodGroup::class); // Ubah menjadi hasOne
    }

    public function allergies()
    {
        return $this->hasMany(Allergy::class); // Tetap menggunakan hasMany jika satu pasien memiliki lebih dari satu alergi
    }
}
