<?php

namespace App\Http\Controllers;

use App\Models\AnsweredScreening;
use App\Models\PatientScreeningResponse;
use App\Models\ScreeningClassification;
use App\Models\ScreeningQuestion;
use Illuminate\Http\Request;

class ScreeningResultController extends Controller
{

    public function showForm(Request $request)
    {
        // if (!$request->hasValidSignature()) {
        //     abort(403, 'Unauthorized access.');
        // }

        $title = "Form Skrining Depresi";
        $questions = ScreeningQuestion::with('options')->get();
        return view('landing-page.contents.screening.index', compact('questions', 'title'));
    }

    public function submitAnswers(Request $request)
    {
        $user = auth()->user();
        if (!$user || !$user->patient) {
            return redirect()->back()->withErrors('Pasien tidak ditemukan. Pastikan Anda login sebagai pasien.');
        }

        $patientId = $user->patient->id;
        $answers = $request->input('answers');

        // Membuat record untuk answered screening
        $answeredScreening = AnsweredScreening::create(['patient_id' => $patientId]);

        // Menyimpan jawaban pasien
        foreach ($answers as $questionId => $optionId) {
            PatientScreeningResponse::create([
                'answered_id' => $answeredScreening->id,
                'question_id' => $questionId,
                'option_id' => $optionId,
            ]);
        }

        // Mendapatkan jawaban pasien untuk menghitung skor
        $patientScreeningResponse = new PatientScreeningResponse();

        $stress = $patientScreeningResponse->calculateScore($answeredScreening->id, 'Stress');
        $anxiety = $patientScreeningResponse->calculateScore($answeredScreening->id, 'Anxiety');
        $depression = $patientScreeningResponse->calculateScore($answeredScreening->id, 'Depression');

        // Menghitung skor total distress
        $totalDistressScore = $stress['score'] + $anxiety['score'] + $depression['score'];

        // Klasifikasi total distress score
        $totalDistressClassification = $this->classifyDistressScore($totalDistressScore);

        // Update record answered screening dengan hasil
        $answeredScreening->update([
            'stress_score' => $stress['score'],
            'stress_classification' => $stress['classification'],
            'anxiety_score' => $anxiety['score'],
            'anxiety_classification' => $anxiety['classification'],
            'depression_score' => $depression['score'],
            'depression_classification' => $depression['classification'],
            'total_distress_score' => $totalDistressScore,
            'total_distress_classification' => $totalDistressClassification,
        ]);

        return redirect()->route('showResult', ['answeredId' => $answeredScreening->id]);
    }

    private function classifyDistressScore($totalDistressScore)
    {
        if ($totalDistressScore <= 16) {
            return 'Normal';
        } elseif ($totalDistressScore <= 20) {
            return 'Ringan';
        } elseif ($totalDistressScore <= 25) {
            return 'Sedang';
        } elseif ($totalDistressScore <= 29) {
            return 'Berat';
        } else {
            return 'Sangat Berat';
        }
    }

    public function showResult($answeredId)
    {
        $title = "Hasil Skrining Psikologi";
        $answeredScreening = AnsweredScreening::with('responses.option')->findOrFail($answeredId);

        $result = [
            'stress' => [
                'score' => $answeredScreening->stress_score,
                'classification' => $answeredScreening->stress_classification
            ],
            'anxiety' => [
                'score' => $answeredScreening->anxiety_score,
                'classification' => $answeredScreening->anxiety_classification
            ],
            'depression' => [
                'score' => $answeredScreening->depression_score,
                'classification' => $answeredScreening->depression_classification
            ],
            'total_distress' => [
                'score' => $answeredScreening->total_distress_score,
                'classification' => $answeredScreening->total_distress_classification
            ]
        ];

        // Menambahkan saran dan URL berdasarkan klasifikasi total_distress
        if ($result['total_distress']['classification'] === 'Ringan' || $result['total_distress']['classification'] === 'Sedang') {
            $suggestion = "Silakan konsultasi dengan psikolog / psikiater bila keluhan belum membaik.";
            $onlineConsultationUrl = route('onlineconsultation.landing');
        } elseif ($result['total_distress']['classification'] === 'Berat' || $result['total_distress']['classification'] === 'Sangat Berat') {
            $suggestion = "Silakan SEGERA konsultasi dengan psikolog / psikiater.";
            $onlineConsultationUrl = route('onlineconsultation.landing');
        } else {
            $suggestion = "Tidak ada saran khusus, pertahankan kondisi anda.";
            $onlineConsultationUrl = null; // Tidak ada URL jika tidak perlu konsultasi
        }

        return view('landing-page.contents.screening.result', compact('result', 'title', 'answeredScreening', 'suggestion', 'onlineConsultationUrl'));
    }



    public function showHistory()
    {
        $title = "Riwayat Screening Psikologi";
        $user = auth()->user();

        if (!$user || !$user->patient) {
            return redirect()->back()->withErrors('Anda harus login sebagai pasien.');
        }

        $patientId = $user->patient->id;
        $histories = AnsweredScreening::where('patient_id', $patientId)->with(['responses.question', 'responses.option'])->get();

        return view('landing-page.contents.screening.history', compact('histories', 'title'));
    }
}
