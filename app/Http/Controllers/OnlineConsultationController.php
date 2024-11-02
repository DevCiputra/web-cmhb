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
use Illuminate\Support\Facades\Storage;

class OnlineConsultationController extends Controller
{

    protected function getActiveZoomAccount()
    {
        return ZoomAccount::where('active', true)->inRandomOrder()->first();
    }

    private function generateInvoiceNumber($patientId, $lastInvoiceNumber = 0)
    {
        // Ambil data pasien berdasarkan ID
        $patient = Patient::findOrFail($patientId);

        // 1. Inisial organisasi (CMH)
        $organizationCode = 'CMH';

        // 2. Tanggal (format internasional: YYYYMMDD)
        $date = Carbon::now()->format('Ymd');

        // 3. Nomor urut invoice (contoh: 00001)
        $nextInvoiceNumber = str_pad($lastInvoiceNumber + 1, 5, '0', STR_PAD_LEFT);

        // 4. Inisial pasien (contoh: John Doe → JD)
        $patientInitials = collect(explode(' ', $patient->name))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->implode('');

        // 5. UUID singkat (8 karakter pertama)
        $shortUuid = substr(Str::uuid()->toString(), 0, 8);

        // Gabungkan elemen menjadi nomor invoice
        $invoiceNumber = "{$organizationCode}/{$date}/{$nextInvoiceNumber}/{$patientInitials}-{$shortUuid}";

        return $invoiceNumber;
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

        // Buat reservation
        $reservation = Reservation::create([
            'patient_id' => $patient->id,
            'reservation_status_id' => null,
            'service_category_id' => 4, // Asumsikan konsultasi
            'status_pembayaran' => null,
            'code' => $code,
        ]);

        // Buat doctor consultation reservation
        DoctorConsultationReservation::create([
            'reservation_id' => $reservation->id,
            'doctor_id' => $validated['doctor_id'],
            'preferred_consultation_date' => $validated['preferred_consultation_date'],
            'zoom_account_id' => null,
        ]);

        // Buat invoice otomatis dengan total_amount dari doctor
        Invoice::create([
            'reservation_id' => $reservation->id,
            'total_amount' => $doctor->consultation_fee, // Ambil dari consultation_fee
            'payment_status' => 'Belum Dibayar', // Status awal
        ]);

        return redirect()->route('account-index', ['tab' => 'riwayat'])
        ->with('success', 'Reservasi berhasil dibuat!')
        ->withInput(); // Menambahkan withInput agar parameter tab tetap ada setelah redirect

    }

    private function generateReservationCode($doctorName)
    {
        $initials = collect(explode(' ', $doctorName))->map(function ($part) {
            return preg_match('/^[A-Za-z]/', $part) ? strtoupper(substr($part, 0, 1)) : '';
        })->implode('');

        $today = date('dmY');

        // Hitung semua reservasi pada hari itu termasuk yang di soft-delete
        $reservationCount = Reservation::withTrashed()
            ->whereDate('created_at', today())
            ->count();

        $reservationNumber = str_pad($reservationCount + 1, 2, '0', STR_PAD_LEFT);

        return "{$today}{$initials}{$reservationNumber}";
    }

    public function contactPatient($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Set status reservasi menjadi "Konfirmasi Jadwal"
        $reservation->update([
            'reservation_status_id' => ReservationStatus::where('name', 'Konfirmasi Jadwal')->first()->id,
        ]);

        return redirect()->back()->with('success', 'Pasien telah dihubungi dan status diperbarui.');
    }

    public function agreeSchedule($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Set status reservasi menjadi "Jadwal Dikonfirmasi"
        $reservation->update([
            'reservation_status_id' => ReservationStatus::where('name', 'Jadwal Dikonfirmasi')->first()->id,
        ]);

        return redirect()->back()->with('success', 'Jadwal konsultasi telah disepakati.');
    }


    public function showConfirmation($id)
    {
        $title = 'Konfirmasi Reservasi Konsultasi';
        $reservation = Reservation::with('doctorConsultationReservation', 'patient')->findOrFail($id);

        return view('landing-page.contents.online-consultation.confirmation', compact('reservation', 'title'));
    }

    public function showConsultationDetail($id)
    {
        Carbon::setLocale('id'); // Pastikan bahasa Indonesia aktif
        $title = 'Detail Reservasi Konsultasi';
        $reservation = Reservation::with('doctorConsultationReservation', 'patient', 'status')
        ->findOrFail($id);

        // Ambil alasan pembatalan jika ada
        $cancellationLog = ReservationLog::where('reservation_id', $id)->latest()->first();
        $cancellationReason = $cancellationLog ? $cancellationLog->reason : null;

        return view('landing-page.contents.online-consultation.detail', compact('reservation', 'title', 'cancellationReason'));
    }

    public function showInvoice($id)
    {
        $title = 'Invoice Reservasi Konsultasi';
        $invoice = Reservation::with([
            'doctorConsultationReservation.doctor','patient.user',
            'paymentRecords',
            'invoice', // Menambahkan relasi invoice
        ])->where('id', $id)->firstOrFail();

        // Set locale ke Bahasa Indonesia
        \Carbon\Carbon::setLocale('id');

        // Pastikan tanggal konfirmasi pembayaran dan lainnya adalah objek Carbon
        foreach ($invoice->paymentRecords as $paymentRecord) {
            $paymentRecord->payment_confirmation_date = \Carbon\Carbon::parse($paymentRecord->payment_confirmation_date);
        }

        // Konversi created_at dan updated_at ke Carbon jika perlu
        $invoice->created_at = \Carbon\Carbon::parse($invoice->created_at);
        $invoice->updated_at = \Carbon\Carbon::parse($invoice->updated_at);

        return view('landing-page.contents.online-consultation.invoice', compact('invoice', 'title'));
    }

    public function confirmPayment(Request $request, $id)
    {
        // Ambil reservasi dengan relasi invoice
        $reservation = Reservation::with('invoice', 'patient')->findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'payment_proof' => 'required|image|max:2048',
            'payment_method' => 'required|string',
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diunggah.',
            'payment_proof.image' => 'File yang diunggah harus berupa gambar.',
            'payment_proof.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'payment_method.required' => 'Metode pembayaran harus dipilih.',
        ]);

        // Simpan bukti pembayaran
        $fileName = time() . '.' . $request->payment_proof->extension();
        $filePath = $request->file('payment_proof')->storeAs('payment_proofs', $fileName, 'public');

        // Simpan record pembayaran
        PaymentRecord::create([
            'reservation_id' => $reservation->id,
            'payment_method' => $validated['payment_method'],
            'payment_proof' => $filePath,
            'payment_confirmation_date' => now(),
        ]);

        // Update status pembayaran di reservation
        $reservation->update(['status_pembayaran' => 'Menunggu Konfirmasi',
        ]);

        // Ambil nomor urut invoice terakhir dari database (asumsi ada field 'invoice_number')
        $lastInvoiceNumber = (int) Invoice::where('reservation_id', $reservation->id)->max('invoice_number') ?: 0;

        // Update invoice dengan nomor invoice baru
        $reservation->invoice->update(['invoice_number' => $this->generateInvoiceNumber($reservation->patient_id, $lastInvoiceNumber),
            'payment_status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('account-index', ['tab' => 'riwayat'])
        ->with('success', 'Pembayaran berhasil!')
        ->withInput(); // Menambahkan withInput agar parameter tab tetap ada setelah redirect
    }

    public function confirmPaymentStatus($reservationId)
    {
        $reservation = Reservation::with('invoice')->findOrFail($reservationId);

        // Perbarui status pembayaran dan status invoice
        $reservation->update(['status_pembayaran' => 'Lunas']);
        $reservation->invoice->update(['payment_status' => 'Lunas']);

        return redirect()->back()->with('success', 'Pembayaran telah dikonfirmasi dan status diubah menjadi Lunas.');
    }

    public function approveReservation(Request $request, $id)
    {
        $validated = $request->validate([
            'agreed_consultation_date' => 'required|date',
            'agreed_consultation_time' => 'required|date_format:H:i',
        ]);

        // Ambil reservasi dengan relasi terkait
        $reservation = Reservation::with('doctorConsultationReservation.doctor')->findOrFail($id);

        // Perbarui tanggal dan waktu konsultasi
        $reservation->doctorConsultationReservation->update([
            'agreed_consultation_date' => $validated['agreed_consultation_date'],
            'agreed_consultation_time' => $validated['agreed_consultation_time'],
        ]);

        try {
            // Pilih akun Zoom secara bergantian
            $zoomAccount = $this->getNextZoomAccount();

            // Buat meeting Zoom
            $zoomMeeting = $this->createMeeting(new Request([
                'title' => "Konsultasi dengan Dr. {$reservation->doctorConsultationReservation->doctor->name}",
                'start_date_time' => "{$validated['agreed_consultation_date']} {$validated['agreed_consultation_time']}",
                'duration_in_minute' => 60,
                'alternative_hosts' => $reservation->doctorConsultationReservation->doctor->email,
            ]), $reservation->id);

            // Simpan link dan info Zoom di database
            $reservation->doctorConsultationReservation->update([
                'zoom_link' => $zoomMeeting['join_url'],
                'zoom_host_link' => $zoomMeeting['start_url'],
                'zoom_password' => $zoomMeeting['password'],
            ]);

            // Perbarui status reservasi dan status pembayaran
            $reservation->update(['reservation_status_id' => ReservationStatus::where('name', 'Berhasil')->first()->id,
            ]);

            // Cek jika reservasi sebelumnya dibatalkan, buat log perubahan status
            if ($reservation->wasChanged('reservation_status_id')) {
                ReservationLog::create([
                    'reservation_id' => $reservation->id,
                    'user_id' => auth()->id(),
                    'patient_name' => $reservation->patient->name,
                    'user_name' => auth()->user()->username,
                    'reason' => 'Reservasi disetujui ulang setelah dibatalkan',
                ]);
            }

            return redirect()->back()->with('success', 'Reservasi Berhasil Diterima dan Zoom Meeting Dijadwalkan');
        } catch (\Throwable $th) {
            Log::error('Error creating Zoom meeting:', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Gagal Membuat Penjadwalan');
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

    public function cancelReservation(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'cancellation_reason' => 'required|string|max:255',
            'authorization_password' => 'required',
        ]);

        // Validasi password otorisasi
        if (!Hash::check($request->authorization_password, auth()->user()->password)) {
            return back()->withErrors(['authorization_password' => 'Password otorisasi salah']);
        }
        // dd($request);
        // Ambil reservasi dengan relasi patient
        $reservation = Reservation::with('patient')->findOrFail($id);

        // Ubah status reservasi menjadi 'Batal'
        $reservation->update([
            'reservation_status_id' => ReservationStatus::where('name', 'Batal')->value('id'),
            'status_pembayaran' => "Dikembalikan"
        ]);

        // dd($reservation->patient->name);
        // Simpan log pembatalan dengan data patient yang benar
        ReservationLog::create([
            'reservation_id' => $reservation->id,
            'user_id' => auth()->id(),
            'patient_name' => $reservation->patient->name,  // Pastikan relasi patient tersedia
            'user_name' => auth()->user()->username,
            'reason' => $request->cancellation_reason,
        ]);

        // Update data di doctor_consultation_reservations
        if ($reservation->doctorConsultationReservation) {
            $reservation->doctorConsultationReservation->update([
                'agreed_consultation_date' => null,
                'agreed_consultation_time' => null,
                'zoom_host_link' => null,
                'zoom_link' => null,
                'zoom_password' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Reservasi Berhasil Dibatalkan');
    }


    public function deleteReservation($id)
    {
        // Ambil reservasi beserta relasi yang dibutuhkan
        $reservation = Reservation::with('doctorConsultationReservation', 'invoice', 'paymentRecords')->findOrFail($id);

        try {
            // Hapus payment records terkait (jika ada)
            if ($reservation->paymentRecords) {
                foreach ($reservation->paymentRecords as $paymentRecord) {
                    // Hapus file bukti pembayaran dari storage
                    if (Storage::disk('public')->exists($paymentRecord->payment_proof)) {
                        Storage::disk('public')->delete($paymentRecord->payment_proof);
                    }
                    $paymentRecord->delete();
                }
            }

            // Hapus invoice terkait (jika ada)
            if ($reservation->invoice) {
                $reservation->invoice->delete();
            }

            // Hapus doctor consultation reservation terkait (jika ada)
            if ($reservation->doctorConsultationReservation) {
                $reservation->doctorConsultationReservation->delete();
            }

            $reservation->delete();

            return redirect()->route('reservation.onlineconsultation.index')->with('success', 'Reservasi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus reservasi:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menghapus reservasi. Silakan coba lagi.');
        }
    }

}
