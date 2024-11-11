<?php

namespace App\Http\Controllers;

use App\Models\ScreeningOption;
use App\Models\ScreeningQuestion;
use Illuminate\Http\Request;

class ScreeningOptionController extends Controller
{
    // Menampilkan daftar opsi skrining untuk soal tertentu
    public function index(ScreeningQuestion $question)
    {
        // Mendapatkan opsi yang terkait dengan soal tertentu
        $options = ScreeningOption::where('question_id', $question->id)->get();

        // Mengirimkan data soal dan opsi ke view
        return view('management-data.screening.question-option.index', compact('options', 'question'));
    }


    // Menampilkan form untuk membuat opsi baru
    public function create(ScreeningQuestion $question)
    {
        return view('management-data.screening.question-option.create', compact('question'));
    }

    // Menyimpan opsi baru ke database
    // Menyimpan opsi baru untuk soal tertentu
    public function store(Request $request, ScreeningQuestion $question)
    {
        // Validasi input
        $validated = $request->validate([
            'option_text' => 'required|string|max:255',
            'weight' => 'required|numeric',
        ]);

        // Simpan opsi baru
        $question->options()->create([
            'option_text' => $validated['option_text'],
            'weight' => $validated['weight'],
        ]);

        return redirect()->route('screening-depretion.screening-options.index', $question)
            ->with('success', 'Opsi berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit opsi
    public function edit(ScreeningQuestion $question, ScreeningOption $option)
    {
        return view('management-data.screening.question-option.edit', compact('question', 'option'));
    }

    // Memperbarui opsi
    public function update(Request $request, ScreeningQuestion $question, ScreeningOption $option)
    {
        // Validasi input
        $validated = $request->validate([
            'option_text' => 'required|string|max:255',
            'weight' => 'required|numeric',
        ]);

        // Update opsi
        $option->update($validated);

        return redirect()->route('screening-depretion.screening-options.index', $question)
            ->with('success', 'Opsi berhasil diperbarui');
    }

    // Menghapus opsi
    public function destroy(ScreeningQuestion $question, ScreeningOption $option)
    {
        // Hapus opsi
        $option->delete();

        return redirect()->route('screening-depretion.screening-options.index', $question)
            ->with('success', 'Opsi berhasil dihapus');
    }
}
