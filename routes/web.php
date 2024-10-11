<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OnlineConsultationController;
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
Route::prefix('/')->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
    Route::get('/medical-check-up', [LandingPageController::class, 'medicalCheckUp'])->name('medical-check-up');
    Route::get('/home-service', [LandingPageController::class, 'homeService'])->name('home-service');
    Route::get('/polyclinic', [LandingPageController::class, 'polyclinic'])->name('polyclinic');
    Route::get('/promotion', [LandingPageController::class, 'promotion'])->name('promotion');
    Route::get('/information', [LandingPageController::class, 'information'])->name('information');
    // ONLINE CONSULTATION
    Route::get('/consultation-online', [LandingPageController::class, 'consultation'])->name('onlineconsultation.landing');

    // COMING SOON PAGE
    Route::get('/coming', [LandingPageController::class, 'coming'])->name('coming-page');
});

// DOKTER
// Route untuk menampilkan daftar dokter
Route::get('/doctor', [LandingPageController::class, 'doctor'])->name('doctor.landing');
// Route untuk menampilkan profil dokter berdasarkan ID
Route::get('/doctor/profile/{id}', [LandingPageController::class, 'showDoctor'])->name('doctor.show.landing');
Route::get('/search-doctor', [DoctorController::class, 'searchDoctor'])->name('doctor.search');

// MCU

// Route untuk menampilkan detail layanan MCU berdasarkan ID
Route::get('/medical-check-up/detail/{id}', [LandingPageController::class, 'showMcuDetail'])->name('mcu.detail.landing');





// Rute untuk konsultasi yang hanya bisa diakses oleh user dengan role Pasien dan Admin
Route::group(['middleware' => ['checkrole:Pasien,Admin']], function () {
    // Rute untuk form konsultasi
    Route::get('/consultation-form/{doctor_id}', [OnlineConsultationController::class, 'showConsultationForm'])->name('consultation.form');

    // Rute untuk menyimpan reservasi
    Route::post('/consultation-form', [OnlineConsultationController::class, 'storeReservation'])->name('consultation.store');

    // Rute untuk halaman konfirmasi
    Route::get('/consultation-confirmation/{id}', [OnlineConsultationController::class, 'showConfirmation'])->name('consultation.confirmation');

    // Rute untuk halaman detail konsultasi
    Route::get('/consultation-detail/{id}', [OnlineConsultationController::class, 'showConsultationDetail'])->name('consultation.detail');

    // Rute untuk halaman invoice
    Route::get('/consultation-invoice/{id}', [OnlineConsultationController::class, 'showInvoice'])->name('consultation.invoice');

    // Rute untuk konfirmasi pembayaran
    Route::post('/consultation-payment/{id}', [OnlineConsultationController::class, 'confirmPayment'])->name('consultation.payment');
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

// MODUL AUTH
Route::group(['middleware' => ['guest']], function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/password/reset', [AuthController::class, 'showResetPasswordRequestForm'])->name('password.reset.request');
Route::post('/password/reset', [AuthController::class, 'resetPasswordRequest'])->name('password.reset.process');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset.token');
Route::post('/password/reset/{token}', [AuthController::class, 'updatePassword'])->name('password.update');

// MODUL PASIEN
Route::group(['middleware' => ['checkrole:Pasien,Admin']], function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account-index');
});

// MODUL DASHBOARD
Route::group(['middleware' => ['checkrole:Admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-page');
});

// MODUL RESERVATION DATA
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
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
});

// MODUL RESERVATION POLY
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/reservation-polyclinic', [ReservationController::class, 'indexPoly'])->name('reservation.poly.index');
});

// MODUL RESERVATION HOME SERVICE
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/reservation-homeservice', [ReservationController::class, 'indexHomeService'])->name('reservation.homeservice.index');
});

// MODUL RESERVATION ONLINE CONSULTATION
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/reservation-online-consultation', [ReservationController::class, 'indexConsultation'])->name('reservation.onlineconsultation.index');
    Route::get('/reservation-online-consultation/detail', [ReservationController::class, 'detailConsultation'])->name('reservation.onlineconsultation.detail');
    Route::get('/reservation-online-consultation/invoice', [ReservationController::class, 'invoiceConsultation'])->name('reservation.onlineconsultation.invoice');
});

// MODUL INFORMATION
Route::get('/information-article', [InformationController::class, 'indexArticle'])->name('information.article.index');
Route::get('/information-promote', [InformationController::class, 'indexPromote'])->name('information.promotion.index');

// MODUL DOCTOR
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/doctor-data', [DoctorController::class, 'indexDataDoctor'])->name('doctor.data.index');
    Route::get('/doctor-data/create', [DoctorController::class, 'create'])->name('doctor.data.create');
    Route::post('/doctor-data/store', [DoctorController::class, 'store'])->name('doctor.data.store');
    Route::get('/doctor-data/{id}/edit', [DoctorController::class, 'edit'])->name('doctor.data.edit');
    Route::put('/doctor-data/{id}', [DoctorController::class, 'update'])->name('doctor.data.update');
    Route::delete('/doctor-data/{id}', [DoctorController::class, 'destroy'])->name('doctor.data.destroy');
    Route::get('/doctor-data/{id}', [DoctorController::class, 'show'])->name('doctor.data.show'); // Rute untuk melihat detail dokter
    Route::get('/doctors-data/search', [DoctorController::class, 'searchDoctor'])->name('doctor.data.search');
});

// SUB MODUL POLY DOCTOR
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/doctor-polyclinic', [DoctorController::class, 'indexPolyclinicDoctor'])->name('doctor.polyclinic.index');
    Route::get('/doctor-polyclinic/create', [DoctorController::class, 'createPolyclinicDoctor'])->name('doctor.polyclinic.create');
    Route::post('/doctor-polyclinic/store', [DoctorController::class, 'storePolyclinicDoctor'])->name('doctor.polyclinic.store');
    Route::get('/doctor-polyclinic/edit/{id}', [DoctorController::class, 'editPolyclinicDoctor'])->name('doctor.polyclinic.edit');
    Route::post('/doctor-polyclinic/update/{id}', [DoctorController::class, 'updatePolyclinicDoctor'])->name('doctor.polyclinic.update');
    Route::delete('/doctor-polyclinic/delete/{id}', [DoctorController::class, 'deletePolyclinicDoctor'])->name('doctor.polyclinic.delete');
});

// MODUL MASTER DATA
// USER
Route::group(['middleware' => ['checkrole:Admin']], function () {
    Route::get('/master-user', [UserController::class, 'index'])->name('user.data.index');
    Route::get('/master-user/create', [UserController::class, 'create'])->name('user.data.create'); // Form tambah user baru
    Route::post('/master-user', [UserController::class, 'store'])->name('user.data.store'); // Menyimpan user baru
    Route::get('/master-user/{id}/edit', [UserController::class, 'edit'])->name('user.data.edit'); // Form edit user
    Route::put('/master-user/{id}', [UserController::class, 'update'])->name('user.data.update'); // Mengupdate user
    Route::delete('/master-user/{id}', [UserController::class, 'destroy'])->name('user.data.destroy'); // Menghapus user
});
// INFORMATION HOSPITAL DAN GALERRI
Route::group(
    ['middleware' => ['checkrole:HBD,Admin']],
    function () {
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
    }
);
// ROLE
Route::group(
    ['middleware' => ['checkrole:Admin']],
    function () {
        Route::get('/master-role', [RoleController::class, 'index'])->name('role.data.index');
        Route::get('/master-role/create', [RoleController::class, 'create'])->name('role.data.create');
        Route::post('/master-role/store', [RoleController::class, 'store'])->name('role.data.store');
        Route::get('/master-role/edit/{id}', [RoleController::class, 'edit'])->name('role.data.edit');
        Route::put('/master-role/update/{id}', [RoleController::class, 'update'])->name('role.data.update');
        Route::delete('/master-role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.data.destroy');
        // end
    }
);

// PATIENT/PASIEN
Route::get('/patient-data', [PatientController::class, 'indexDataPatient'])->name('patient.data.index');


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




// SOON

Route::get('/tambah_mcu', function () {
    return view('manajemen_data.reservasi.forms.form_tambahmcu');
});

Route::get('/edit_mcu', function () {
    return view('manajemen_data.reservasi.forms.form_editmcu');
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

Route::get('/coming-soon', function () {
    return view('landing-page.contents.coming-soon');
});
