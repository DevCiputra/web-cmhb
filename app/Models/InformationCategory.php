<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function information()
    {
        return $this->hasMany(Information::class);
    }

    public function isUsed()
    {
        return $this->information()->exists();
    }
}
