<?php

namespace App\Http\Controllers;

use App\Models\McuAccessControl;
use App\Models\McuCompany;
use App\Models\McuFile;
use App\Models\McuFileAccessLogActivity;
use App\Models\McuFolder;
use App\Models\McuParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MCUFileSharingController extends Controller
{
    //ini adalah controller untuk file sharing khusus data hasil mcu pasien perusahaan

    public function index()
    {
        return view('mcu.index');
    }

    public function showCsvUploadForm()
    {
        return view('mcu.upload_csv');
    }

    public function processCsvUpload(Request $request)
    {
        $request->validate([
            'csv_file'           => 'required|file|mimes:csv,txt',
            'company_name'       => 'required|string',
            'package_name'       => 'required|string',
            'responsible_person' => 'required|string',
            'mcu_date'           => 'required|date',
        ]);

        // Buat atau perbarui data perusahaan.
        $company = McuCompany::updateOrCreate(
            ['name' => $request->company_name],
            [
                'package_name'       => $request->package_name,
                'responsible_person' => $request->responsible_person,
            ]
        );

        // Buat folder batch MCU berdasarkan tanggal (misalnya, MCU_2025-03-03).
        $mcuFolderName = 'MCU_' . Carbon::parse($request->mcu_date)->format('Y-m-d');
        $mcuFolder = McuFolder::create([
            'company_id'  => $company->id,
            'name'        => $mcuFolderName,
            'folder_type' => 'MCU',
        ]);

        // Baca file CSV dan proses tiap baris data peserta.
        $path = $request->file('csv_file')->getRealPath();
        if (($handle = fopen($path, 'r')) !== false) {
            // Anggap baris pertama sebagai header.
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                // Misalnya: $row[0] = Nama Peserta, $row[1] = Tanggal Lahir (YYYY-MM-DD)
                $participantName = $row[0];
                $birthDate       = $row[1];

                // Generate username dan password secara otomatis.
                $username = Str::slug($company->name . '-' . $participantName . '-' . $birthDate . '-' . Str::random(4));
                $password = bcrypt(Str::random(8));

                // Simpan data peserta.
                $participant = McuParticipant::create([
                    'company_id' => $company->id,
                    'name'       => $participantName,
                    'birth_date' => $birthDate,
                    'username'   => $username,
                    'password'   => $password,
                    'email'      => null,
                ]);

                // Buat folder untuk peserta (nama folder: slug dari "NamaPeserta_TanggalLahir").
                $patientFolderName = Str::slug($participantName . '_' . $birthDate);
                $patientFolder = McuFolder::create([
                    'company_id'  => $company->id,
                    'name'        => $patientFolderName,
                    'folder_type' => 'Patient',
                ]);

                // Buat pengaturan akses dengan masa aktif 3 bulan.
                McuAccessControl::create([
                    'participant_id' => $participant->id,
                    'folder_id'      => $patientFolder->id,
                    'is_active'      => true,
                    'expired_at'     => Carbon::now()->addMonths(3),
                ]);
            }
            fclose($handle);
        }

        return redirect()->back()->with('success', 'CSV berhasil diproses.');
    }

    public function showZipUploadForm()
    {
        return view('mcu.upload_zip');
    }

    public function processZipUpload(Request $request)
    {
        $request->validate([
            'zip_file'           => 'required|file|mimes:zip',
            'company_name'       => 'required|string',
            'responsible_person' => 'required|string',
        ]);

        // Cari data perusahaan berdasarkan nama dan penanggung jawab.
        $company = McuCompany::where('name', $request->company_name)
            ->where('responsible_person', $request->responsible_person)
            ->first();

        if (!$company) {
            return redirect()->back()->with('error', 'Perusahaan atau penanggung jawab tidak ditemukan.');
        }

        // Simpan file ZIP secara sementara.
        $zipPath = $request->file('zip_file')->store('temp');
        $zipFullPath = storage_path('app/' . $zipPath);

        $zip = new ZipArchive;
        if ($zip->open($zipFullPath) === true) {
            // Buat folder temporary untuk ekstraksi.
            $extractPath = storage_path('app/temp/' . uniqid('mcu_', true));
            mkdir($extractPath, 0755, true);
            $zip->extractTo($extractPath);
            $zip->close();

            // Iterasi tiap file yang diekstrak.
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($extractPath));
            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $fileName = $file->getFilename();
                    // Asumsikan nama file (tanpa ekstensi) sesuai dengan nama folder peserta (format slug).
                    $folderName = pathinfo($fileName, PATHINFO_FILENAME);

                    // Cari folder peserta pada perusahaan tersebut.
                    $patientFolder = McuFolder::where('company_id', $company->id)
                        ->where('folder_type', 'Patient')
                        ->where('name', $folderName)
                        ->first();

                    if ($patientFolder) {
                        // Tentukan path penyimpanan file terenkripsi.
                        $storagePath = 'mcu_secure/' . Str::slug($company->name) . '/' . $patientFolder->name;
                        $newFilePath = $storagePath . '/' . $fileName;

                        // Baca konten file asli.
                        $fileContent = file_get_contents($file->getRealPath());
                        // Enkripsi konten file menggunakan AES-256-CBC (default Laravel Crypt).
                        $encryptedContent = Crypt::encrypt($fileContent);

                        // Simpan file terenkripsi pada disk "private" (pastikan disk 'private' sudah dikonfigurasi di config/filesystems.php).
                        Storage::disk('private')->put($newFilePath, $encryptedContent);

                        // Simpan data file ke tabel mcu_files.
                        McuFile::create([
                            'folder_id'   => $patientFolder->id,
                            'file_name'   => $fileName,
                            'file_path'   => $newFilePath,
                            'uploaded_by' => auth()->user()->id,
                        ]);
                    }
                }
            }

            // Hapus file ZIP dan folder temporary.
            File::deleteDirectory($extractPath);
            Storage::delete($zipPath);

            return redirect()->back()->with('success', 'ZIP file berhasil diproses dan file terenkripsi diupload.');
        } else {
            return redirect()->back()->with('error', 'Gagal membuka file ZIP.');
        }
    }

    public function downloadEncryptedFile($fileId)
    {
        $file = McuFile::findOrFail($fileId);

        // Asumsikan user yang login adalah peserta MCU.
        $participant = auth()->user()->mcuParticipant ?? null;
        $participantId = $participant ? $participant->id : null;
        $folderId = $file->folder_id;

        // Catat aktivitas download.
        $this->logAccess('download', $participantId, $folderId, $file->id);

        // Ambil file terenkripsi dari disk 'private'.
        $encryptedContent = Storage::disk('private')->get($file->file_path);
        // Dekripsi konten file.
        $decryptedContent = Crypt::decrypt($encryptedContent);

        return new StreamedResponse(function () use ($decryptedContent) {
            echo $decryptedContent;
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $file->file_name . '"',
        ]);
    }

    public function viewFolder($folderId)
    {
        $folder = McuFolder::findOrFail($folderId);
        $files = $folder->files;

        // Asumsikan user yang login adalah peserta MCU.
        $participant = auth()->user()->mcuParticipant ?? null;
        $participantId = $participant ? $participant->id : null;

        // Catat aktivitas view folder.
        $this->logAccess('view_folder', $participantId, $folder->id);

        return view('mcu.view_folder', compact('folder', 'files'));
    }

    protected function logAccess($action, $participantId, $folderId, $fileId = null)
    {
        McuFileAccessLogActivity::create([
            'participant_id' => $participantId,
            'folder_id'      => $folderId,
            'file_id'        => $fileId,
            'action'         => $action,
            'user_agent'     => request()->header('User-Agent'),
            'ip_address'     => request()->ip(),
            'created_at'     => now(),
        ]);
    }

    public function accessLogs()
    {
        $logs = McuFileAccessLogActivity::orderBy('created_at', 'desc')->get();
        return view('mcu.access_logs', compact('logs'));
    }
}
