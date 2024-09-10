<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $title = 'Ciputra Mitra Hospital';
        return view('landing-page.contents.landing-page', compact('title'));
    }

    public function doctor()
    {

        $title = 'Cari Dokter';
        return view('landing-page.contents.doctor', compact('title'));
    }

    public function medicalCheckUp()
    {

        $title = 'Medical Check Up';
        return view('landing-page.contents.medical-check-up', compact('title'));
    }

    public function homeService()
    {

        $title = 'Home Service';
        return view('landing-page.contents.home-service', compact('title'));
    }

    public function polyclinic()
    {
        $title = 'Poliklinik';
        return view('landing-page.contents.polyclinic', compact('title'));
    }

    public function promotion()
    {
        $title = 'Promosi';
        return view('landing-page.contents.promotion', compact('title'));
    }

    public function information()
    {
        $title = 'Informasi';
        return view('landing-page.contents.information', compact('title'));
    }
}
