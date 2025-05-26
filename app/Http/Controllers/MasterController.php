<?php

namespace App\Http\Controllers;

use App\Models\HospitalGallery;
use App\Models\HospitalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class MasterController extends Controller
{

    // information

    public function indexInformation()
    {
        $hospitalInformations = HospitalInformation::all();
        return view('management-data.master.information-cmh.index', compact('hospitalInformations'));
    }

    public function createInformation()
    {
        return view('management-data.master.information-cmh.create');
    }

    public function storeInformation(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vision' => 'required|string|max:255',
            'mission' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:255',
            'customer_service_contact' => 'required|string|max:255',
        ]);

        // Simpan logo jika ada
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            $logoPath = null;
        }

        // Simpan data
        DB::table('hospital_informations')->insert([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'logo' => $logoPath,
            'vision' => $request->input('vision'),
            'mission' => $request->input('mission'),
            'emergency_contact' => $request->input('emergency_contact'),
            'customer_service_contact' => $request->input('customer_service_contact'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('information.data.index')->with('success', 'Information created successfully.');
    }

    // Menampilkan form untuk mengedit data informasi
    public function editInformation($id)
    {
        $information = HospitalInformation::findOrFail($id);
        return view('management-data.master.information-cmh.edit', compact('information'));
    }

    // Menangani pembaruan data informasi
    public function updateInformation(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vision' => 'required|string|max:255',
            'mission' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:255',
            'customer_service_contact' => 'required|string|max:255',
        ]);

        $information = HospitalInformation::findOrFail($id);
        $information->name = $request->input('name');
        $information->address = $request->input('address');
        $information->phone = $request->input('phone');
        $information->email = $request->input('email');
        $information->vision = $request->input('vision');
        $information->mission = $request->input('mission');
        $information->emergency_contact = $request->input('emergency_contact');
        $information->customer_service_contact = $request->input('customer_service_contact');

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($information->logo) {
                Storage::delete('public/' . $information->logo);
            }

            // Simpan logo baru
            $file = $request->file('logo');
            $filename = $file->store('logos', 'public');
            $information->logo = $filename;
        }

        $information->save();

        return redirect()->route('information.data.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroyInformation($id)
    {
        // Temukan informasi berdasarkan ID
        $information = HospitalInformation::findOrFail($id);

        // Hapus logo jika ada
        if ($information->logo) {
            Storage::delete('public/' . $information->logo);
        }

        // Hapus data dari database
        $information->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('information.data.index')->with('success', 'Informasi RS berhasil dihapus.');
    }

    //


    // galleries

    public function indexGallery()
    {
        $galleries = HospitalGallery::all();
        return view('management-data.master.gallery-cmh.index', compact('galleries'));
    }

    public function createGallery()
    {
        return view('management-data.master.gallery-cmh.create');
    }

    public function storeGallery(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        $path = $request->file('photo')->store('hospital_galleries', 'public');

        HospitalGallery::create([
            'photo' => $path,
            'description' => $request->description,
        ]);

        return redirect()->route('gallery.data.index')->with('success', 'Gallery created successfully.');
    }

    public function editGallery($id)
    {
        $gallery = HospitalGallery::findOrFail($id);
        return view('management-data.master.gallery-cmh.edit', compact('gallery'));
    }

    public function updateGallery(Request $request, $id)
    {
        $gallery = HospitalGallery::findOrFail($id);

        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($gallery->photo && Storage::disk('public')->exists($gallery->photo)) {
                Storage::disk('public')->delete($gallery->photo);
            }

            // Store new photo
            $path = $request->file('photo')->store('hospital_galleries', 'public');
            $gallery->photo = $path;
        }

        $gallery->description = $request->description;
        $gallery->save();

        return redirect()->route('gallery.data.index')->with('success', 'Gallery updated successfully.');
    }

    public function destroyGallery($id)
    {
        $gallery = HospitalGallery::findOrFail($id);

        if ($gallery->photo && Storage::disk('public')->exists($gallery->photo)) {
            Storage::disk('public')->delete($gallery->photo);
        }

        $gallery->delete();

        return redirect()->route('gallery.data.index')->with('success', 'Gallery deleted successfully.');
    }

    // Kategor Poliklinik
    public function indexKategoriPoliklinik(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan logo jika ada
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('icons', 'public');
        } else {
            $iconPath = null;
        }



        // Simpan data
        DB::table('doctor_polyclinics')->insert([
            'name' => $request->input('name'),
            'logo' => $iconPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('category-polyclinic.data.index')->with('success', 'Polyclinic created successfully.');
    }

    public function createKategoriPoliklinik(Request $request)
    {

    }

    public function destroyKategoriPoliklinik(Request $request, $id)
    {

    }
}
