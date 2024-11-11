<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScreeningClassification extends Model
{
    use HasFactory, SoftDeletes;

    // Pastikan `category_name` sesuai dengan kolom yang Anda tambahkan di migration.
    protected $fillable = ['classification_name', 'min_score', 'max_score', 'category_name'];

    // Relasi ke ScreeningResult
    public function screeningResults()
    {
        return $this->hasMany(ScreeningResult::class);
    }
}
