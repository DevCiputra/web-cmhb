<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use App\Models\BloodGroup;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        // Mengambil data pengguna yang sedang login
        $user = Auth::user();

        // Mengambil data pasien terkait dengan pengguna dan memuat relasi `allergies` serta `bloodGroups`
        $patient = Patient::with(['allergies', 'bloodGroup'])->where('user_id', $user->id)->first();

        // dd($patient);
        // Mengambil data reservasi pasien dengan memuat relasi `doctorConsultation`
        $reservations = Reservation::with('status', 'doctorConsultationReservation')
        ->where('patient_id', $patient->id)
        ->orderBy('created_at', 'desc')
        ->get();


        $title = 'Akun Saya';

        // dd($reservations);

        // Mengirimkan data pengguna, pasien, dan reservasi ke view
        return view('account.contents.index', compact('title', 'user', 'patient', 'reservations'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'allergy' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:3',
        ]);

        // Mengambil data pengguna yang sedang login
        $user = Auth::user();
        $patient = Patient::findOrFail($id); // Mengambil pasien berdasarkan ID

        // Variabel untuk menyimpan path foto profil
        $profilePicture = $user->profile_picture; // Menggunakan foto lama sebagai default

        // Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture')->store('profiles', 'public');
            // Update foto profil pada tabel users
            $user->profile_picture = $profilePicture; // Simpan path baru ke variabel user
        }

        // Update informasi pengguna
        DB::table('users')->where('id', $user->id)->update([
            'email' => $request->email,
            'profile_picture' => $profilePicture, // Menyimpan path foto profil yang baru atau lama
        ]);

        // Update informasi pasien
        DB::table('patients')->where('id', $patient->id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'profile_picture' => $profilePicture, // Menyimpan path foto profil yang baru atau lama
        ]);

        // Update atau buat data alergi di tabel `allergies`
        if ($request->filled('allergy')) {
            $allergy = Allergy::where('patient_id', $patient->id)->first();
            if ($allergy) {
                $allergy->name = $request->input('allergy');
                $allergy->save();
            } else {
                Allergy::create([
                    'name' => $request->input('allergy'),
                    'patient_id' => $patient->id,
                ]);
            }
        }

        // Update atau buat data golongan darah di tabel `blood_groups`
        if ($request->filled('blood_type')) {
            $bloodGroup = BloodGroup::where('patient_id', $patient->id)->first();
            if ($bloodGroup) {
                $bloodGroup->name = $request->input('blood_type');
                $bloodGroup->save();
            } else {
                BloodGroup::create([
                    'name' => $request->input('blood_type'),
                    'patient_id' => $patient->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

}
