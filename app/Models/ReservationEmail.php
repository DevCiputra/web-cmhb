<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationEmail extends Model
{
    use HasFactory;

    protected $fillable = ['status_reservation', 'email'];
}
