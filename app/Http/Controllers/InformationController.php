<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\InformationCategory;
use App\Models\InformationLog;
use App\Models\InformationMedia;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function indexArticle()
    {
        return view('management-data.information.article.index');
    }

    public function createArticle()
    {

        $categories = InformationCategory::all();
        return view('management-data.information.article.create', compact('categories'));
    }

    public function editArticle()
    {
        return view('management-data.information.article.edit');
    }

    public function detailArticle()
    {
        return view('management-data.information.article.detail');
    }


    // PROMOSI
    public function indexPromote(Request $request)
    {
        // Ambil ID kategori "Promosi"
        $category = InformationCategory::where('name', 'Promosi')->first();
    
        if (!$category) {
            return redirect()->back()->with('error', 'Kategori "Promosi" tidak ditemukan.');
        }
    
        $categoryId = $category->id;
    
        // Ambil kata kunci pencarian dari input request
        $keyword = $request->input('keyword');
    
        // Filter berdasarkan kategori dan pencarian
        $promotions = Information::with('medias')
            ->where('information_category_id', $categoryId)
            ->when($keyword, function ($query, $keyword) {
                return $query->where('title', 'like', "%$keyword%")
                             ->orWhere('description', 'like', "%$keyword%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8); // Sesuaikan jumlah item per halaman
    
        // Return ke view dengan data
        return view('management-data.information.promote.index', compact('promotions'));
    }
    
    


    public function createPromote()
    {

        $categories = InformationCategory::all();
        return view('management-data.information.promote.create', compact('categories'));
    }

    public function editPromote()
    {
        return view('management-data.information.promote.edit');
    }

    public function storePromote(Request $request)
    {
        // Ambil ID kategori "Promosi"
        $category = InformationCategory::where('name', 'Promosi')->first();
        if (!$category) {
            return redirect()->back()->with('error', 'Kategori "Promosi" tidak ditemukan.');
        }
        $categoryId = $category->id;
    
        // Validasi data input
        $validatedData = $request->validate([
            'media' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);
    
        // Tambahkan ID kategori dan atur is_published sebagai false
        $validatedData['category_id'] = $categoryId;
        $validatedData['is_published'] = false;
    
        try {
            // Simpan data informasi ke database
            $information = Information::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'special_information' => $validatedData['special_information'],
                'category_id' => $validatedData['category_id'],
                'is_published' => $validatedData['is_published'],
            ]);
    
            // Handle file media jika ada
            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
    
                // Simpan file di direktori storage/public/information_media/promotions
                $filePath = $file->storeAs('public/information_media/promotions', $fileName);
    
                // Simpan informasi media ke tabel information_media
                InformationMedia::create([
                    'information_id' => $information->id,
                    'name' => $fileName,
                    'mime_type' => $file->getClientMimeType(),
                    'file_url' => Storage::url($filePath), // Menyimpan URL file yang benar
                ]);
            }
    
            return redirect()
                ->route('information.promote.index')
                ->with('success', 'Promosi berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Log error jika terjadi
            InformationLog::error('Error saat menyimpan promosi: ' . $e->getMessage());
    
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan promosi. Silakan coba lagi.');
        }
    }
    
    
}
