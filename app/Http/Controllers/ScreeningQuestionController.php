<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use App\Models\ScreeningOption;
use App\Models\ScreeningQuestion;
use Illuminate\Http\Request;

class ScreeningQuestionController extends Controller
{
    // Menampilkan semua soal skrining
    public function index(Request $request)
    {
        // Mendapatkan semua kategori
        $categories = QuestionCategory::all();

        // Menyaring soal berdasarkan category_id jika parameter ada
        $questions = ScreeningQuestion::with(['options', 'category']);

        if (
            $request->has('category_id') && $request->category_id != ''
        ) {
            $questions = $questions->where('category_id', $request->category_id);
        }

        // Ambil soal berdasarkan kondisi filter
        $questions = $questions->get();

        return view('management-data.screening.question.index', compact('questions', 'categories'));
    }


    public function create()
    {
        $categories = QuestionCategory::all(); // Ambil semua kategori
        return view('management-data.screening.question.create', compact('categories'));
    }

    // Simpan soal skrining baru
    public function store(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'category_id' => 'required|exists:question_categories,id', // Validasi kategori
        ]);

        ScreeningQuestion::create([
            'question_text' => $request->question_text,
            'category_id' => $request->category_id, // Menyimpan kategori
        ]);

        return redirect()->route('screening-depretion.index')->with('success', 'Soal skrining berhasil ditambahkan.');
    }


    // Menampilkan form edit soal
    public function edit($id)
    {
        $question = ScreeningQuestion::with('options', 'category')->findOrFail($id);
        $categories = QuestionCategory::all(); // Ambil semua kategori
        return view('management-data.screening.question.edit', compact('question', 'categories'));
    }

    // Update soal skrining
    public function update(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'category_id' => 'required|exists:question_categories,id', // Validasi kategori
        ]);

        $question = ScreeningQuestion::findOrFail($id);
        $question->update([
            'question_text' => $request->question_text,
            'category_id' => $request->category_id, // Mengupdate kategori
        ]);

        return redirect()->route('screening-depretion.index')->with('success', 'Soal skrining berhasil diperbarui.');
    }


    // Hapus soal skrining
    public function destroy($id)
    {
        // Menemukan soal berdasarkan ID dan menghapusnya
        $question = ScreeningQuestion::findOrFail($id);
        $question->delete();

        return redirect()->route('screening-depretion.index')->with('success', 'Soal skrining berhasil dihapus.');
    }
}
