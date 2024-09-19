<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['service_id', 'name', 'mime_type'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
