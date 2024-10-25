<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorConsultationReservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reservation_id',
        'doctor_id',
        'zoom_account_id', // Tambahkan ini
        'preferred_consultation_date',
        'agreed_consultation_date',
        'agreed_consultation_time',
        'zoom_link',
        'zoom_password',
        'zoom_host_link'
    ];

    // Relasi dengan model Reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    // Relasi dengan model Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    // Relasi dengan model ZoomAccount
    public function zoomAccount()
    {
        return $this->belongsTo(ZoomAccount::class, 'zoom_account_id');
    }
}
