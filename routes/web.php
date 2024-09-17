<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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


// MODUL DASHBOARD

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-page');

// END MODUL


// MODUL RESERVATION

// mcu
Route::get('/reservation-mcu', [ReservationController::class, 'indexMcu'])->name('reservation.mcu.index');
Route::get('/reservation-mcu/create', [ReservationController::class, 'createMcu'])->name('reservation.mcu.create');
Route::post('/reservation-mcu', [ReservationController::class, 'storeMcu'])->name('reservation.mcu.store');
Route::get('/reservation-mcu/{service}/edit', [ReservationController::class, 'editMcu'])->name('reservation.mcu.edit');
Route::put('/reservation-mcu/{service}', [ReservationController::class, 'updateMcu'])->name('reservation.mcu.update');

// end

// poly
Route::get('/reservation-polyclinic', [ReservationController::class, 'indexPoly'])->name('reservation.poly.index');
// end

// service
Route::get('/reservation-homeservice', [ReservationController::class, 'indexHomeService'])->name('reservation.homeservice.index');
// end

// END MODUL

// MODUL INFORMATION

// article
Route::get('/information-article', [InformationController::class, 'indexArticle'])->name('information.article.index');
// end

// promote
Route::get('/information-promote', [InformationController::class, 'indexPromote'])->name('information.article.index');
// end

// END MODUL

// MODUL DOCTOR

Route::get('/doctor-data', [DoctorController::class, 'indexDataDoctor'])->name('doctor.data.index');

// END MODUL


// MODUL MASTER DATA

// user
Route::get('/master-user', [UserController::class, 'index'])->name('user.data.index');
Route::get('/master-user/create', [UserController::class, 'create'])->name('user.data.create'); // Form tambah user baru
Route::post('/master-user', [UserController::class, 'store'])->name('user.data.store'); // Menyimpan user baru
Route::get('/master-user/{id}/edit', [UserController::class, 'edit'])->name('user.data.edit'); // Form edit user
Route::put('/master-user/{id}', [UserController::class, 'update'])->name('user.data.update'); // Update data user
Route::delete('/master-user/{id}', [UserController::class, 'destroy'])->name('user.data.destroy'); // Hapus user
// end

// role routes
Route::get('/master-role', [RoleController::class, 'index'])->name('role.data.index');
Route::get('/master-role/create', [RoleController::class, 'create'])->name('role.data.create');
Route::post('/master-role/store', [RoleController::class, 'store'])->name('role.data.store');
Route::get('/master-role/edit/{id}', [RoleController::class, 'edit'])->name('role.data.edit');
Route::put('/master-role/update/{id}', [RoleController::class, 'update'])->name('role.data.update');
Route::delete('/master-role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.data.destroy');
// end

// informationcmh
Route::get(
    '/master-info-cmh',
    [MasterController::class, 'indexInformation']
)->name('information.data.index');
Route::get('/master-info-cmh/create', [MasterController::class, 'createInformation'])->name('information.data.create');
Route::post('/master-info-cmh', [MasterController::class, 'storeInformation'])->name('information.data.store');

// Route untuk menampilkan form edit
Route::get('/master-info-cmh/{id}/edit', [MasterController::class, 'editInformation'])->name('information.data.edit');

// Route untuk menangani pembaruan data
Route::put('/master-info-cmh/{id}', [MasterController::class, 'updateInformation'])->name('information.data.update');

// Route untuk menghapus data
Route::delete('/master-info-cmh/{id}', [MasterController::class, 'destroyInformation'])->name('information.data.destroy');


// end

// galerycmh
Route::get(
    '/master-gallery-cmh',
    [MasterController::class, 'indexGallery']
)->name('gallery.data.index');

Route::get('/master-gallery-cmh/create', [MasterController::class, 'createGallery'])->name('gallery.data.create');
Route::post('/master-gallery-cmh/store', [MasterController::class, 'storeGallery'])->name('gallery.data.store');
Route::get('/master-gallery-cmh/edit/{id}', [MasterController::class, 'editGallery'])->name('gallery.data.edit');
Route::put('/master-gallery-cmh/update/{id}', [MasterController::class, 'updateGallery'])->name('gallery.data.update');
Route::delete('/master-gallery-cmh/destroy/{id}', [MasterController::class, 'destroyGallery'])->name('gallery.data.destroy');
// end

// END MODUL


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
