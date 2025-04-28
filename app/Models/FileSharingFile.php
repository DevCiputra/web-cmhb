<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharingFile extends Model
{
    use HasFactory;

    protected $table = 'file_sharing_files';

    protected $fillable = [
        'folder_id',
        'file_name',
        'file_path',
        'uploaded_by',
    ];

    public function folder()
    {
        return $this->belongsTo(FileSharingFolder::class, 'folder_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
