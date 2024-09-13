<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function indexDataDoctor()
    {
        return view('management-data.doctor.index');
    }
}
