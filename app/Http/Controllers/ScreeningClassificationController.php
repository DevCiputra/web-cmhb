<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use App\Models\ScreeningClassification;
use Illuminate\Http\Request;

class ScreeningClassificationController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan daftar kategori untuk filter
        $categories = QuestionCategory::pluck('name');

        // Memfilter berdasarkan kategori jika parameter ada
        $classifications = ScreeningClassification::when($request->category_filter, function ($query) use ($request) {
            return $query->where('category_name', $request->category_filter);
        })->get();

        return view('management-data.screening.classification.index', compact('classifications', 'categories'));
    }


    public function create()
    {
        // Mendapatkan daftar nama kategori untuk dropdown
        $categories = QuestionCategory::pluck('name');
        return view('management-data.screening.classification.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input termasuk category_name
        $request->validate([
            'classification_name' => 'required|string|max:255',
            'min_score' => 'required|integer',
            'max_score' => 'required|integer',
            'category_name' => 'required|string|exists:question_categories,name' // Validasi nama kategori harus ada di QuestionCategory
        ]);

        // Menyimpan data klasifikasi dengan category_name
        ScreeningClassification::create($request->only('classification_name', 'min_score', 'max_score', 'category_name'));

        return redirect()->route('screening-classifications.index')->with('success', 'Klasifikasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Mendapatkan klasifikasi yang akan diedit
        $classification = ScreeningClassification::findOrFail($id);

        // Mendapatkan daftar nama kategori untuk dropdown
        $categories = QuestionCategory::pluck('name');

        return view('management-data.screening.classification.edit', compact('classification', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input termasuk category_name
        $request->validate([
            'classification_name' => 'required|string|max:255',
            'min_score' => 'required|integer',
            'max_score' => 'required|integer',
            'category_name' => 'required|string|exists:question_categories,name' // Validasi nama kategori
        ]);

        // Menemukan dan memperbarui data klasifikasi dengan category_name
        $classification = ScreeningClassification::findOrFail($id);
        $classification->update($request->only('classification_name', 'min_score', 'max_score', 'category_name'));

        return redirect()->route('screening-classifications.index')->with('success', 'Klasifikasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $classification = ScreeningClassification::findOrFail($id);
        $classification->delete();

        return redirect()->route('screening-classifications.index')->with('success', 'Klasifikasi berhasil dihapus.');
    }
}
