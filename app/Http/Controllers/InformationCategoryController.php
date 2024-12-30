<?php

namespace App\Http\Controllers;

use App\Models\InformationCategory;
use Illuminate\Http\Request;

class InformationCategoryController extends Controller
{
    // Menampilkan daftar kategori informasi
    public function index()
    {
        $categories = InformationCategory::all(); // Mengambil semua kategori dari database
        return view('management-data.information.category.index', compact('categories'));
    }

    // Menampilkan form tambah kategori informasi
    public function create()
    {
        return view('management-data.information.category.create');
    }

    // Menyimpan kategori informasi baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        InformationCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('information-categories.index')->with('success', 'Kategori informasi berhasil ditambahkan');
    }

    public function edit(InformationCategory $informationCategory)
    {
        if ($informationCategory->information()->exists()) {
            return redirect()->route('information-categories.index')
            ->with('error', 'Kategori ini tidak dapat diedit karena sudah terkait dengan informasi.');
        }

        return view('management-data.information.category.edit', compact('informationCategory'));
    }


    // Memperbarui data kategori informasi
    public function update(Request $request, InformationCategory $informationCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $informationCategory->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('information-categories.index')->with('success', 'Kategori informasi berhasil diperbarui');
    }

    // Menghapus kategori informasi
    public function destroy(InformationCategory $informationCategory)
    {
        if ($informationCategory->information()->exists()) {
            return redirect()->route('information-categories.index')
            ->with('error', 'Kategori ini tidak dapat dihapus karena sudah terkait dengan informasi.');
        }

        $informationCategory->delete();
        return redirect()->route('information-categories.index')
        ->with('success', 'Kategori informasi berhasil dihapus');
    }
}

