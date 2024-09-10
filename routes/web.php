<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// MODUL LANDING PAGE

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/doctor', [LandingPageController::class, 'doctor'])->name('doctor');
Route::get('/medical-check-up', [LandingPageController::class, 'medicalCheckUp'])->name('medical-check-up');
Route::get('/home-service', [LandingPageController::class, 'homeService'])->name('home-service');
Route::get('/polyclinic', [LandingPageController::class, 'polyclinic'])->name('polyclinic');
Route::get('/promotion', [LandingPageController::class, 'promotion'])->name('promotion');
Route::get('/information', [LandingPageController::class, 'information'])->name('information');


// END MODUL

// MODUL ACCOUNT

Route::get(
    '/account',
    [AccountController::class, 'index']
)->name('account-index');

// END MODUL

Route::get('/profile', function () {
    return view('dokter_profile');
});



Route::get('/mcu_detail', function () {
    return view('mcu_detail');
});

Route::get('/poliklinik', function () {
    return view('poliklinik');
});



Route::get('/promosi', function () {
    return view('promosi');
});

Route::get('/promosi_detail', function () {
    return view('promosi_detail');
});

Route::get('/informasi', function () {
    return view('informasi');
});

Route::get('/informasi_detail', function () {
    return view('informasi_detail');
});

Route::get('/user_profile', function () {
    return view('user_profile');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});


// DASHBOARD
Route::get('/dashboard_mcu', function () {
    return view('manajemen_data.reservasi.kontens.data_mcu');
});

Route::get('/tambah_mcu', function () {
    return view('manajemen_data.reservasi.forms.form_tambahmcu');
});

Route::get('/edit_mcu', function () {
    return view('manajemen_data.reservasi.forms.form_editmcu');
});

Route::get('/view_mcu', function () {
    return view('manajemen_data.reservasi.kontens.data_viewmcu');
});

Route::get('/dashboard_poli', function () {
    return view('manajemen_data.reservasi.kontens.data_poliklinik');
});

Route::get('/tambah_poli', function () {
    return view('manajemen_data.reservasi.forms.form_tambahpoliklinik');
});

Route::get('/edit_poli', function () {
    return view('manajemen_data.reservasi.forms.form_editpoliklinik');
});

Route::get('/dashboard_homeservice', function () {
    return view('manajemen_data.reservasi.kontens.data_homeservice');
});

Route::get('/tambah_homeservice', function () {
    return view('manajemen_data.reservasi.forms.form_tambahhomeservice');
});

Route::get('/edit_homeservice', function () {
    return view('manajemen_data.reservasi.forms.form_edithomeservice');
});

Route::get('/dashboard_artikel', function () {
    return view('manajemen_data.informasi.kontens.data_artikel');
});

Route::get('/tambah_artikel', function () {
    return view('manajemen_data.informasi.forms.form_tambahartikel');
});

Route::get('/edit_artikel', function () {
    return view('manajemen_data.informasi.forms.form_editartikel');
});

Route::get('/view_artikel', function () {
    return view('manajemen_data.informasi.kontens.data_viewartikel');
});

Route::get('/dashboard_promosi', function () {
    return view('manajemen_data.informasi.kontens.data_promosi');
});

Route::get('/tambah_promosi', function () {
    return view('manajemen_data.informasi.forms.form_tambahpromosi');
});

Route::get('/edit_promosi', function () {
    return view('manajemen_data.informasi.forms.form_editpromosi');
});

Route::get('/view_promosi', function () {
    return view('manajemen_data.informasi.kontens.data_viewpromosi');
});

Route::get('/dashboard_dokter', function () {
    return view('manajemen_data.dokter.kontens.data_dokter');
});

Route::get('/tambah_dokter', function () {
    return view('manajemen_data.dokter.forms.form_tambahdokter');
});

Route::get('/edit_dokter', function () {
    return view('manajemen_data.dokter.forms.form_editdokter');
});

Route::get('/view_dokter', function () {
    return view('manajemen_data.dokter.kontens.data_viewdokter');
});

// DASHBOARD MASTER DATA
Route::get('/dashboard_user', function () {
    return view('manajemen_data.master.kontens.masterdata_user');
});

Route::get('/tambah_user', function () {
    return view('manajemen_data.master.forms.form_tambahuser');
});

Route::get('/edit_user', function () {
    return view('manajemen_data.master.forms.form_edituser');
});


Route::get('/dashboard_role', function () {
    return view('manajemen_data.master.kontens.masterdata_role');
});

Route::get('/tambah_role', function () {
    return view('manajemen_data.master.forms.form_tambahrole');
});

Route::get('/edit_role', function () {
    return view('manajemen_data.master.forms.form_editrole');
});

Route::get('/dashboard_infors', function () {
    return view('manajemen_data.master.kontens.masterdata_infors');
});

Route::get('/tambah_infors', function () {
    return view('manajemen_data.master.forms.form_tambahinfors');
});

Route::get('/edit_infors', function () {
    return view('manajemen_data.master.forms.form_editinfors');
});

Route::get('/dashboard_galerirs', function () {
    return view('manajemen_data.master.kontens.masterdata_galerirs');
});

Route::get('/tambah_galerirs', function () {
    return view('manajemen_data.master.forms.form_tambahgalerirs');
});

Route::get('/edit_galerirs', function () {
    return view('manajemen_data.master.forms.form_editgalerirs');
});
