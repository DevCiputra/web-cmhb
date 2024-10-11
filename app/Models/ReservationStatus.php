<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'class'];

    public function statuses()
    {
        return $this->hasMany(Reservation::class);
    }
}
