<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'reservation_status_id',
        'service_category_id',
        'status_pembayaran',
        'code',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function status()
    {
        return $this->belongsTo(ReservationStatus::class, 'reservation_status_id');
    }

    public function doctorConsultationReservation()
    {
        return $this->hasOne(DoctorConsultationReservation::class, 'reservation_id');
    }

    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class, 'reservation_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'reservation_id');
    }

    // Cascade soft delete untuk relasi terkait
    protected static function booted()
    {
        static::deleting(function ($reservation) {
            // Soft delete data terkait
            $reservation->doctorConsultationReservation()->delete();
            $reservation->paymentRecords()->delete();
            $reservation->invoice()->delete();

            // Log pembatalan
            ReservationLog::create([
                'reservation_id' => $reservation->id,
                'user_id' => auth()->id(),
                'patient_name' => $reservation->patient->name,
                'user_name' => auth()->user()->name,
                'reason' => 'Reservasi dibatalkan.',
            ]);
        });
    }
}
