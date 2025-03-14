<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorPolyclinic;
use App\Models\HospitalInformation;
use App\Models\Information;
use App\Models\Service;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $title = 'Ciputra Mitra Hospital';

        // Data promo: informasi dengan kategori 2
        $promotions = Information::where('information_category_id', 2)
            ->where('is_published', 1)
            ->with('media') // Mengambil media terkait
            ->latest()
            ->take(3)
            ->get();

        // Data artikel: informasi dengan kategori 1
        $articles = Information::where('information_category_id', 1)
            ->where('is_published', 1)
            ->with('media') // Mengambil media terkait
            ->latest()
            ->take(3)
            ->get();

        // Data hospital information
        $hospitalInformation = HospitalInformation::first(); // Mengambil data pertama dari tabel

        return view('landing-page.contents.landing-page', compact('title', 'promotions', 'articles', 'hospitalInformation'));
    }


    // Method untuk menampilkan daftar dokter
    public function doctor(Request $request)
    {
        $title = 'Cari Dokter';

        // Mengambil query pencarian dari request
        $query = $request->input('search');

        // Fetching the data for doctors with related polyclinic and photo data, with pagination
        $doctors = Doctor::with(['polyclinic', 'photos'])
            ->where('is_published', 1) // Menambahkan filter untuk is_published = 1
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'LIKE', "%{$query}%") // Pencarian berdasarkan nama dokter
                    ->orWhere('specialization_name', 'LIKE', "%{$query}%") // Atau berdasarkan spesialisasi
                    ->orWhereHas('polyclinic', function ($subQuery) use ($query) { // Atau berdasarkan poliklinik
                        $subQuery->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->paginate(70); // Menentukan jumlah item per halaman (misalnya, 8)

        // Fetch all polyclinics and specializations for the dropdown
        $polyclinics = DoctorPolyclinic::all();
        $specializations = Doctor::select('specialization_name')->distinct()->pluck('specialization_name');

        return view('landing-page.contents.doctor', compact('title', 'doctors', 'polyclinics', 'specializations', 'query'));
    }

    public function searchDoctor(Request $request)
    {
        $query = $request->input('query');

        // Menggunakan method search dari model
        $doctors = Doctor::search($query)->with('polyclinic')->get();

        return response()->json($doctors);
    }


    // Method untuk menampilkan profil dokter
    public function showDoctor($id)
    {
        $title = 'Profile Dokter';
        // Ambil data dokter berdasarkan ID
        $doctor = Doctor::with(['photos', 'education', 'schedules', 'medias'])->find($id);

        // Kembali ke view untuk menampilkan detail dokter
        return view('landing-page.contents.doctor-profile', compact('doctor', 'title'));
    }

    // Method untuk menampilkan daftar layanan Medical Check Up (MCU)
    public function medicalCheckUp(Request $request)
    {
        $title = 'Medical Check Up';

        // Mengambil query pencarian dari request
        $query = $request->input('search');

        // Fetching the data for published medical check-up packages with pagination
        $mcus = Service::where('service_category_id', 1) // Ganti 1 dengan ID kategori MCU yang sebenarnya
            ->where('is_published', 1) // Hanya ambil layanan yang dipublikasikan
            ->with('medias') // Eager load media terkait
            ->when($query, function ($q) use ($query) {
                return $q->where('title', 'LIKE', "%{$query}%"); // Pencarian berdasarkan judul paket MCU
            })
            ->paginate(8); // Set jumlah item per halaman (misalnya, 8)

        return view('landing-page.contents.medical-check-up', compact('title', 'mcus', 'query'));
    }

    public function searchMCU(Request $request)
    {
        $query = $request->input('query');

        // Using the search method from the MedicalCheckUp model
        $mcus = Service::search($query)->get();

        return response()->json($mcus);
    }

    // Method untuk menampilkan detail layanan Medical Check Up (MCU)
    public function showMcuDetail($id)
    {

        $title = 'Medical Check Up';

        // Ambil data MCU berdasarkan ID
        $mcuService = Service::with(['medias'])->findOrFail($id);

        // Return the view for the MCU detail, passing the $mcuService variable
        return view('landing-page.contents.medical-check-up-detail', compact('mcuService', 'title'));
    }

    public function homeService()
    {
        $title = 'Home Service';
        return view('landing-page.contents.home-service', compact('title'));
    }

    public function polyclinic(Request $request)
    {
        $title = 'Poliklinik';

        // Mengambil nilai query dari request
        $query = $request->input('query');

        // Jika query ada, lakukan pencarian, jika tidak tampilkan semua poliklinik
        if ($query) {
            $polyclinics = DoctorPolyclinic::search($query)->paginate(5);
        } else {
            $polyclinics = DoctorPolyclinic::paginate(5); // Menampilkan semua poliklinik jika tidak ada pencarian
        }

        return view('landing-page.contents.polyclinic', compact('title', 'polyclinics', 'query'));
    }

    public function searchPolyclinic(Request $request)
    {
        $query = $request->input('query');

        // Menggunakan metode search dari model DoctorPolyclinic
        $polyclinics = DoctorPolyclinic::search($query)->get();

        return response()->json($polyclinics);
    }

    public function promotion(Request $request)
    {
        $query = Information::where('information_category_id', 2);
        $title = 'Promosi';

        $promotions = Information::where('information_category_id', 2)
            ->where('is_published', 1)
            ->with('media') // Mengambil media terkait
            ->latest()
            ->paginate(6);

        // Filter berdasarkan flag jika ada
        if ($request->has('flag') && $request->flag != '') {
            $query->where('flag', $request->flag);
        }

        return view('landing-page.contents.promotion', compact('title', 'promotions'));
    }


    public function article(Request $request)
    {
        $title = 'Article';
        $keyword = $request->input('keyword');
        $flag = $request->input('flag'); // Ambil nilai filter kategori

        // Menyaring artikel berdasarkan kata kunci dan kategori
        $articles = Information::where('information_category_id', 1)->where('is_published', 1)
            ->when($keyword, function ($query, $keyword) {
                return $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%$keyword%")
                        ->orWhere('description', 'like', "%$keyword%");
                });
            })
            ->when($flag, function ($query, $flag) {
                return $query->where('flag', $flag); // Filter berdasarkan flag
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12); // Membatasi jumlah artikel yang ditampilkan per halaman

        return view('landing-page.contents.information', compact('title', 'articles'));
    }


    public function searchArticle(Request $request)
    {
        $query = $request->query('query');
        $articles = Information::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(12); // Sesuaikan jumlah pagination

        return response()->json([
            'articles' => $articles->items(),
            'pagination' => $articles->links()->render(),
        ]);
    }

    public function showArticleDetail($id)
    {
        $title = 'Detail Artikel';

        // Ambil data artikel berdasarkan ID
        $article = Information::with(['media'])->findOrFail($id); // Ambil artikel beserta media (gambar atau file terkait)

        // Ambil 3 artikel lain sebagai rekomendasi
        $recommendedArticles = Information::where('information_category_id', 1)
        ->where('is_published', 1)
        ->where('id', '!=', $id) // Pastikan artikel yang ditampilkan bukan artikel yang sedang dibuka
        ->inRandomOrder()
        ->take(3)
        ->get();

        // Return the view for the article detail, passing the $article variable
        return view('landing-page.contents.information-detail', compact('article', 'title','recommendedArticles'));
    }









    public function consultation(Request $request)
    {
        $title = 'Konsultasi Online';

        // Mengambil query pencarian dari request
        $query = $request->input('search');

        // Fetching the data for doctors with related polyclinic and photo data, with pagination
        $doctors = Doctor::with(['polyclinic', 'photos'])
            ->where('is_published', 1)  // Menambahkan filter untuk hanya mengambil dokter yang terbit
            ->where('is_open_consultation', 1) // Menambahkan filter untuk dokter yang membuka konsultasi
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'LIKE', "%{$query}%") // Pencarian berdasarkan nama dokter
                    ->orWhere('specialization_name', 'LIKE', "%{$query}%") // Atau berdasarkan spesialisasi
                    ->orWhereHas('polyclinic', function ($subQuery) use ($query) { // Atau berdasarkan poliklinik
                        $subQuery->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->paginate(100); // Menentukan jumlah item per halaman (misalnya, 8)

        // Fetch all polyclinics for the dropdown
        $polyclinics = DoctorPolyclinic::all();

        // Get distinct specialization names for the dropdown
        $specializations = Doctor::select('specialization_name')->distinct()->pluck('specialization_name');

        return view('landing-page.contents.consultation', compact('title', 'doctors', 'polyclinics', 'specializations', 'query'));
    }


    public function consultationShow($id)
    {
        // Ambil data dokter berdasarkan ID
        $doctor = Doctor::with(['photos', 'education', 'schedules', 'medias'])->find($id);

        // Kembali ke view untuk menampilkan detail dokter
        return view('landing-page.contents.doctor-profile', compact('doctor'));
    }

    public function searchConsultation(Request $request)
    {
        $query = $request->input('query');

        // Menggunakan method search dari model
        $doctors = Doctor::search($query)->with('polyclinic')->get();

        return response()->json($doctors);
    }

    public function bmiCalculator()
    {
        $title = 'BMI Calculator';
        return view('landing-page.contents.bmi', compact('title'));
    }

    public function fileSharing()
    {
        $title = 'MCU File';
        return view('landing-page.contents.file-sharing', compact('title'));
    }


    public function coming()
    {
        $title = 'Coming Soon';
        return view('landing-page.contents.coming-soon', compact('title'));
    }
}
