<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
Route::get('/medical-check-up', [LandingPageController::class, 'medicalCheckUp'])->name('medical-check-up');
Route::get('/home-service', [LandingPageController::class, 'homeService'])->name('home-service');
Route::get('/polyclinic', [LandingPageController::class, 'polyclinic'])->name('polyclinic');
Route::get('/promotion', [LandingPageController::class, 'promotion'])->name('promotion');
Route::get('/information', [LandingPageController::class, 'information'])->name('information');

// DOKTER
// Route untuk menampilkan daftar dokter
Route::get('/doctor', [LandingPageController::class, 'doctor'])->name('doctor.landing');
// Route untuk menampilkan profil dokter berdasarkan ID
Route::get('/doctor/profile/{id}', [LandingPageController::class, 'showDoctor'])->name('doctor.show.landing');
Route::get('/search-doctor', [DoctorController::class, 'searchDoctor'])->name('doctor.search');

// MCU
// Route untuk menampilkan daftar layanan MCU di landing page
Route::get('/medical-check-up', [LandingPageController::class, 'medicalCheckUp'])->name('mcu.landing');
// Route untuk menampilkan detail layanan MCU berdasarkan ID
Route::get('/medical-check-up/detail/{id}', [LandingPageController::class, 'showMcuDetail'])->name('mcu.detail.landing');
Route::get('/mcu/{id}', [LandingPageController::class, 'showMcuDetail'])->name('mcu.detail');

// ONLINE CONSULTATION
Route::get('/online-consultation', [LandingPageController::class,'consultation'])->name('onlineconsultation.landing');

Route::get('/consultation-form', function () {
    return view('consultation-form');
});

Route::get('/consultation-confirmation', function () {
    return view('consultation-confirmation');
});

Route::get('/consultation-detail', function () {
    return view('consultation-detail');
});

Route::get('/consultation-invoice', function () {
    return view('consultation-invoice');
});

// MODUL LANDING PAGE

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/medical-check-up', [LandingPageController::class, 'medicalCheckUp'])->name('medical-check-up');
Route::get('/home-service', [LandingPageController::class, 'homeService'])->name('home-service');
Route::get('/polyclinic', [LandingPageController::class, 'polyclinic'])->name('polyclinic');
Route::get('/promotion', [LandingPageController::class, 'promotion'])->name('promotion');
Route::get('/information', [LandingPageController::class, 'information'])->name('information');

// DOKTER
// Route untuk menampilkan daftar dokter
Route::get('/doctor', [LandingPageController::class, 'doctor'])->name('doctor.landing');

// Route untuk menampilkan profil dokter berdasarkan ID
Route::get('/doctor/profile/{id}', [LandingPageController::class, 'showDoctor'])->name('doctor.show.landing');
Route::get('/search-doctor', [DoctorController::class, 'searchDoctor'])->name('doctor.search');

// MCU
// Route untuk menampilkan daftar layanan MCU di landing page
Route::get('/medical-check-up', [LandingPageController::class, 'medicalCheckUp'])->name('mcu.landing');

// Route untuk menampilkan detail layanan MCU berdasarkan ID
Route::get('/medical-check-up/detail/{id}', [LandingPageController::class, 'showMcuDetail'])->name('mcu.detail.landing');
Route::get('/mcu/{id}', [LandingPageController::class, 'showMcuDetail'])->name('mcu.detail');



// END MODUL

// MODUL ACCOUNT



// END MODUL


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


// MODUL AUTH

Route::group(['middleware' => ['guest']], function () {
    // Route untuk menampilkan halaman registrasi
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

    // Route untuk menangani proses registrasi
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Route untuk menampilkan halaman login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk menampilkan halaman permintaan reset password
Route::get('/password/reset', [AuthController::class, 'showResetPasswordRequestForm'])->name('password.reset.request');

// Route untuk menangani proses permintaan reset password
Route::post('/password/reset', [AuthController::class, 'resetPasswordRequest'])->name('password.reset.process');

// Route untuk menampilkan form ganti password berdasarkan token
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset.token');

// Route untuk memperbarui password user
Route::post('/password/reset/{token}', [AuthController::class, 'updatePassword'])->name('password.update');

// Route untuk akun pasien, hanya bisa diakses oleh user dengan role pasien
Route::middleware(['auth', 'role:Pasien'])->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account-index');
});

// END MODUL AUTH

// MODUL DASHBOARD

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-page');

// END MODUL


// MODUL RESERVATION DATA
// mcu
Route::get('/reservation-mcu', [ReservationController::class, 'indexMcu'])->name('reservation.mcu.index');
Route::get('/reservation-mcu/create', [ReservationController::class, 'createMcu'])->name('reservation.mcu.create');
Route::post('/reservation-mcu', [ReservationController::class, 'storeMcu'])->name('reservation.mcu.store');
Route::get('/reservation-mcu/{service}/edit', [ReservationController::class, 'editMcu'])->name('reservation.mcu.edit');
Route::put('/reservation-mcu/{service}', [ReservationController::class, 'updateMcu'])->name('reservation.mcu.update');
Route::patch('/reservation-mcu/publish/{service}', [ReservationController::class, 'publishMcu'])->name('reservation.mcu.publish');
Route::delete('/reservation-mcu/{service}', [ReservationController::class, 'destroyMcu'])->name('reservation.mcu.destroy');
Route::patch('reservation/mcu/restore/{id}', [ReservationController::class, 'restoreMcu'])->name('reservation.mcu.restore');
Route::get('/reservation-mcu/{id}', [ReservationController::class, 'detailMcu'])->name('reservation.mcu.detail');
Route::patch('/reservation-mcu/unpublish/{service}', [ReservationController::class, 'unpublishMcu'])->name('reservation.mcu.unpublish');
Route::get('/mcu', [ReservationController::class, 'indexLandingMcu'])->name('landing.mcu.index');

Route::get('/mcu', [ReservationController::class, 'indexLandingMcu'])->name('landing.mcu.index');
// end

// poly
Route::get('/reservation-polyclinic', [ReservationController::class, 'indexPoly'])->name('reservation.poly.index');
// end

// home service
Route::get('/reservation-homeservice', [ReservationController::class, 'indexHomeService'])->name('reservation.homeservice.index');
// end

// online consultation
Route::get('/reservation-online-consultation', [ReservationController::class, 'indexConsultation'])->name('reservation.onlineconsultation.index');
Route::get('/reservation-online-consultation/detail', [ReservationController::class, 'detailConsultation'])->name('reservation.onlineconsultation.detail');
Route::get('/reservation-online-consultation/invoice', [ReservationController::class, 'invoiceConsultation'])->name('reservation.onlineconsultation.invoice');

// end
// END MODUL

// MODUL RESERVATION LANDING PAGE


//RESERVASI ONLINE
Route::get('/online-consultation', [
    ReservationController::class,
    'indexLandingConsultation'
])->name('reservation.onlineconsultation.landing');

Route::get('/consultation-form', function () {
    return view('consultation-form');
});

Route::get('/consultation-confirmation', function () {
    return view('consultation-confirmation');
});

Route::get('/consultation-detail', function () {
    return view('consultation-detail');
});

Route::get('/consultation-invoice', function () {
    return view('consultation-invoice');
});

// END MODUL



// MODUL INFORMATION

// article
Route::get('/information-article', [InformationController::class, 'indexArticle'])->name('information.article.index');
// end

// promote
Route::get('/information-promote', [InformationController::class, 'indexPromote'])->name('information.promotion.index');
// end

// END MODUL

// MODUL DOCTOR

Route::get('/doctor-data', [DoctorController::class, 'indexDataDoctor'])->name('doctor.data.index');
Route::get('/doctor-data/create', [DoctorController::class, 'create'])->name('doctor.data.create');
Route::post('/doctor-data-store', [DoctorController::class, 'store'])->name('doctor.data.store');
Route::get('/doctor-data/{id}/edit', [DoctorController::class, 'edit'])->name('doctor.data.edit');
Route::put('/doctor-data/{id}', [DoctorController::class, 'update'])->name('doctor.data.update');
Route::delete('/doctor-data/{id}', [DoctorController::class, 'destroy'])->name('doctor.data.destroy');
Route::get('/doctor-data/{id}', [DoctorController::class, 'show'])->name('doctor.data.show'); // Rute untuk melihat detail dokter

Route::get('/doctors-data/search', [DoctorController::class, 'searchDoctor'])->name('doctor.data.search');



// sub modul poly doctor

// Route untuk menampilkan daftar poliklinik dokter
Route::get('/doctor-polyclinic', [DoctorController::class, 'indexPolyclinicDoctor'])->name('doctor.polyclinic.index');

// Route untuk menampilkan form create poliklinik dokter
Route::get('/doctor-polyclinic/create', [DoctorController::class, 'createPolyclinicDoctor'])->name('doctor.polyclinic.create');

// Route untuk menyimpan data poliklinik dokter
Route::post('/doctor-polyclinic/store', [DoctorController::class, 'storePolyclinicDoctor'])->name('doctor.polyclinic.store');

// Route untuk menampilkan form edit poliklinik dokter
Route::get('/doctor-polyclinic/edit/{id}', [DoctorController::class, 'editPolyclinicDoctor'])->name('doctor.polyclinic.edit');

// Route untuk update poliklinik dokter
Route::post('/doctor-polyclinic/update/{id}', [DoctorController::class, 'updatePolyclinicDoctor'])->name('doctor.polyclinic.update');

// Route untuk menghapus poliklinik dokter
Route::delete('/doctor-polyclinic/delete/{id}', [DoctorController::class, 'deletePolyclinicDoctor'])->name('doctor.polyclinic.delete');

// end sub modul poly doctor



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


Route::get('/coming-soon', function () {
    return view('landing-page.contents.coming-soon');
});