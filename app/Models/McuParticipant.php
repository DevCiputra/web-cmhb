<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuParticipant extends Model
{
    use HasFactory;
    protected $table = 'mcu_participants';

    protected $fillable = [
        'company_id',
        'name',       // Nama Pasien
        'birth_date', // Tanggal Lahir
        'username',   // Username untuk autentikasi
        'password',   // Password untuk autentikasi (simpan hash)
        'email'       // Opsional
    ];

    public function company()
    {
        return $this->belongsTo(McuCompany::class, 'company_id');
    }

    public function accessControl()
    {
        return $this->hasOne(McuAccessControl::class, 'participant_id');
    }
}
