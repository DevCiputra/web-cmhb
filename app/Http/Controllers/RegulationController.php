<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegulationController extends Controller
{
    public function termsAndConditions()
    {
        $title = "Terms and Conditions";
        return view('landing-page.contents.terms-and-conditions', compact('title'));
    }
}
