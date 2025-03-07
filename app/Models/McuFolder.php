<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuFolder extends Model
{
    use HasFactory;
    protected $table = 'mcu_folders';

    protected $fillable = [
        'company_id',
        'name',        // Nama Folder (MCU_TANGGAL atau NamaPeserta_TanggalLahir)
        'folder_type'  // Jenis Folder: 'MCU' atau 'Patient'
    ];

    public function company()
    {
        return $this->belongsTo(McuCompany::class, 'company_id');
    }

    public function files()
    {
        return $this->hasMany(McuFile::class, 'folder_id');
    }
}
