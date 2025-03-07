<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuAccessControl extends Model
{
    use HasFactory;
    protected $table = 'mcu_access_controls';

    protected $fillable = [
        'participant_id', // Relasi ke peserta MCU
        'folder_id',      // Relasi ke folder pasien
        'is_active',      // Status aktif/nonaktif
        'expired_at'      // Tanggal kadaluarsa akses
    ];

    public function participant()
    {
        return $this->belongsTo(McuParticipant::class, 'participant_id');
    }

    public function folder()
    {
        return $this->belongsTo(McuFolder::class, 'folder_id');
    }
}
