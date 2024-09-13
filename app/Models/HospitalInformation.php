<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalInformation extends Model
{
    use HasFactory;

    protected $table = 'hospital_informations';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'logo',
        'vision',
        'mission',
        'emergency_contact',
        'customer_service_contact'
    ];
}
