<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\InformationCategory;
use App\Models\InformationLog;
use App\Models\InformationMedia;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InformationController extends Controller
{
    public function indexArticle()
    {
        $articles = Information::where('information_category_id', 1)
        ->with('media') // Menambahkan relasi media
        ->paginate(10);
        return view('management-data.information.article.index', compact('articles'));
    }

    public function createArticle()
    {
        return view('management-data.information.article.create');
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'special_information' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $article = new Information();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->special_information = $request->special_information; // Input tambahan
        $article->information_category_id = 1; // ID kategori default
        $article->created_by = Auth::user()->id; // Ambil username pengguna
        $article->is_published = $request->is_published ?? '0';
        $article->published_at = $request->is_published ? now() : null; // Waktu publikasi jika dipublikasikan
        $article->save();

        // Simpan media jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Generate nama file terenkripsi (gunakan md5 atau metode lainnya)
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension(); // Nama terenkripsi

            // Simpan file ke dalam storage/app/public/articles dengan nama terenkripsi
            $filePath = $file->storeAs('articles', $fileName, 'public');

            // Simpan informasi media ke tabel information_media
            InformationMedia::create([
                'information_id' => $article->id,
                'file_name' => $fileName, // Nama file terenkripsi
                'mime_type' => $file->getMimeType(), // Tipe file
                'file_url' => Storage::url($filePath), // URL file yang dapat diakses
            ]);
        }

        // Catat log pembuatan artikel
        InformationLog::create([
            'information_id' => $article->id,
            'user_id' => Auth::id(),
            'action' => 'CREATE',
            'changes' => 'Dilakukan penambahan data baru oleh ' . Auth::user()->username,
        ]);

        return redirect()->route('information.article.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function editArticle($id)
    {
        $article = Information::where('information_category_id', 1)
        ->with('media') // Memuat relasi media
        ->findOrFail($id);
        return view('management-data.information.article.edit', compact('article'));
    }

    public function updateArticle(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'special_information' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cari artikel berdasarkan ID
        $article = Information::where('information_category_id', 1)::findOrFail($id);
        $oldValues = $article->getOriginal();

        // Update artikel dengan data baru
        $article->title = $request->title;
        $article->description = $request->description;
        $article->special_information = $request->special_information; // Update informasi khusus
        $article->is_published = $request->is_published ?? '0';
        $article->published_at = $request->is_published ? now() : null; // Waktu publikasi jika dipublikasikan
        $article->save();

        // Cek apakah ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus media lama jika ada
            $media = $article->media()->first();
            if ($media) {
                // Hapus file lama dari storage
                Storage::delete($media->file_url);
                // Hapus record media
                $media->delete();
            }

            // Simpan file gambar baru
            $file = $request->file('image');

            // Generate nama file terenkripsi
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension(); // Nama terenkripsi

            // Simpan file ke dalam storage/app/public/articles dengan nama terenkripsi
            $filePath = $file->storeAs('articles', $fileName, 'public');

            // Simpan informasi media baru ke tabel information_media
            InformationMedia::create([
                'information_id' => $article->id,
                'file_name' => $fileName, // Nama file terenkripsi
                'mime_type' => $file->getMimeType(), // Tipe file
                'file_url' => Storage::url($filePath), // URL file yang dapat diakses
            ]);
        }

        // Catat perubahan artikel dalam log
        InformationLog::create([
            'information_id' => $article->id,
            'user_id' => Auth::id(),
            'action' => 'UPDATE',
            'changes' => 'Dilakukan perubahan data oleh ' . Auth::user()->username,
        ]);

        // Redirect ke halaman artikel dengan pesan sukses
        return redirect()->route('information.article.index')->with('success', 'Artikel berhasil diperbarui.');
    }
    public function detailArticle($id)
    {
        // Ambil artikel berdasarkan ID dan kategori 1 (Artikel) beserta relasi media
        $article = Information::where('information_category_id', 1)
        ->with('media') // Memuat relasi media
        ->findOrFail($id);

        // Kirim data artikel ke view
        return view('management-data.information.article.detail', compact('article'));
    }

    public function deleteArticle($id)
    {
        // Pastikan hanya artikel dengan category_id = 1 yang dapat dihapus
        $article = Information::where('information_category_id', 1)
        ->with('media') // Memuat relasi media
        ->findOrFail($id);

        // Hapus artikel
        $article->delete();

        // Catat aksi penghapusan ke dalam log
        InformationLog::create([
            'information_id' => $article->id,
            'user_id' => Auth::id(),
            'action' => 'DELETE',
            'changes' => 'Dilakukan penghapusan data oleh ' . Auth::user()->username,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('information.article.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function draftArticle($id)
    {
        // Pastikan hanya artikel dengan category_id = 1 yang dapat didraft
        $article = Information::where('information_category_id', 1)
        ->findOrFail($id);

        // Set status menjadi draft
        $article->is_published = '0';
        $article->save();

        // Catat aksi ke dalam log
        InformationLog::create([
            'information_id' => $article->id,
            'user_id' => Auth::id(),
            'action' => 'DRAFT',
            'changes' => 'Dilakukan simpan oleh ' . Auth::user()->username,
        ]);

        return redirect()->route('information.article.index')->with('success', 'Artikel berhasil didraft.');
    }

    public function publishArticle($id)
    {
        // Pastikan hanya artikel dengan category_id = 1 yang dapat dipublish
        $article = Information::where('information_category_id', 1)
        ->findOrFail($id);

        // Set status menjadi publish
        $article->is_published = '1';
        $article->published_at = now(); // Set tanggal publish ke saat ini
        $article->save();

        // Catat aksi ke dalam log
        InformationLog::create([
            'information_id' => $article->id,
            'user_id' => Auth::id(),
            'action' => 'PUBLISH',
            'changes' => 'Dilakukan publikasi oleh ' . Auth::user()->username,
        ]);

        return redirect()->route('information.article.index')->with('success', 'Artikel berhasil dipublish.');
    }


    // PROMOSI
    public function indexPromote(Request $request)
    {
        // Ambil ID kategori "Promosi"
        $category = InformationCategory::where('name', 'Promosi')->first();

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

        return view('management-data.information.promote.create');
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
