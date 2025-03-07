<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuCompany extends Model
{
    use HasFactory;
    protected $table = 'mcu_companies';

    protected $fillable = [
        'name',
        'package_name',      // Nama Paket MCU
        'responsible_person' // Penanggung Jawab
    ];

    public function folders()
    {
        return $this->hasMany(McuFolder::class, 'company_id');
    }

    public function participants()
    {
        return $this->hasMany(McuParticipant::class, 'company_id');
    }
}
