<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use App\Models\BloodGroup;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\ReservationLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
class AccountController extends Controller
{
    public function index()
    {
        try {
            // Set locale ke bahasa Indonesia
            Carbon::setLocale('id');

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated.'], Response::HTTP_UNAUTHORIZED);
            }

            $patient = Patient::with(['allergies', 'bloodGroup'])
            ->where('user_id', $user->id)
            ->firstOrFail();

            // Konversi 'dob' menjadi objek Carbon jika ada
            if ($patient->dob) {
                $patient->dob = Carbon::parse($patient->dob);
            }

            $reservations = Reservation::with('status', 'doctorConsultationReservation')
            ->where('patient_id', $patient->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($reservation) {
                    $doctorConsultation = $reservation->doctorConsultationReservation;

                if ($doctorConsultation) {
                    $doctorConsultation->formatted_date = Carbon::parse($doctorConsultation->agreed_consultation_date)
                        ->translatedFormat('l, d-m-Y');
                    $doctorConsultation->formatted_time = Carbon::parse($doctorConsultation->agreed_consultation_time)
                        ->format('H.i') . ' WITA';
                }

                    return $reservation;
                });

            $title = 'Akun Saya';

            return view('account.contents.index', compact('title', 'user', 'patient', 'reservations'));
        } catch (\Exception $e) {
            Log::error('Error in AccountController@index: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch account data.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'address' => 'required|string|max:255',
                'allergy' => 'nullable|string|max:255',
                'blood_type' => 'nullable|string|max:3','dob' => 'nullable|date',
            ], [
                'profile_picture.image' => 'Foto profil harus berupa gambar.',
                'profile_picture.mimes' => 'Foto profil harus bertipe jpg, jpeg, atau png.',
                'profile_picture.max' => 'Foto profil maksimal ukuran 2MB.',
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.string' => 'Nama lengkap harus berupa string.',
                'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
                'address.required' => 'Alamat wajib diisi.',
                'address.string' => 'Alamat harus berupa string.',
                'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
                'allergy.string' => 'Alergi harus berupa string.',
                'allergy.max' => 'Alergi tidak boleh lebih dari 255 karakter.',
                'blood_type.string' => 'Golongan darah harus berupa string.',
                'blood_type.max' => 'Golongan darah tidak boleh lebih dari 3 karakter.',
                'dob.date' => 'Tanggal lahir tidak valid.',
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated.'], Response::HTTP_UNAUTHORIZED);
            }

            $patient = Patient::findOrFail($id);

            // Cek apakah ada unggahan foto baru
            if ($request->hasFile('profile_picture')) {
                if ($patient->profile_picture && Storage::disk('public')->exists($patient->profile_picture)) {
                    Storage::disk('public')->delete($patient->profile_picture);
                }
                $profilePicture = $request->file('profile_picture')->store('profiles', 'public');
            } else {
                $profilePicture = $patient->profile_picture;
            }

            // Update dalam transaksi
            DB::transaction(function () use ($user, $patient, $validated, $profilePicture) {
                DB::table('users')->where('id', $user->id)->update([
                    'email' => $validated['email'],
                    'profile_picture' => $profilePicture,
                ]);

                $patient->update([
                    'name' => $validated['name'],
                    'address' => $validated['address'],
                    'dob' => $validated['dob'],
                    'profile_picture' => $profilePicture,
                ]);

                if (request()->filled('allergy')) {
                    $allergy = Allergy::firstOrNew(['patient_id' => $patient->id]);
                    $allergy->name = request('allergy');
                    $allergy->save();
                }

                if (request()->filled('blood_type')) {
                    $bloodGroup = BloodGroup::firstOrNew(['patient_id' => $patient->id]);
                    $bloodGroup->name = request('blood_type');
                    $bloodGroup->save();
                }
            });

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } catch (ValidationException $e) {
            // Kembali ke halaman sebelumnya dengan pesan error validasi
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Patient not found: ' . $e->getMessage());
            return response()->json(['error' => 'Patient not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Error in AccountController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profil.'])
                ->withInput();
        }
    }

}
