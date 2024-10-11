<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorConsultationReservation;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\PaymentRecord;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use Illuminate\Support\Str; // Tambahkan ini
use Illuminate\Http\Request;

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

        return view('landing-page.contents.online-consultation.invoice', compact('invoice', 'title'));
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
}
