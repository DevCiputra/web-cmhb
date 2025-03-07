<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuFileAccessLogActivity extends Model
{
    use HasFactory;
    protected $table = 'mcu_file_access_log_activities';

    // Nonaktifkan timestamps default Laravel karena kita hanya memakai created_at
    public $timestamps = false;

    protected $fillable = [
        'participant_id',
        'folder_id',
        'file_id',
        'action',
        'user_agent',
        'ip_address',
        'created_at'
    ];

    // Relasi ke peserta
    public function participant()
    {
        return $this->belongsTo(McuParticipant::class, 'participant_id');
    }

    // Relasi ke folder
    public function folder()
    {
        return $this->belongsTo(McuFolder::class, 'folder_id');
    }

    // Relasi ke file (opsional)
    public function file()
    {
        return $this->belongsTo(McuFile::class, 'file_id');
    }
}
