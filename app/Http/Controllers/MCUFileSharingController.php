<?php

namespace App\Http\Controllers;

use App\Models\FileSharingFolder;
use App\Models\FileSharingRootFolder;
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

        // Ambil semua perusahaan, urut berdasarkan nama
        $companies = McuCompany::orderBy('name')->get();

        // Kirim data ke view
        return view('management-data.file-sharing.mcu-sharing.index', compact('companies'));
    }

    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="mcu_template.csv"',
        ];

        $columns = ['Nama Peserta', 'Tanggal Lahir', 'Jenis Kelamin'];

        $callback = function () use ($columns) {
            $handle = fopen('php://output', 'w');
            // tulis header
            fputcsv($handle, $columns);
            // (opsional) contoh baris
            fputcsv($handle, ['John Doe', '1980-05-15', 'L']);
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'nama_instansi'    => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'package_name'     => 'required|string|max:255',
            'file_instansi'    => 'required|file|mimes:csv,txt,xls,xlsx',
        ]);

        // 1) Simpan data instansi (MCU)
        $company = McuCompany::create([
            'name'               => $request->nama_instansi,
            'responsible_person' => $request->penanggung_jawab,
            'package_name'       => $request->package_name,
        ]);

        // 2) Baca dan parse CSV/XLS
        $path = $request->file('file_instansi')->getRealPath();
        if (($handle = fopen($path, 'r')) !== false) {
            // Lewatkan header
            fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                [$nama, $lahirRaw, $jenis] = $row;

                // a) Parsing tanggal lahir ke Y-m-d (asumsi input m/d/Y)
                try {
                    $birthDate = Carbon::createFromFormat('m/d/Y', trim($lahirRaw))->format('Y-m-d');
                } catch (\Exception $e) {
                    continue; // skip jika gagal parsing
                }

                // b) Prefix gender & slug
                $prefix = in_array(strtoupper($jenis), ['L', 'LAKI', 'LAKI-LAKI']) ? 'TN' : 'NY';
                $slug   = Str::slug("{$prefix}-{$nama}-" . Carbon::parse($birthDate)->format('Ymd'));

                // c) Simpan peserta MCU
                $participant = McuParticipant::create([
                    'company_id'  => $company->id,
                    'name'        => $nama,
                    'birth_date'  => $birthDate,
                    'gender'      => $jenis,
                    'username'    => $slug . '-' . Str::random(4),
                    'password'    => bcrypt(Str::random(8)),
                ]);

                // d) Buat folder pasien di modul MCU
                $patientFolder = McuFolder::create([
                    'company_id'  => $company->id,
                    'name'        => $slug,
                    'folder_type' => 'Patient',
                ]);

                // e) Atur akses 3 bulan
                McuAccessControl::create([
                    'participant_id' => $participant->id,
                    'folder_id'      => $patientFolder->id,
                    'is_active'      => true,
                    'expired_at'     => Carbon::now()->addMonths(3),
                ]);
            }
            fclose($handle);
        }

        return redirect()->route('mcu.index')
            ->with('success', 'Instansi & peserta MCU berhasil dibuat.');
    }

    /**
     * Perbarui data instansi.
     */
    public function updateCompany(Request $request, $id)
    {
        $request->validate([
            'nama_instansi'    => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
        ]);

        $company = McuCompany::findOrFail($id);
        $company->update([
            'name'               => $request->input('nama_instansi'),
            'responsible_person' => $request->input('penanggung_jawab'),
        ]);

        return redirect()->route('mcu.index')
            ->with('success', 'Instansi berhasil diperbarui.');
    }

    /**
     * Hapus instansi.
     */
    public function destroyCompany($id)
    {
        $company = McuCompany::findOrFail($id);
        $company->delete();

        return redirect()->route('mcu.index')
            ->with('success', 'Instansi berhasil dihapus.');
    }

    public function showCompany(McuCompany $company)
    {
        // sudah instance, tinggal eager-load relasi
        $company->load(['folders', 'participants']);

        return view(
            'management-data.file-sharing.mcu-sharing.index-folder',
            compact('company')
        );
    }

    public function viewFolder(McuCompany $company, $patient)
    {
        // Cari folder peserta milik instansi ini
        $folder = McuFolder::where('company_id', $company->id)
            ->where('folder_type', 'Patient')
            ->where('name', $patient)
            ->firstOrFail();

        // Ambil semua file dalam folder itu
        $files = McuFile::where('folder_id', $folder->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'management-data.file-sharing.mcu-sharing.index-folder-mcu',
            compact('company', 'folder', 'files')
        );
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

    public function processZipUpload(Request $request, McuCompany $company)
    {
        $request->validate([
            'zip_file' => 'required|file|mimes:zip',
        ]);

        // Simpan ZIP sementara
        $zipPath     = $request->file('zip_file')->store('temp');
        $zipFullPath = storage_path('app/' . $zipPath);

        $zip = new \ZipArchive;
        if ($zip->open($zipFullPath) !== true) {
            return back()->with('error', 'Gagal membuka file ZIP.');
        }

        // Ekstrak ke temp folder unik
        $extractPath = storage_path('app/temp/' . uniqid('mcu_', true));
        mkdir($extractPath, 0755, true);
        $zip->extractTo($extractPath);
        $zip->close();

        // Iterasi semua file PDF di dalamnya
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($extractPath)
        );
        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }
            $fileName   = $file->getFilename();
            $folderSlug = pathinfo($fileName, PATHINFO_FILENAME);

            // Cari folder patient milik instansi ini
            $patientFolder = McuFolder::where([
                ['company_id',  $company->id],
                ['folder_type', 'Patient'],
                ['name',        $folderSlug],
            ])->first();

            if (! $patientFolder) {
                continue; // skip kalau folder peserta tidak ada
            }

            // Enkripsi dan simpan ke disk mcu_secure
            $raw       = file_get_contents($file->getRealPath());
            $enc       = Crypt::encrypt($raw);
            $securePath = "company_{$company->id}/patient_{$patientFolder->id}/{$fileName}";
            Storage::disk('mcu_secure')->put($securePath, $enc);

            // Simpan record di mcu_files
            McuFile::create([
                'folder_id'   => $patientFolder->id,
                'file_name'   => $fileName,
                'file_path'   => $securePath,
                'uploaded_by' => auth()->id(),
            ]);
        }

        // Cleanup
        Storage::deleteDirectory('temp');
        \File::deleteDirectory($extractPath);

        return back()->with('success', 'File ZIP berhasil diproses dan dienkripsi.');
    }


    public function downloadEncryptedFile($fileId)
    {
        $file = McuFile::findOrFail($fileId);

        // (Opsional) cek izin, misal hanya HBD atau peserta terkait
        abort_unless(auth()->user()->role === 'HBD', 403);

        // Ambil konten terenkripsi
        $encrypted = Storage::disk('mcu_secure')->get($file->file_path);

        // Dekripsi
        $decrypted = Crypt::decrypt($encrypted);

        // Kirim sebagai download
        return response($decrypted, 200, [
            'Content-Type'        => Storage::disk('mcu_secure')->mimeType($file->file_path),
            'Content-Disposition' => 'attachment; filename="' . $file->file_name . '"',
        ]);
    }

    // public function viewFolder($folderId)
    // {
    //     $folder = McuFolder::findOrFail($folderId);
    //     $files = $folder->files;

    //     // Asumsikan user yang login adalah peserta MCU.
    //     $participant = auth()->user()->mcuParticipant ?? null;
    //     $participantId = $participant ? $participant->id : null;

    //     // Catat aktivitas view folder.
    //     $this->logAccess('view_folder', $participantId, $folder->id);

    //     return view('mcu.view_folder', compact('folder', 'files'));
    // }

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
