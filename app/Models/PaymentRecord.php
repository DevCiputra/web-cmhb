<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'payment_method',
        'payment_proof',
        'payment_confirmation_date',
    ];

    // Relasi dengan model Reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
