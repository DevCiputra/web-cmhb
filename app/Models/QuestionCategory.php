<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCategory extends Model
{
    use
        HasFactory,
        SoftDeletes;

    protected $fillable = ['name'];

    // Relasi kategori dengan pertanyaan
    public function questions()
    {
        return $this->hasMany(ScreeningQuestion::class, 'category_id');
    }
}
