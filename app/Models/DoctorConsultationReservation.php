<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorConsultationReservation extends Model
{
    use HasFactory;

    protected $table = 'doctor_consultation_reservations';

    protected $fillable = [
        'reservation_id',
        'doctor_id',
        'preferred_consultation_date',
        'preferred_consultation_time',
        'payment_proof',
        'zoom_link',
        'zoom_password',
    ];

    // Definisikan relasi ke tabel reservations
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    // Definisikan relasi ke tabel doctors
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
