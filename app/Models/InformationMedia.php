<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'information_media';

    protected $fillable = [
        'information_id',
        'file_name',
        'mime_type',
        'file_url',
    ];

    // Relasi ke Information
    public function information()
    {
        return $this->belongsTo(Information::class);
    }
}
