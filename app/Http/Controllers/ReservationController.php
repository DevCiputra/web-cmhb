<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function indexMcu()
    {
        return view('management-data.reservation.medical-check-up.index');
    }
    public function indexPoly()
    {
        return view('management-data.reservation.polyclinic.index');
    }
    public function indexHomeService()
    {
        return view('management-data.reservation.home-service.index');
    }
}
