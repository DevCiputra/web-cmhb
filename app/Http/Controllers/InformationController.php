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
    public function indexArticle(Request $request)
    {
        $query = Information::where('information_category_id', 1)
            ->with('media'); // Menambahkan relasi media

        // Filter berdasarkan flag jika ada
        if ($request->has('flag') && $request->flag != '') {
            $query->where('flag', $request->flag);
        }

        if ($request->filled('order_by')) {
            $order = $request->order_by === 'newest' ? 'desc' : 'asc';
            $query->orderBy('created_at', $order);
        }

        $articles = $query->paginate(10);

        return view('management-data.information.article.index', compact('articles'));
    }


    public function createArticle()
    {
        // Daftar kategori artikel (dapat disesuaikan)
        // $categories = ['Artikel Kesehatan', 'Tips Kesehatan', 'Event'];

        return view('management-data.information.article.create');
    }



    public function storeArticle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'flag' => 'required|string',
            'description' => 'required',
            'special_information' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $article = new Information();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->special_information = $request->special_information; // Input tambahan
        $article->flag = $request->flag;
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
            'flag' => 'required|string',
            'description' => 'required',
            'special_information' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cari artikel berdasarkan ID
        $article = Information::where('information_category_id', 1)->findOrFail($id);
        $oldValues = $article->getOriginal();

        // Update artikel dengan data baru
        $article->title = $request->title;
        $article->description = $request->description;
        $article->special_information = $request->special_information; // Update informasi khusus
        $article->flag = $request->flag;
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
        try {
            // Pastikan hanya artikel dengan category_id = 1 yang dapat dihapus
            $article = Information::where('information_category_id', 1)
                ->with('media') // Memuat relasi media
                ->findOrFail($id);

            // Lakukan soft delete pada artikel
            $article->delete();

            // Catat aksi penghapusan ke dalam log
            InformationLog::create([
                'information_id' => $article->id,
                'user_id' => Auth::id(),
                'action' => 'DELETE',
                'changes' => 'Artikel "' . $article->title . '" dihapus (soft delete) oleh ' . Auth::user()->username,
            ]);

            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('information.article.index')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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

    public function searchArticle(Request $request)
    {
        $query = $request->query('query');
        $articles = Information::when($query, function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%");
        })->paginate(12);
    
        return response()->json([
            'articles' => $articles->items(),
            'pagination' => $articles->links()->render(),
        ]);
    }
    
    
    public function indexPromote(Request $request)
    {
        $query = Information::where('information_category_id', 2);

        // Filter berdasarkan flag jika ada
        if ($request->has('flag') && $request->flag != '') {
            $query->where('flag', $request->flag);
        }

        
        if ($request->filled('order_by')) {
            $order = $request->order_by === 'newest' ? 'desc' : 'asc';
            $query->orderBy('created_at', $order);
        }


        $promotions = $query->paginate(10);

        return view('management-data.information.promote.index', compact('promotions'));
    }


    public function createPromote()
    {

        return view('management-data.information.promote.create');
    }

    // Menyimpan data promosi baru
    public function storePromote(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'media' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'flag' => 'required|string',
        ]);

        try {
            // Simpan data promosi
            $promotion = Information::create([
                'title' => $validatedData['title'],
                'information_category_id' => 2, // ID kategori promosi
                'flag' => $request->flag,
                'is_published' => false,
                'created_by' => Auth::id(),
            ]);

            // Simpan media jika ada
            if ($request->hasFile('media')) {
                $file = $request->file('media');

                // Generate nama file terenkripsi (gunakan Str::random)
                $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();

                // Simpan file ke dalam storage/app/public/information_media/promotions
                $filePath = $file->storeAs('promotions', $fileName, 'public');

                // Simpan informasi media ke tabel information_media
                InformationMedia::create([
                    'information_id' => $promotion->id,
                    'file_name' => $fileName, // Nama file terenkripsi
                    'mime_type' => $file->getMimeType(), // Tipe file
                    'file_url' => Storage::url($filePath), // URL file
                ]);
            }

            // Catat log
            InformationLog::create([
                'information_id' => $promotion->id,
                'user_id' => Auth::id(),
                'action' => 'CREATE',
                'changes' => 'Promosi dibuat oleh ' . Auth::user()->username,
            ]);

            return redirect()->route('information.promote.index')->with('success', 'Promosi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function editPromote($id)
    {
        $promotion = Information::where('information_category_id', 2)->findOrFail($id);
        return view('management-data.information.promote.edit', compact('promotion'));
    }

    // Memperbarui data promosi
    public function updatePromote(Request $request, $id)
    {
        // dd($request);
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'media' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'flag' => 'string',
        ]);

        try {
            // Ambil data promosi berdasarkan ID
            $promotion = Information::where('information_category_id', 2)->findOrFail($id);


            // Simpan data yang diperbarui
            $oldValues = $promotion->getOriginal();
            $promotion->update([
                'title' => $validatedData['title'],
                'flag' => $validatedData['flag'], // Pastikan flag diperbarui
                'updated_by' => Auth::id(),
            ]);
            // dd($promotion);

            // Perbarui file media jika ada
            if ($request->hasFile('media')) {
                $file = $request->file('media');

                // Generate nama file terenkripsi
                $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();

                // Simpan file ke dalam storage/app/public/information_media/promotions
                $filePath = $file->storeAs('promotions', $fileName, 'public');

                // Hapus file media lama jika ada
                $oldMedia = $promotion->media->first();
                if ($oldMedia) {
                    Storage::delete(str_replace('/storage/', 'public/', $oldMedia->file_url));
                    $oldMedia->delete();
                }

                // Simpan informasi media baru ke tabel information_media
                InformationMedia::create([
                    'information_id' => $promotion->id,
                    'file_name' => $fileName,
                    'mime_type' => $file->getMimeType(),
                    'file_url' => Storage::url($filePath),
                ]);
            }

            // Catat log perubahan
            InformationLog::create([
                'information_id' => $promotion->id,
                'user_id' => Auth::id(),
                'action' => 'UPDATE',
                'changes' => json_encode([
                    'before' => $oldValues,
                    'after' => $promotion->getChanges(),
                ]),
            ]);

            return redirect()->route('information.promote.index')->with('success', 'Promosi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // Menghapus data promosi
    public function deletePromote($id)
    {
        try {
            // Pastikan hanya promosi dengan category_id = 2 yang dapat dihapus
            $promotion = Information::where('information_category_id', 2)
                ->with('media') // Memuat relasi media
                ->findOrFail($id);

            $title = $promotion->title;

            // Lakukan soft delete pada promosi
            $promotion->delete();

            // Catat aksi penghapusan ke dalam log
            InformationLog::create([
                'information_id' => $promotion->id,
                'user_id' => Auth::id(),
                'action' => 'DELETE',
                'changes' => "Promosi '$title' dihapus (soft delete) oleh " . Auth::user()->username,
            ]);

            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('information.promote.index')->with('success', 'Promosi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // Publish promosi
    public function publishPromote($id)
    {
        $promotion = Information::where('information_category_id', 2)->findOrFail($id);

        try {
            $promotion->update([
                'is_published' => true,
                'published_at' => now(),
            ]);

            // Catat log
            InformationLog::create([
                'information_id' => $promotion->id,
                'user_id' => Auth::id(),
                'action' => 'PUBLISH',
                'changes' => 'Promosi dipublikasikan oleh ' . Auth::user()->username,
            ]);

            return redirect()->route('information.promote.index')->with('success', 'Promosi berhasil dipublikasikan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Draft promosi
    public function draftPromote($id)
    {
        $promotion = Information::where('information_category_id', 2)->findOrFail($id);

        try {
            $promotion->update(['is_published' => false]);

            // Catat log
            InformationLog::create([
                'information_id' => $promotion->id,
                'user_id' => Auth::id(),
                'action' => 'DRAFT',
                'changes' => 'Promosi diubah menjadi draft oleh ' . Auth::user()->username,
            ]);

            return redirect()->route('information.promote.index')->with('success', 'Promosi berhasil diubah menjadi draft.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
