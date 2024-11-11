<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientScreeningResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['answered_id', 'question_id', 'option_id'];

    public function answered()
    {
        return $this->belongsTo(AnsweredScreening::class, 'answered_id');
    }

    public function question()
    {
        return $this->belongsTo(ScreeningQuestion::class, 'question_id');
    }

    public function option()
    {
        return $this->belongsTo(ScreeningOption::class, 'option_id');
    }

    // Memperbaiki metode untuk menghitung skor berdasarkan kategori
    public function calculateScore($answeredScreeningId, $category)
    {
        // Ambil semua jawaban berdasarkan kategori yang sesuai
        $responses = $this->whereHas('question.category', function ($query) use ($category) {
            $query->where('name', $category);
        })->where('answered_id', $answeredScreeningId)->get();

        // Hitung total skor
        $totalScore = $responses->sum(fn($response) => $response->option->weight);

        // Klasifikasi berdasarkan total skor
        if ($totalScore == 0) {
            return ['score' => $totalScore, 'classification' => 'Normal'];
        }

        $classification = ScreeningClassification::where('category_name', $category)
            ->where('min_score', '<=', $totalScore)
            ->where('max_score', '>=', $totalScore)
            ->first();

        return [
            'score' => $totalScore,
            'classification' => $classification->classification_name ?? 'Tidak Diketahui',
        ];
    }
}
