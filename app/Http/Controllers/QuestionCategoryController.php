<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use Illuminate\Http\Request;

class QuestionCategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = QuestionCategory::all();
        return view('management-data.screening.category.index', compact('categories'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('management-data.screening.category.create');
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        QuestionCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('question-categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // Menampilkan form edit kategori
    public function edit(QuestionCategory $questionCategory)
    {
        return view('management-data.screening.category.edit', compact('questionCategory'));
    }

    // Memperbarui data kategori
    public function update(Request $request, QuestionCategory $questionCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $questionCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('question-categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    // Menghapus kategori
    public function destroy(QuestionCategory $questionCategory)
    {
        $questionCategory->delete();
        return redirect()->route('question-categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
