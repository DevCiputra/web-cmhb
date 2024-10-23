<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorConsultationReservation;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\PaymentRecord;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use Carbon\Carbon;
use Illuminate\Support\Str; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OnlineConsultationController extends Controller
{
    public function showConsultationForm($doctor_id)
    {
        $title = 'Reservasi Konsultasi Online';
        $doctor = Doctor::findOrFail($doctor_id);
        $user = auth()->user();

        return view('landing-page.contents.online-consultation.form', compact('doctor', 'user', 'title'));
    }

    public function storeReservation(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'patient_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'doctor_id' => 'required|exists:doctors,id',
            'preferred_consultation_date' => 'required|date',
        ]);

        // Ambil user yang sedang login dan data pasien yang terhubung
        $user = auth()->user();
        $patient = Patient::where('user_id', $user->id)->first();

        if (!$patient) {
            return redirect()->back()->with('error', 'Pasien tidak ditemukan.');
        }

        // Ambil data dokter
        $doctor = Doctor::findOrFail($validated['doctor_id']);

        // Generate kode unik untuk reservasi
        $code = $this->generateReservationCode($doctor->name);

        // Buat data reservasi di tabel `reservations`
        $reservation = Reservation::create([
            'patient_id' => $patient->id,
            'reservation_status_id' => ReservationStatus::where('name', 'Menunggu Approval')->first()->id, // Set status default
            'service_category_id' => 4, // Asumsikan untuk konsultasi
            'status_pembayaran' => 'Menunggu Pembayaran', // Set status pembayaran default
            'code' => $code,
        ]);

        // Simpan detail konsultasi ke tabel `doctor_consultation_reservations`
        DoctorConsultationReservation::create([
            'reservation_id' => $reservation->id,
            'doctor_id' => $validated['doctor_id'],
            'preferred_consultation_date' => $validated['preferred_consultation_date'],
        ]);

        // Redirect ke halaman konfirmasi dengan pesan sukses
        return redirect()->route('consultation.confirmation', $reservation->id)
            ->with('success', 'Reservasi berhasil dibuat!');
    }
    private function generateReservationCode($doctorName)
    {
        $initials = collect(explode(' ', $doctorName))->map(function ($part) {
            if (preg_match('/^[A-Za-z]/', $part)) {
                return strtoupper(substr($part, 0, 1));
            }
            return '';
        })->implode('');

        $today = date('dmY');
        $reservationCount = Reservation::whereDate('created_at', today())->count();
        $reservationNumber = str_pad($reservationCount + 1, 2, '0', STR_PAD_LEFT);

        $code = "{$today}{$initials}{$reservationNumber}";
        return $code;
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
    
        // Get the reservation to pass it to the view
        $reservation = Reservation::findOrFail($id);
    
        return view('landing-page.contents.online-consultation.invoice', compact('invoice', 'title', 'reservation'));
    }
    

    public function confirmPayment(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'payment_proof' => 'required|image|max:2048',
            'payment_method' => 'required|string',
        ]);

        $fileName = time() . '.' . $request->payment_proof->extension();
        $filePath = $request->file('payment_proof')->storeAs('payment_proofs', $fileName, 'public');

        // Simpan detail pembayaran ke tabel `payment_records`
        PaymentRecord::create([
            'reservation_id' => $reservation->id,
            'payment_method' => $validated['payment_method'],
            'payment_proof' => $filePath,
            'payment_confirmation_date' => now(),
        ]);

        // Update status pembayaran menjadi 'Lunas' tanpa mengubah `reservation_status_id`
        $reservation->update([
            'status_pembayaran' => 'Lunas',
        ]);

        return redirect()->route('consultation.detail', $id)->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function cancelReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
    
        // Ubah status reservasi menjadi 'Batal' dan status pembayaran menjadi 'Dibatalkan'
        $reservation->update([
            'reservation_status_id' => ReservationStatus::where('name', 'Batal')->first()->id,
            'status_pembayaran' => 'Dibatalkan'
        ]);
    
        return redirect()->back()->with('success', 'Reservation has been cancelled.');
    }
    

    public function approveReservation(Request $request, $id)
    {
        $validated = $request->validate([
            'agreed_consultation_date' => 'required|date',
            'agreed_consultation_time' => 'required|date_format:H:i',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->doctorConsultationReservation->update([
            'agreed_consultation_date' => $validated['agreed_consultation_date'],
            'agreed_consultation_time' => $validated['agreed_consultation_time'],
        ]);

        // Buat Zoom meeting menggunakan data yang disepakati
        $zoomMeeting = $this->createMeeting(new Request([
            'title' => "Konsultasi dengan Dr. {$reservation->doctorConsultationReservation->doctor->name}",
            'start_date_time' => "{$validated['agreed_consultation_date']} {$validated['agreed_consultation_time']}",
            'duration_in_minute' => 60,
        ]), $reservation->id);

        // Simpan detail Zoom ke dalam database
        $reservation->doctorConsultationReservation->update([
            'zoom_link' => $zoomMeeting['join_url'],
            'zoom_password' => $zoomMeeting['password'],
        ]);

        // Ubah status reservasi menjadi "Berhasil"
        $reservation->update([
            'reservation_status_id' => ReservationStatus::where('name', 'Berhasil')->first()->id,
        ]);

        return redirect()->back()->with('success', 'Reservation approved and Zoom meeting created.');
    }

    public function createMeeting(Request $request, $reservationId): array
    {
        $validated = $this->validate($request, [
            'title' => 'required|string|max:255',
            'start_date_time' => 'required|date',
            'duration_in_minute' => 'required|numeric',
        ]);

        $reservation = Reservation::with('doctorConsultationReservation.doctor')->findOrFail($reservationId);

        try {
            // Buat Zoom meeting menggunakan akun Zoom yang terhubung dengan aplikasi
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->generateToken(),
                'Content-Type' => 'application/json',
            ])->post("https://api.zoom.us/v2/users/me/meetings", [
                'topic' => $validated['title'],
                'type' => 2,
                'start_time' => Carbon::parse($validated['start_date_time'])->toIso8601String(),
                'duration' => $validated['duration_in_minute'],
                'password' => $this->generateMeetingPassword(), // Menggunakan password yang dihasilkan
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => false, // Peserta tidak bisa masuk sebelum host
                    'waiting_room' => true, // Aktifkan waiting room
                    'approval_type' => 0,
                    'meeting_authentication' => false,
                ],
            ]);

            $zoomData = $response->json();

            if (isset($zoomData['code']) && isset($zoomData['message'])) {
                throw new \Exception("Zoom API error: {$zoomData['message']} (Code: {$zoomData['code']})");
            }

            return $zoomData;
        } catch (\Throwable $th) {
            throw new \Exception('Error creating Zoom meeting: ' . $th->getMessage());
        }
    }

    protected function generateMeetingPassword(): string
    {
        return Str::random(8); // Menghasilkan password acak sepanjang 8 karakter
    }
    // Fungsi untuk generate Zoom OAuth Token
    protected function generateToken(): string
    {
        try {
            $base64String = base64_encode(env('ZOOM_CLIENT_KEY') . ':' . env('ZOOM_CLIENT_SECRET'));
            $accountId = env('ZOOM_ACCOUNT_ID');

            $responseToken = Http::withHeaders([
                "Content-Type" => "application/x-www-form-urlencoded",
                "Authorization" => "Basic {$base64String}"
            ])->post("https://zoom.us/oauth/token?grant_type=account_credentials&account_id={$accountId}");

            return $responseToken->json()['access_token'];
        } catch (\Throwable $th) {
            throw new \Exception('Error generating Zoom token: ' . $th->getMessage());
        }
    }

}
