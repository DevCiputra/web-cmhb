<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharingRootFolder extends Model
{
    use HasFactory;

    protected $table = 'file_sharing_root_folders';

    protected $fillable = [
        'created_by',
        'role',
        'name',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function folders()
    {
        return $this->hasMany(FileSharingFolder::class, 'root_folder_id');
    }
}
