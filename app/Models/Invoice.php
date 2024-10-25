<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['reservation_id', 'invoice_number', 'total_amount', 'payment_status'];

    // Relasi dengan model Reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
