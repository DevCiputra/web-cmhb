<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuFile extends Model
{
    use HasFactory;
    protected $table = 'mcu_files';

    protected $fillable = [
        'folder_id',
        'file_name',   // Nama file PDF
        'file_path',   // Lokasi penyimpanan file
        'uploaded_by'  // ID User yang mengupload (relasi ke tabel users)
    ];

    public function folder()
    {
        return $this->belongsTo(McuFolder::class, 'folder_id');
    }
}
