<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\FileSharingRootFolder;
use App\Models\FileSharingFolder;
use App\Models\FileSharingFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileSharingController extends Controller
{
    /**
     * Menampilkan halaman utama file sharing.
     * Hanya menampilkan root folder yang sesuai dengan role user.
     */
    public function index()
    {
        $rootFolders = FileSharingRootFolder::where('role', Auth::user()->role)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('management-data.file-sharing.index-master', compact('rootFolders'));
    }

    /**
     * Show a root folder and its sub‑folders, looked up by name.
     */
    public function showFolder($folderName)
    {
        // cari root folder berdasarkan kolom 'name'
        $folder = FileSharingRootFolder::where('name', $folderName)->firstOrFail();

        // ambil sub‑folder di FileSharingFolder yang punya root_folder_id ini
        $subFolders = FileSharingFolder::where('root_folder_id', $folder->id)
            ->orderBy('name')
            ->get();

        return view('management-data.file-sharing.show-folder', compact('folder', 'subFolders'));
    }

    /**
     * Menyimpan folder baru.
     * Form pada modal "Tambah Folder" mengirimkan root_folder_id dan nama folder.
     */
    public function storeFolder(Request $request)
    {
        $request->validate([
            'root_folder_id' => 'required|exists:file_sharing_root_folders,id',
            'name'           => 'required|string|max:255',
            // 'parent_id' opsional jika folder dibuat sebagai sub-folder
        ]);

        FileSharingFolder::create([
            'root_folder_id' => $request->root_folder_id,
            'parent_id'      => $request->parent_id, // boleh null, artinya folder langsung di dalam root
            'name'           => $request->name,
        ]);

        return redirect()->back()->with('success', 'Folder berhasil dibuat.');
    }

    /**
     * Memperbarui folder.
     * Form modal edit folder mengirimkan data nama folder.
     */
    public function updateFolder(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $folder = FileSharingFolder::findOrFail($id);
        $folder->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Folder berhasil diperbarui.');
    }

    /**
     * Menghapus folder.
     */
    public function destroyFolder($id)
    {
        $folder = FileSharingFolder::findOrFail($id);
        $folder->delete();

        return redirect()->back()->with('success', 'Folder berhasil dihapus.');
    }

    /**
     * Upload file ke dalam folder.
     */
    public function storeFile(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|exists:file_sharing_folders,id',
            'file'      => 'required|file',
        ]);

        $folder = FileSharingFolder::findOrFail($request->folder_id);
        $uploadedFile = $request->file('file');
        $originalName = $uploadedFile->getClientOriginalName();
        $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $uploadedFile->getClientOriginalExtension();
        $storagePath = 'file_sharing/' . $folder->id;
        $path = Storage::disk('private')->putFileAs($storagePath, $uploadedFile, $fileName);

        FileSharingFile::create([
            'folder_id'   => $folder->id,
            'file_name'   => $originalName,
            'file_path'   => $path,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'File berhasil diupload.');
    }

    /**
     * Download file dari folder file sharing.
     */
    public function downloadFile($id)
    {
        $file = FileSharingFile::findOrFail($id);
        $fileContent = Storage::disk('private')->get($file->file_path);

        return new StreamedResponse(function () use ($fileContent) {
            echo $fileContent;
        }, 200, [
            'Content-Type'        => Storage::disk('private')->mimeType($file->file_path),
            'Content-Disposition' => 'attachment; filename="' . $file->file_name . '"',
        ]);
    }
}
