<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorConsultationReservation;
use App\Models\DoctorPolyclinic;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah user per role
        $userCountByRole = User::select('role', DB::raw('count(*) as count'))
        ->groupBy('role')
        ->pluck('count', 'role');

        // Hitung jumlah transaksi dengan reservation_status_id = 3
        $completedTransactionsCount = Reservation::where('reservation_status_id', 3)->count();

        // Hitung total pendapatan
        $totalRevenue = DoctorConsultationReservation::join('doctors', 'doctor_consultation_reservations.doctor_id', '=', 'doctors.id')
        ->sum('doctors.consultation_fee');

        // Hitung jumlah dokter
        $doctorCount = Doctor::count();

        // Hitung jumlah poliklinik
        $polyclinicCount = DoctorPolyclinic::count();

        return view('management-data.dashboard.index', compact('userCountByRole', 'completedTransactionsCount', 'totalRevenue', 'doctorCount', 'polyclinicCount'));
    }
}
