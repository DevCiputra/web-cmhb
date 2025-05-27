<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormater;
use App\Http\Controllers\Controller;
use App\Mail\ReservationMail;
use App\Models\Reservation;
use App\Models\ReservationEmail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function storeReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:reservations',
            'patient_id' => 'required|exists:patients,id',
            'reservation_date' => 'nullable',
            'reservation_time' => 'nullable',
            'doctor_id' => 'nullable|exists:doctors,id',
            'complaint' => 'nullable',
            'solution' => 'nullable',
            'reservation_status_id' => 'nullable|exists:reservation_statuses',
            'service_category_id' => 'nullable|exists:service_categories',
            'status_pembayaran' => 'nullable'

        ]);

        if($validator->fails()) {
            return ResponseFormater::error(
                null,
                $validator->errors(),
                500
            );
        }

        try {


            $reservation = Reservation::create([
            'code' => $request->code,
            'patient_id' => $request->patient_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'doctor_id' => $request->doctor_id,
            'complaint' => $request->complaint,
            'solution' => $request->solution,
            'reservation_status_id' => $request->reservation_status_id,
            'service_category_id' => $request->service_category_id,
            'status_pembayaran' => $request->status_pembayaran
        ]);

        // Load relationships untuk email
        $reservation->load(['patient', 'dokters']);

        // Send email to doctor if doctor_id is provided
        if ($request->doctor_id && $reservation->dokters && $reservation->dokters->email) {
            try {
                Mail::to($reservation->dokters->email)->send(new ReservationMail($reservation));

                // Optional: Save email record
                ReservationEmail::create([
                    'status_reservation' => 'Menunggu Konfirmasi Dokter',
                    'email' => $reservation->dokters->email
                ]);

            } catch (\Exception $emailError) {
                // Log email error but don't fail the reservation
                return ResponseFormater::error(
                    'Failed to send email to doctor:',
                    $emailError->getMessage()
                );
            }
        }

        }catch(Exception $error) {
            return ResponseFormater::error(
                $error->getMessage(),
                'gagal membuat reservasi'
            );
        }
    }

    public function updateReservation(Request $request, $id)
    {

    }
}
