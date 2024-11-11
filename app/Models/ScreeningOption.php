<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScreeningOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['question_id', 'option_text', 'weight'];

    // Model ScreeningOption.php
    public function question()
    {
        return $this->belongsTo(ScreeningQuestion::class, 'question_id');
    }
}
