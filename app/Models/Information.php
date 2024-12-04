<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'special_information',
        'is_published',
        'information_category_id',
        'created_by',
        'published_at',
    ];

    public function category()
    {
        return $this->belongsTo(InformationCategory::class, 'information_category_id');
    }

    public function media()
    {
        return $this->hasMany(ServiceMedia::class);
    }
}
