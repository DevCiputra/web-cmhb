<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorConsultationReservation;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\PaymentRecord;
use App\Models\Reservation;
use App\Models\ReservationLog;
use App\Models\ReservationStatus;
use App\Models\ZoomAccount;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OnlineConsultationController extends Controller
{

    protected function getActiveZoomAccount()
    {
        return ZoomAccount::where('active', true)->inRandomOrder()->first();
    }

    public function showConsultationForm($doctor_id)
    {
        $title = 'Reservasi Konsultasi Online';
        $doctor = Doctor::findOrFail($doctor_id);
        $user = auth()->user();

        return view('landing-page.contents.online-consultation.form', compact('doctor', 'user', 'title'));
    }

    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'doctor_id' => 'required|exists:doctors,id',
            'preferred_consultation_date' => 'required|date',
        ]);

        $user = auth()->user();
        $patient = Patient::where('user_id', $user->id)->firstOrFail();

        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $code = $this->generateReservationCode($doctor->name);

        $reservation = Reservation::create([
            'patient_id' => $patient->id,
            'reservation_status_id' => ReservationStatus::where('name', 'Menunggu Approval')->first()->id,
            'service_category_id' => 4, // Asumsikan untuk konsultasi
            'status_pembayaran' => 'Menunggu Pembayaran',
            'code' => $code,
        ]);

        DoctorConsultationReservation::create([
            'reservation_id' => $reservation->id,
            'doctor_id' => $validated['doctor_id'],'preferred_consultation_date' => $validated['preferred_consultation_date'],
            'zoom_account_id' => null, // Atur ke null jika tidak ada nilai
        ]);

        return redirect()->route('consultation.confirmation', $reservation->id)
            ->with('success', 'Reservasi berhasil dibuat!');
    }

    private function generateReservationCode($doctorName)
    {
        $initials = collect(explode(' ', $doctorName))->map(function ($part) {
            return preg_match('/^[A-Za-z]/', $part) ? strtoupper(substr($part, 0, 1)) : '';
        })->implode('');

        $today = date('dmY');
        $reservationCount = Reservation::whereDate('created_at', today())->count();
        $reservationNumber = str_pad($reservationCount + 1, 2, '0', STR_PAD_LEFT);

        return "{$today}{$initials}{$reservationNumber}";
    }

    public function showConfirmation($id)
    {
        $title = 'Konfirmasi Reservasi Konsultasi';
        $reservation = Reservation::with('doctorConsultationReservation', 'patient')->findOrFail($id);

        return view('landing-page.contents.online-consultation.confirmation', compact('reservation', 'title'));
    }

    public function showConsultationDetail($id)
    {
        $title = 'Detail Reservasi Konsultasi';
        $reservation = Reservation::with('doctorConsultationReservation', 'patient', 'status')->findOrFail($id);

        return view('landing-page.contents.online-consultation.detail', compact('reservation', 'title'));
    }

    public function showInvoice($id)
    {
        $title = 'Invoice Reservasi Konsultasi';
        $invoice = Reservation::with([
            'doctorConsultationReservation.doctor',
            'patient.user',
            'paymentRecords',
        ])->where('id', $id)->firstOrFail();

        return view('landing-page.contents.online-consultation.invoice', compact('invoice', 'title'));
    }

    public function confirmPayment(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'payment_proof' => 'required|image|max:2048',
            'payment_method' => 'required|string',
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diunggah.',
            'payment_proof.image' => 'File yang diunggah harus berupa gambar.',
            'payment_proof.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'payment_method.required' => 'Metode pembayaran harus dipilih.',
        ]);

        $fileName = time() . '.' . $request->payment_proof->extension();
        $filePath = $request->file('payment_proof')->storeAs('payment_proofs', $fileName, 'public');

        PaymentRecord::create([
            'reservation_id' => $reservation->id,
            'payment_method' => $validated['payment_method'],
            'payment_proof' => $filePath,
            'payment_confirmation_date' => now(),
        ]);

        $reservation->update([
            'status_pembayaran' => 'Lunas',
        ]);

        return redirect()->route('consultation.detail', $id)->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function cancelReservation(Request $request, $id)
    {

        // Validasi input
        $request->validate([
            'reason' => 'required|string|max:255',
            'password' => 'required',
        ]);

        dd($request);
        $reservation = Reservation::findOrFail($id);

        // Ubah status reservasi menjadi 'Batal'
        $reservation->update(['reservation_status_id' => ReservationStatus::where('name', 'Batal')->first()->id]);

        return redirect()->back()->with('success', 'Reservation has been cancelled.');
    }


    public function approveReservation(Request $request, $id)
    {
        $validated = $request->validate([
            'agreed_consultation_date' => 'required|date',
            'agreed_consultation_time' => 'required|date_format:H:i',
        ]);

        $reservation = Reservation::with('doctorConsultationReservation.doctor')->findOrFail($id);

        $reservation->doctorConsultationReservation->update([
            'agreed_consultation_date' => $validated['agreed_consultation_date'],
            'agreed_consultation_time' => $validated['agreed_consultation_time'],
        ]);

        try {
            // Pilih akun Zoom secara bergantian
            $zoomAccount = $this->getNextZoomAccount();
            $zoomMeeting = $this->createMeeting(new Request([
                'title' => "Konsultasi dengan Dr. {$reservation->doctorConsultationReservation->doctor->name}",
                'start_date_time' => "{$validated['agreed_consultation_date']} {$validated['agreed_consultation_time']}",
                'duration_in_minute' => 60,
                'alternative_hosts' => $reservation->doctorConsultationReservation->doctor->email,
            ]), $reservation->id);

            // Simpan link Zoom di database
            $reservation->doctorConsultationReservation->update([
                'zoom_link' => $zoomMeeting['join_url'],
                'zoom_host_link' => $zoomMeeting['start_url'],
                'zoom_password' => $zoomMeeting['password'],
            ]);

            // Perbarui status reservasi
            $reservation->update([
                'reservation_status_id' => ReservationStatus::where('name', 'Berhasil')->first()->id,
            ]);

            return redirect()->back()->with('success', 'Reservation approved and Zoom meeting created.');
        } catch (\Throwable $th) {
            Log::error('Error creating Zoom meeting:', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create Zoom meeting.');
        }
    }


    public function createMeeting(Request $request, $reservationId): array
    {
        $validated = $this->validate($request, [
            'title' => 'required|string|max:255',
            'start_date_time' => 'required|date',
            'duration_in_minute' => 'required|numeric',
            'alternative_hosts' => 'required|email',
        ]);

        $zoomAccount = $this->getActiveZoomAccount();
        $token = $this->generateToken($zoomAccount);

        try {
            $response = Http::withToken($token)->post('https://api.zoom.us/v2/users/me/meetings', [
                'topic' => $validated['title'],
                'type' => 2,
                'start_time' => Carbon::parse($validated['start_date_time'])->toIso8601String(),
                'duration' => $validated['duration_in_minute'],
                'password' => $this->generateMeetingPassword(),
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => true,
                    'waiting_room' => true,
                    'meeting_authentication' => false,
                    'approval_type' => 0,
                ],
            ]);

            Log::info('Zoom Meeting Response:', $response->json());

            if (isset($response->json()['code'])) {
                throw new \Exception("Zoom API error: {$response->json()['message']} (Code: {$response->json()['code']})");
            }

            return $response->json();
        } catch (\Throwable $th) {
            Log::error('Error creating Zoom meeting:', ['error' => $th->getMessage()]);
            throw $th;
        }
    }


    protected function generateToken(ZoomAccount $zoomAccount): string
    {
        try {
            $base64String = base64_encode($zoomAccount->client_key . ':' . $zoomAccount->client_secret);

            $response = Http::withHeaders([
                "Content-Type" => "application/x-www-form-urlencoded",
                "Authorization" => "Basic {$base64String}"
            ])->post("https://zoom.us/oauth/token?grant_type=account_credentials&account_id={$zoomAccount->account_id}");

            $responseData = $response->json();

            Log::info('Zoom Token Response:', $responseData);

            if (!$response->successful() || !isset($responseData['access_token'])) {
                throw new \Exception("Zoom API error: " . ($responseData['message'] ?? 'Unknown error'));
            }

            return $responseData['access_token'];
        } catch (\Throwable $th) {
            Log::error('Error generating Zoom token:', ['error' => $th->getMessage()]);
            throw $th;
        }
    }


    protected function generateMeetingPassword(): string
    {
        return Str::random(8);
    }

    protected function getNextZoomAccount()
    {
        // Ambil akun yang aktif dan diurutkan berdasarkan `last_used_at` ASC.
        $zoomAccounts = ZoomAccount::where('active', true)
            ->orderBy('last_used_at', 'asc')
            ->get();

        if ($zoomAccounts->isEmpty()) {
            throw new \Exception('Tidak ada akun Zoom yang tersedia.');
        }

        // Pilih akun pertama (yang paling lama tidak dipakai)
        $selectedAccount = $zoomAccounts->first();

        // Perbarui `last_used_at` untuk akun terpilih
        $selectedAccount->update(['last_used_at' => now()]);

        return $selectedAccount;
    }
}
