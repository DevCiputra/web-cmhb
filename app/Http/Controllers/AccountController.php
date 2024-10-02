<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        // Mengambil data pengguna yang sedang login
        $user = Auth::user();

        // Mengambil data pasien terkait dengan pengguna
        $patient = Patient::where('user_id', $user->id)->first();

        $title = 'Akun Saya';

        // Mengirimkan data pengguna dan pasien ke view
        return view('account.contents.index', compact('title', 'user', 'patient'));
    }
}
