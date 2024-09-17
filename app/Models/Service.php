<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'service_category_id', 'address', 'is_published', 'price'];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function medias()
    {
        return $this->hasMany(ServiceMedia::class);
    }

    public function logs()
    {
        return $this->hasMany(ServiceLog::class);
    }
}
