<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharingFolder extends Model
{
    use HasFactory;

    protected $table = 'file_sharing_folders';

    protected $fillable = [
        'root_folder_id',
        'parent_id',
        'name',
    ];

    public function rootFolder()
    {
        return $this->belongsTo(FileSharingRootFolder::class, 'root_folder_id');
    }

    public function parent()
    {
        return $this->belongsTo(FileSharingFolder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(FileSharingFolder::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(FileSharingFile::class, 'folder_id');
    }
}
