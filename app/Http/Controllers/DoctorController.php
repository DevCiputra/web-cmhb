<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorEducation;
use App\Models\DoctorMedia;
use App\Models\DoctorPhoto;
use App\Models\DoctorPolyclinic;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function indexDataDoctor(Request $request)
    {
        // Ambil query pencarian dari request
        $query = $request->input('query');

        // Mengambil data dokter dengan relasi, dan jika ada query pencarian, lakukan pencarian
        $doctors = Doctor::search($query)->paginate(8); // Atur jumlah data per halaman

        // Ambil semua spesialisasi unik dari dokter
        $specializations = Doctor::distinct()->pluck('specialization_name');

        return view('management-data.doctor.index', compact('doctors', 'specializations'));
    }

    public function updatePublishedStatus($id)
    {
        $doctor = Doctor::findOrFail($id);

        // Toggle status is_published
        $doctor->is_published = !$doctor->is_published; // Toggle nilai is_published
        $doctor->save();

        return redirect()->route('doctor.data.index')->with('success', 'Status publikasi dokter berhasil diperbarui!');
    }


    // DoctorController.php

    public function searchDoctor(Request $request)
    {
        $query = $request->input('query');

        // Menggunakan metode search dari model Doctor
        $doctors = Doctor::search($query);

        return response()->json($doctors);
    }

    // Menampilkan halaman form tambah dokter
    public function create()
    {
        // Mengambil semua data dari tabel DoctorEducation dan DoctorPolyclinic
        $educations = DoctorEducation::all();
        $polyclinics = DoctorPolyclinic::all();

        return view('management-data.doctor.create', compact('educations', 'polyclinics'));
    }

    // Menyimpan data dokter baru
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'specialization_name' => 'required|string|max:255',
            'doctor_polyclinic_id' => 'required|exists:doctor_polyclinics,id', // Validasi poliklinik
            'address' => 'nullable|string|max:255',
            'doctor_photos' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048','doctor_medias' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'consultation_fee' => 'nullable|numeric|min:0',
            'is_published' => 'nullable|string',
            'is_open_consultation' => 'nullable|string',
            'is_open_reservation' => 'nullable|string',
            'doctor_schedule' => 'nullable|string',  // Validasi jadwal sebagai teks bebas
        ]);

        $doctor = Doctor::create([
            'name' => $request->input('name'),
            'specialization_name' => $request->input('specialization_name'),
            'doctor_polyclinic_id' => $request->input('doctor_polyclinic_id'),
            'address' => $request->input('address'),
            'consultation_fee' => $request->input('consultation_fee', 0),
            'email' => null,
            'is_published' => $request->input('is_published', '0'),
            'is_open_consultation' => $request->input('is_open_consultation', '0'),
            'is_open_reservation' => $request->input('is_open_reservation', '0'),
        ]);


        // Simpan pendidikan dokter
        DoctorEducation::create([
            'doctor_id' => $doctor->id,
            'name' => $request->input('education'), // Simpan nama pendidikan
        ]);

        // Proses dan simpan foto dokter
        if ($request->hasFile('doctor_photos')) {
            $photo = $request->file('doctor_photos');
            $photoName = time() . '_' . $photo->getClientOriginalName();

            // Simpan foto di subfolder berdasarkan ID dokter
            $photoPath = $photo->storeAs('doctor/photos/' . $doctor->id, $photoName, 'public');

            DoctorPhoto::create([
                'doctor_id' => $doctor->id,
                'name' => $photoName,
                'mime_type' => $photo->getClientMimeType(),
            ]);
        }

        // Proses dan simpan curriculum vitae (CV)
        if ($request->hasFile('doctor_medias')) {
            $cv = $request->file('doctor_medias');
            $cvName = time() . '_' . $cv->getClientOriginalName();

            // Simpan media di subfolder berdasarkan ID dokter
            $cvPath = $cv->storeAs('doctor/medias/' . $doctor->id, $cvName, 'public');

            DoctorMedia::create([
                'doctor_id' => $doctor->id,
                'name' => $cvName,
                'mime_type' => $cv->getClientMimeType(),
            ]);
        }

        // Simpan jadwal sebagai teks bebas
        DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'schedule' => $request->input('doctor_schedule'),  // Simpan teks jadwal
        ]);

        return redirect()->route('doctor.data.index')->with('success', 'Data dokter berhasil disimpan.');
    }


    public function show($id)
    {
        // Mengambil data dokter berdasarkan ID beserta relasi ke poliklinik, pendidikan, jadwal, dan media
        $doctor = Doctor::with(['polyclinic', 'education', 'schedules', 'medias'])->findOrFail($id);

        // dd($doctor);
        return view('management-data.doctor.detail', compact('doctor'));
    }



    public function edit($id)
    {
        // Mengambil data dokter berdasarkan id
        $doctor = Doctor::with(['photos', 'education', 'polyclinic', 'schedules'])->findOrFail($id);

        // Ambil data jadwal dalam format yang sesuai untuk editor Trix
        $schedule = $doctor->schedules->pluck('schedule')->implode('<br>'); // Gabungkan jadwal ke dalam satu string

        $educations = DoctorEducation::all();
        $polyclinics = DoctorPolyclinic::all();

        return view('management-data.doctor.edit', compact('doctor', 'educations', 'polyclinics', 'schedule'));
    }


    // Memperbarui data dokter
    public function update(Request $request, $id)
    {

        // Validasi input, tanpa email dan is_published
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'specialization_name' => 'required|string|max:255',
            'education' => 'required|string|max:500', // Validasi untuk textarea pendidikan
            'doctor_polyclinic_id' => 'required|exists:doctor_polyclinics,id',
            'address' => 'required|url',
            'doctor_photos' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'doctor_medias' => 'nullable|file|mimes:pdf,doc,docx|max:2048','consultation_fee' => 'required|numeric|min:0',
            'doctor_schedule' => 'nullable|string',  // Validasi jadwal sebagai teks bebas
        ]);

        // Mengupdate data dokter
        $doctor = Doctor::findOrFail($id);
        $doctor->update([
            'name' => $validatedData['name'],
            'specialization_name' => $validatedData['specialization_name'],
            'doctor_polyclinic_id' => $validatedData['doctor_polyclinic_id'],
            'address' => $validatedData['address'],
            'consultation_fee' => $validatedData['consultation_fee'],
            // Kolom email dan is_published tidak diupdate, tetapi is_open_reservation dan is_open_consultation bisa diupdate
            'is_open_reservation' => $request->has('is_open_reservation') ? $request->input('is_open_reservation') : $doctor->is_open_reservation,
            'is_open_consultation' => $request->has('is_open_consultation') ? $request->input('is_open_consultation') : $doctor->is_open_consultation,
        ]);

        // Mengupdate pendidikan dokter
        $doctorEducation = $doctor->education;
        if ($doctorEducation) {
            $doctorEducation->update(['name' => $validatedData['education']]);
        } else {
            DoctorEducation::create(['doctor_id' => $doctor->id, 'name' => $validatedData['education']]);
        }

        // Mengupdate atau menambah foto dokter
        if ($request->hasFile('doctor_photos')) {
            // Menghapus foto lama
            foreach ($doctor->photos as $photo) {
                Storage::delete('public/doctor/photos/' . $doctor->id . '/' . $photo->name);
                $photo->delete();
            }

            // Menyimpan foto baru
            $file = $request->file('doctor_photos');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/doctor/photos/' . $doctor->id, $filename);
            DoctorPhoto::create(['doctor_id' => $doctor->id, 'name' => $filename, 'mime_type' => $file->getMimeType()]);
        }

        // Mengupdate atau menambah CV dokter
        if ($request->hasFile('doctor_medias')) {
            // Menghapus media lama
            foreach ($doctor->medias as $media) {
                Storage::delete('public/doctor/medias/' . $doctor->id . '/' . $media->name);
                $media->delete();
            }

            // Menyimpan CV baru
            $file = $request->file('doctor_medias');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/doctor/medias/' . $doctor->id, $filename);
            DoctorMedia::create(['doctor_id' => $doctor->id, 'name' => $filename, 'mime_type' => $file->getMimeType()]);
        }

        // Update jadwal dokter
        if ($request->has('doctor_schedule')) {
            $schedule = DoctorSchedule::where('doctor_id', $doctor->id)->first();
            if ($schedule) {
                $schedule->update(['schedule' => $request->input('doctor_schedule')]);
            } else {
                DoctorSchedule::create([
                    'doctor_id' => $doctor->id,
                    'schedule' => $request->input('doctor_schedule'),
                ]);
            }
        }

        return redirect()->route('doctor.data.index')->with('success', 'Data dokter berhasil diperbarui!');
    }

    // Menghapus data dokter
    public function destroy($id)
    {
        // Menghapus data dokter berdasarkan id
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('doctor.data.index')->with('success', 'Data dokter berhasil dihapus.');
    }


    // Menampilkan daftar poliklinik dokter
    public function indexPolyclinicDoctor()
    {
        $polyclinics = DoctorPolyclinic::all();
        return view('management-data.doctor.polyclinic.index', compact('polyclinics'));
    }
    // Menampilkan form create data Poliklinik Dokter
    public function createPolyclinicDoctor()
    {
        return view('management-data.doctor.polyclinic.create');
    }
    // Menyimpan data poliklinik dokter dari form
    public function storePolyclinicDoctor(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Membuat data baru di tabel doctor_polyclinic
        DoctorPolyclinic::create([
            'name' => $request->name,
        ]);

        // Redirect setelah data berhasil disimpan
        return redirect()->route('doctor.polyclinic.index')->with('success', 'Data poliklinik berhasil ditambahkan!');
    }
    // Menampilkan form edit poliklinik dokter
    public function editPolyclinicDoctor($id)
    {
        $polyclinic = DoctorPolyclinic::findOrFail($id); // Cari poliklinik berdasarkan id
        return view('management-data.doctor.polyclinic.edit', compact('polyclinic'));
    }
    // Mengupdate data poliklinik dokter
    public function updatePolyclinicDoctor(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $polyclinic = DoctorPolyclinic::findOrFail($id);
        $polyclinic->update([
            'name' => $request->name,
        ]);

        return redirect()->route('doctor.polyclinic.index')->with('success', 'Poliklinik berhasil diperbarui.');
    }
    // Menghapus poliklinik dokter
    public function deletePolyclinicDoctor($id)
    {
        $polyclinic = DoctorPolyclinic::findOrFail($id);
        $polyclinic->delete();

        return redirect()->route('doctor.polyclinic.index')->with('success', 'Poliklinik berhasil dihapus.');
    }
}
