<?php

namespace App\Http\Controllers;

use App\Models\PatientScreeningResponse;
use App\Models\ScreeningQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScreeningResponseController extends Controller
{
    public function showQuestions()
    {
        $questions = ScreeningQuestion::with('options')->get();
        return view('screening_responses.index', compact('questions'));
    }

    public function storeResponses(Request $request)
    {
        $patientId = Auth::user()->patient->id;

        // Validasi input
        $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'required|integer'
        ]);

        // Menyimpan jawaban untuk setiap pertanyaan
        foreach ($request->responses as $questionId => $optionId) {
            PatientScreeningResponse::create([
                'patient_id' => $patientId,
                'question_id' => $questionId,
                'option_id' => $optionId
            ]);
        }

        return redirect()->route('screening_results.show')->with('success', 'Jawaban berhasil disimpan.');
    }
}
