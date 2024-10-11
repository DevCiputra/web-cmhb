<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'reservation_status_id',
        'service_category_id',
        'status_pembayaran',
        'code',
    ];

    // Relasi dengan model Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relasi dengan model ReservationStatus
    public function status()
    {
        return $this->belongsTo(ReservationStatus::class, 'reservation_status_id');
    }

    // Relasi dengan model DoctorConsultationReservation
    public function doctorConsultationReservation()
    {
        return $this->hasOne(DoctorConsultationReservation::class, 'reservation_id');
    }

    // Relasi dengan model PaymentRecord
    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class, 'reservation_id');
    }
}
