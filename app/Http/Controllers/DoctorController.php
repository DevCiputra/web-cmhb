<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorEducation;
use App\Models\DoctorMedia;
use App\Models\DoctorPhoto;
use App\Models\DoctorPolyclinic;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function indexDataDoctor()
    {
        // Mengambil semua data dokter dengan relasi ke tabel pendidikan dan poliklinik
        $doctors = Doctor::with(['education', 'polyclinic'])->get();

        // Ambil semua spesialisasi unik dari dokter
        $specializations = Doctor::distinct()->pluck('specialization_name');

        return view('management-data.doctor.index', compact('doctors', 'specializations'));
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

        // Debug request
        // dd($request->all(), $request->file('doctor_photos'), $request->file('doctor_medias'));

        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization_name' => 'required|string|max:255',
            'doctor_education_id' => 'required|exists:doctor_educations,id',
            'doctor_photos' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'doctor_medias' => 'required|file|mimes:pdf,doc,docx|max:10240', // CV dalam bentuk file
            'operation_rate' => 'required|numeric|min:0|max:100', // Validasi untuk angka keberhasilan operasi
            'doctor_schedule' => 'required|array', // Validasi untuk jadwal dokter
            'doctor_schedule.*.day_of_week' => 'required|string|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'doctor_schedule.*.start_time' => 'required|date_format:H:i',
            'doctor_schedule.*.end_time' => 'required|date_format:H:i|after:doctor_schedule.*.start_time',
        ]);

        // Simpan data dokter ke tabel 'doctors'
        $doctor = Doctor::create([
            'name' => $request->input('name'),
            'specialization_name' => $request->input('specialization_name'),
            'doctor_education_id' => $request->input('doctor_education_id'),
            'doctor_polyclinic_id' => $request->input('doctor_polyclinic_id'),
            'operation_rate' => $request->input('operation_rate'), // Simpan angka keberhasilan
        ]);

        // Proses dan simpan foto dokter
        if ($request->hasFile('doctor_photos')) {
            $photo = $request->file('doctor_photos');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('photos', $photoName, 'public'); // simpan di storage/public/photos

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
            $cvPath = $cv->storeAs('medias', $cvName, 'public'); // simpan di storage/public/medias

            DoctorMedia::create([
                'doctor_id' => $doctor->id,
                'name' => $cvName,
                'mime_type' => $cv->getClientMimeType(),
            ]);
        }

        // Simpan jadwal dokter
        foreach ($request->input('doctor_schedule') as $schedule) {
            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => $schedule['day_of_week'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
            ]);
        }

        return redirect()->route('doctor.data.index')->with('success', 'Data dokter berhasil disimpan.');
    }


    // Menampilkan halaman edit dokter
    public function edit($id)
    {
        // Mengambil data dokter berdasarkan id
        $doctor = Doctor::findOrFail($id);
        $educations = DoctorEducation::all();
        $polyclinics = DoctorPolyclinic::all();

        return view('management-data.doctor.edit', compact('doctor', 'educations', 'polyclinics'));
    }

    // Memperbarui data dokter
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'specialization_name' => 'required|string|max:255',
            'doctor_education_id' => 'required|exists:doctor_educations,id',
            'doctor_polyclinic_id' => 'required|exists:doctor_polyclinics,id',
        ]);

        // Mengambil data dokter dan meng-update-nya
        $doctor = Doctor::findOrFail($id);
        $doctor->update($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('doctor.data.index')->with('success', 'Data dokter berhasil diperbarui.');
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
