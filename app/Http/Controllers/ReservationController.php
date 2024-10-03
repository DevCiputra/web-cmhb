<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorPolyclinic;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    public function indexMcu(Request $request)
    {
        // Ambil ID kategori "MCU"
        $mcuCategoryId = ServiceCategory::where('name', 'MCU')->first()->id;

        // Ambil kata kunci pencarian dari input request
        $keyword = $request->input('keyword');

        // Jika ada keyword, lakukan pencarian, jika tidak, tampilkan semua data dengan pagination
        $services = Service::with('medias')
            ->where('service_category_id', $mcuCategoryId)
            ->withTrashed() // Menyertakan data yang dihapus secara soft delete
            ->when($keyword, function ($query, $keyword) {
                return $query->search($keyword); // Menggunakan scope search jika ada keyword
            })
            ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan tanggal dibuat terbaru
            ->paginate(8); // Membatasi tampilan maksimal 4 data per halaman

        // Menampilkan data ke view
        return view('management-data.reservation.medical-check-up.index', compact('services'));
    }

    public function detailMcu($id)
    {
        // Mengambil service dengan medias yang sudah soft deleted
        $service = Service::with('medias')->withTrashed()->findOrFail($id);

        return view('management-data.reservation.medical-check-up.detail', compact('service'));
    }

    // Tampilkan form untuk tambah layanan
    public function createMcu()
    {
        $categories = ServiceCategory::all();
        return view('management-data.reservation.medical-check-up.create', compact('categories'));
    }

    public function storeMcu(Request $request)
    {
        // Ambil ID kategori "MCU"
        $categoryId = ServiceCategory::where('name', 'MCU')->first()->id;

        // Validasi data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'special_information' => 'required|string',
            'address' => 'required|string',
            'price' => 'required|numeric',
            'media' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi foto
        ]);

        // Tambahkan ID kategori MCU dan set is_published ke false
        $validatedData['service_category_id'] = $categoryId;
        $validatedData['is_published'] = false; // Set is_published ke false

        // Simpan data layanan baru
        $service = Service::create($validatedData);

        // Handle photo upload
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Sesuaikan path untuk direktori yang lebih rinci (misalnya berdasarkan kategori)
            $filePath = $file->storeAs('public/service_photos/mcu', $fileName);

            // Simpan informasi foto ke tabel service_media
            ServiceMedia::create([
                'service_id' => $service->id,
                'name' => $fileName,
                'mime_type' => $file->getClientMimeType(),
            ]);
        }
        return redirect()->route('reservation.mcu.index')->with('success', 'Service created successfully.');
    }

    // Tampilkan form edit layanan
    public function editMcu(Service $service, Request $request)
    {
        $categories = ServiceCategory::all();

        // Ambil parameter 'page' dari request
        $page = $request->input('page'); // Default ke halaman 1 jika page tidak ada

        // Kirimkan parameter 'page' ke view
        return view('management-data.reservation.medical-check-up.edit', compact('service', 'categories', 'page'));
    }


    // Update layanan yang sudah ada
    public function updateMcu(Request $request, Service $service)
    {
        // Ambil ID kategori "MCU"
        $categoryId = ServiceCategory::where('name', 'MCU')->first()->id;

        // Validasi data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'special_information' => 'required|string',
            'address' => 'required|string',
            'price' => 'required|numeric',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Foto opsional
        ]);

        // Tambahkan ID kategori MCU ke data yang akan diperbarui
        $validatedData['service_category_id'] = $categoryId;

        // Update data layanan yang sudah ada
        $service->update($validatedData);

        // Handle photo update
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Sesuaikan path untuk direktori yang lebih rinci (misalnya berdasarkan kategori)
            $filePath = $file->storeAs('public/service_photos/mcu', $fileName);

            // Hapus file lama dan perbarui media jika ada
            if ($service->medias && $service->medias->isNotEmpty()) {
                $oldMedia = $service->medias->first();

                // Hapus file lama
                if (Storage::exists('public/service_photos/mcu/' . $oldMedia->name)) {
                    Storage::delete('public/service_photos/mcu/' . $oldMedia->name);
                }

                // Update media dengan file baru
                $oldMedia->update([
                    'name' => $fileName,
                    'mime_type' => $file->getClientMimeType(),
                ]);
            } else {
                // Jika tidak ada media sebelumnya, buat entri baru
                ServiceMedia::create([
                    'service_id' => $service->id,
                    'name' => $fileName,
                    'mime_type' => $file->getClientMimeType(),
                ]);
            }
        }
        $page = $request->input('page'); // Ambil parameter page
        return redirect()->route('reservation.mcu.index', ['page' => $page])->with('success', 'Service updated successfully.');
    }


    // Function untuk meng-update is_published menjadi true (1)
    public function publishMcu(Service $service, Request $request)
    {
        // Update nilai is_published menjadi true
        $service->update(['is_published' => true]);

        $page = $request->input('page'); // Ambil parameter page
        return redirect()->route('reservation.mcu.index', ['page' => $page])->with('success', 'Service published successfully.');
    }

    // Controller: ReservationController.php

    public function unpublishMcu(Service $service, Request $request)
    {
        // Update nilai is_published menjadi false
        $service->update(['is_published' => false]);

        $page = $request->input('page'); // Ambil parameter page
        return redirect()->route('reservation.mcu.index', ['page' => $page])->with('success', 'Service unpublished successfully.');
    }


    // Function untuk menghapus layanan
    public function destroyMcu(Service $service, Request $request)
    {
        // Update is_published menjadi 0
        $service->is_published = 0;
        $service->save();

        // Soft delete media terkait tanpa menghapus file fisik
        if ($service->medias && $service->medias->isNotEmpty()) {
            foreach ($service->medias as $media) {
                // Hanya soft delete media
                $media->delete();
            }
        }

        // Soft delete layanan
        $service->delete();

        $page = $request->input('page'); // Ambil parameter page
        return redirect()->route('reservation.mcu.index', ['page' => $page])->with('success', 'Service deleted successfully.');
    }


    public function restoreMcu($id, Request $request)
    {
        // Mengembalikan layanan yang telah di-soft delete
        $service = Service::withTrashed()->findOrFail($id);
        $service->restore();

        // Mengembalikan media terkait yang telah di-soft delete
        foreach ($service->medias()->withTrashed()->get() as $media) {
            $media->restore();
        }
        $page = $request->input('page'); // Ambil parameter page
        return redirect()->route('reservation.mcu.index', ['page' => $page])->with('success', 'Service restored successfully.');
    }

    public function indexLandingMcu()
    {
        // Mengambil ID kategori "MCU"
        $mcuCategoryId = ServiceCategory::where('name', 'MCU')->first()->id;

        // Ambil data service yang sudah dipublish
        $services = Service::with('medias')
            ->where('service_category_id', $mcuCategoryId)
            ->where('is_published', true) // Hanya ambil yang dipublish
            ->orderBy('created_at', 'desc')
            ->get(); // Mengambil semua data yang dipublish tanpa pagination

        // Menampilkan data ke view `landing-page.mcu.index`
        return view('landing-page.mcu.index', compact('services'));
    }

    public function indexPoly()
    {
        return view('management-data.reservation.polyclinic.index');
    }

    public function indexHomeService()
    {
        return view('management-data.reservation.home-service.index');
    }


    // landing page consultation

    // Method untuk menampilkan halaman konsultasi online
    // public function indexLandingConsultation()
    // {
    
    //     $title = 'Konsultasi Online';

    //     $doctors = Doctor::with(['polyclinic', 'photos'])->paginate(8);

    //     $polyclinics = DoctorPolyclinic::all();

    //     $specializations = Doctor::select('specialization_name')->distinct()->pluck('specialization_name');

    //     return view('landing-page.contents.consultation', compact('title', 'doctors'));
    // }

    public function indexConsultation()
    {
        return view('management-data.reservation.online-consultation.index');
    }

    public function detailConsultation()
    {
        return view('management-data.reservation.online-consultation.detail');
    }

    public function invoiceConsultation()
    {
        return view('management-data.reservation.online-consultation.invoice');
    }
}
