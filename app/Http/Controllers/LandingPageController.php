<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorPolyclinic;
use App\Models\Service;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $title = 'Ciputra Mitra Hospital';
        return view('landing-page.contents.landing-page', compact('title'));
    }

    // Method untuk menampilkan daftar dokter
    // Method untuk menampilkan daftar dokter
    public function doctor(Request $request)
    {
        $title = 'Cari Dokter';

        // Mengambil data dokter dengan pagination, beserta relasi poliklinik dan foto
        $doctors = Doctor::with(['polyclinic', 'photos'])->paginate(8);

        // Fetch all polyclinics for the dropdown
        $polyclinics = DoctorPolyclinic::all();

        // Get distinct specialization names for the dropdown
        $specializations = Doctor::select('specialization_name')->distinct()->pluck('specialization_name');

        return view('landing-page.contents.doctor', compact('title', 'doctors', 'polyclinics', 'specializations'));
    }

    // Method untuk menampilkan profil dokter
    public function showDoctor($id)
    {
        // Ambil data dokter berdasarkan ID
        $doctor = Doctor::with(['photos', 'education', 'schedules', 'medias'])->find($id);

        // Kembali ke view untuk menampilkan detail dokter
        return view('landing-page.contents.doctor-profile', compact('doctor'));
    }

    // Method untuk menampilkan daftar layanan Medical Check Up (MCU)
    public function medicalCheckUp()
    {
        $title = 'Medical Check Up';

        // Fetching the data for published medical check-up packages with pagination
        $mcus = Service::where('service_category_id', 1) // Replace 1 with the actual MCU category ID
            ->where('is_published', 1) // Get only published services
            ->with('medias') // Eager load related media
            ->paginate(8); // Set the number of items per page (e.g., 8)

        return view('landing-page.contents.medical-check-up', compact('title', 'mcus'));
    }




    // Method untuk menampilkan detail layanan Medical Check Up (MCU)
    public function showMcuDetail($id)
    {
        // Ambil data MCU berdasarkan ID
        $mcuService = Service::with(['medias'])->findOrFail($id);

        // Return the view for the MCU detail, passing the $mcuService variable
        return view('landing-page.contents.medical-check-up-detail', compact('mcuService'));
    }

    public function homeService()
    {
        $title = 'Home Service';
        return view('landing-page.contents.home-service', compact('title'));
    }

    public function polyclinic()
    {
        $title = 'Poliklinik';
        return view('landing-page.contents.polyclinic', compact('title'));
    }

    public function promotion()
    {
        $title = 'Promosi';
        return view('landing-page.contents.promotion', compact('title'));
    }

    public function information()
    {
        $title = 'Informasi';
        return view('landing-page.contents.information', compact('title'));
    }

    public function consultation()
    {
        $title = 'Konsultasi Online';

        $doctors = Doctor::with(['polyclinic', 'photos'])->paginate(8);

        // Fetch all polyclinics for the dropdown
        $polyclinics = DoctorPolyclinic::all();

        // Get distinct specialization names for the dropdown
        $specializations = Doctor::select('specialization_name')->distinct()->pluck('specialization_name');

        return view('landing-page.contents.consultation', compact('title', 'doctors', 'polyclinics', 'specializations'));
    }

    public function consultationShow($id)
    {

        // Ambil data dokter berdasarkan ID
        $doctor = Doctor::with(['photos', 'education', 'schedules', 'medias'])->find($id);

        // Kembali ke view untuk menampilkan detail dokter
        return view('landing-page.contents.doctor-profile', compact('doctor'));
    }
}
