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
use Symfony\Component\HttpFoundation\Response;
class AccountController extends Controller
{
    public function index()
    {
        try {
            // Set lokal secara eksplisit
            Carbon::setLocale('id');

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated.'], Response::HTTP_UNAUTHORIZED);
            }

            $patient = Patient::with(['allergies', 'bloodGroup'])
            ->where('user_id', $user->id)
            ->firstOrFail();

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
                'blood_type' => 'nullable|string|max:3',
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated.'], Response::HTTP_UNAUTHORIZED);
            }

            $patient = Patient::findOrFail($id);

            $profilePicture = $user->profile_picture;

            if ($request->hasFile('profile_picture')) {
                $profilePicture = $request->file('profile_picture')->store('profiles', 'public');
                $user->profile_picture = $profilePicture;
            }

            DB::transaction(function () use ($user, $patient, $validated, $profilePicture) {
                DB::table('users')->where('id', $user->id)->update([
                    'email' => $validated['email'],
                    'profile_picture' => $profilePicture,
                ]);

                DB::table('patients')->where('id', $patient->id)->update([
                    'name' => $validated['name'],
                    'address' => $validated['address'],
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Patient not found: ' . $e->getMessage());
            return response()->json(['error' => 'Patient not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Error in AccountController@update: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update profile.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
