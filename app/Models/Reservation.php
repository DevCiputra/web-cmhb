<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'reservation_status_id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function status()
    {
        return $this->belongsTo(ReservationStatus::class);
    }

    public function doctorConsultation()
    {
        return $this->hasOne(DoctorConsultationReservation::class);
    }
}
