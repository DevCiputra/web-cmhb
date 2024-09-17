<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceMedia;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function indexMcu()
    {
        // Ambil ID kategori "MCU"
        $mcuCategoryId = ServiceCategory::where('name', 'MCU')->first()->id;

        // Ambil layanan dengan kategori "MCU" dan eager load media terkait
        $services = Service::with('medias')  // Menyertakan relasi media
        ->where('service_category_id', $mcuCategoryId)
            ->get();

        return view('management-data.reservation.medical-check-up.index', compact('services'));
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
            'address' => 'required|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi foto
        ]);

        // Tambahkan ID kategori MCU dan set is_published ke false
        $validatedData['service_category_id'] = $categoryId;
        $validatedData['is_published'] = false; // Set is_published ke false

        // Simpan data layanan baru
        $service = Service::create($validatedData);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/service_photos', $fileName);

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
    public function editMcu(Service $service)
    {
        $categories = ServiceCategory::all();
        return view('management-data.reservation.medical-check-up.edit', compact('service', 'categories'));
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
            'address' => 'required|string',
            'price' => 'required|numeric'
        ]);

        // Tambahkan ID kategori MCU ke data yang akan diperbarui
        $validatedData['service_category_id'] = $categoryId;

        // Update data layanan yang sudah ada
        $service->update($validatedData);

        return redirect()->route('reservation.mcu.index')->with('success', 'Service updated successfully.');
    }


    public function indexPoly()
    {
        return view('management-data.reservation.polyclinic.index');
    }
    public function indexHomeService()
    {
        return view('management-data.reservation.home-service.index');
    }
}
