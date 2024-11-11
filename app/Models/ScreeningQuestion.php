<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScreeningQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['question_text', 'category_id'];

    public function options()
    {
        return $this->hasMany(ScreeningOption::class, 'question_id');
    }

    public function category()
    {
        return $this->belongsTo(QuestionCategory::class, 'category_id');
    }
}
