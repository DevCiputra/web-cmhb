<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OnlineConsultationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QuestionCategoryController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScreeningClassificationController;
use App\Http\Controllers\ScreeningOptionController;
use App\Http\Controllers\ScreeningQuestionController;
use App\Http\Controllers\ScreeningResultController;
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

// AUTH
Route::group(['middleware' => ['guest']], function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('throttle:5,1'); // Max 5 requests per minute
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1'); // Max 5 requests per minute
    Route::get('/password/reset', [AuthController::class, 'showResetPasswordRequestForm'])->name('password.reset.request')->middleware('throttle:5,1'); // Max 5 requests per minute
    Route::post('/password/reset', [AuthController::class, 'resetPasswordRequest'])->name('password.reset.process')->middleware('throttle:5,1'); // Max 5 requests per minute
    Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset.token')->middleware('throttle:5,1'); // Max 5 requests per minute
    Route::post('/password/reset/{token}', [AuthController::class, 'updatePassword'])->name('password.update')->middleware('throttle:5,1'); // Max 5 requests per minute
});
// LOGOUT

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// LANDING PAGE
Route::prefix('/')->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
    Route::get('/medical-check-up', [LandingPageController::class, 'medicalCheckUp'])->name('medical-check-up');
    Route::get('/home-service', [LandingPageController::class, 'homeService'])->name('home-service');
    Route::get('/polyclinic', [LandingPageController::class, 'polyclinic'])->name('polyclinic');
    Route::get('/promotion', [LandingPageController::class, 'promotion'])->name('promotion');
    Route::get('/information', [LandingPageController::class, 'information'])->name('information');
    Route::get('/consultation-online', [LandingPageController::class, 'consultation'])->name('onlineconsultation.landing');
    Route::get('/coming', [LandingPageController::class, 'coming'])->name('coming-page');
    Route::get('/online-consultation', [
        ReservationController::class,
        'indexLandingConsultation'
    ])->name('reservation.onlineconsultation.landing');
});

// SKRINING
Route::group(
    ['middleware' => ['checkrole:Pasien,Admin']],
    function () {
        Route::get('/screening', [ScreeningResultController::class, 'showForm'])->name('screening.form');
        Route::post('/screening/submit', [ScreeningResultController::class, 'submitAnswers'])->name('screening.submit');

        // Ubah route showResult untuk menerima answeredId
        Route::get('/screening-result/{answeredId}', [ScreeningResultController::class, 'showResult'])->name('showResult');

        // Route baru untuk riwayat skrining pasien
        Route::get('/screening/history', [ScreeningResultController::class, 'showHistory'])->name('screening.history');
    }
);

Route::group(
    ['middleware' => ['checkrole:Admin']],
    function () {
        Route::get('/screening-depretion', [ScreeningQuestionController::class, 'index'])->name('screening-depretion.index');
        Route::get('/screening-depretion/create', [ScreeningQuestionController::class, 'create'])->name('screening-depretion.create');
        Route::post('/screening-depretion', [ScreeningQuestionController::class, 'store'])->name('screening-depretion.store');
        Route::get('/screening-depretion/{question}/edit', [ScreeningQuestionController::class, 'edit'])->name('screening-depretion.edit');
        Route::put('/screening-depretion/{question}', [ScreeningQuestionController::class, 'update'])->name('screening-depretion.update');
        Route::delete('/screening-depretion/{question}', [ScreeningQuestionController::class, 'destroy'])->name('screening-depretion.destroy');

        // CRUD untuk Opsi di setiap Pertanyaan
        Route::get('/screening-depretion/{question}/options', [ScreeningOptionController::class, 'index'])->name('screening-depretion.screening-options.index');
        Route::get('/screening-depretion/{question}/options/create', [ScreeningOptionController::class, 'create'])->name('screening-depretion.screening-options.create');
        Route::post('/screening-depretion/{question}/options', [ScreeningOptionController::class, 'store'])->name('screening-depretion.screening-options.store');
        Route::get('/screening-depretion/{question}/options/{option}/edit', [ScreeningOptionController::class, 'edit'])->name('screening-depretion.screening-options.edit');
        Route::put('/screening-depretion/{question}/options/{option}', [ScreeningOptionController::class, 'update'])->name('screening-depretion.screening-options.update');
        Route::delete('/screening-depretion/{question}/options/{option}', [ScreeningOptionController::class, 'destroy'])->name('screening-depretion.screening-options.destroy');

        Route::get('/question-categories', [QuestionCategoryController::class, 'index'])->name('question-categories.index'); // Menampilkan daftar kategori
        Route::get('/question-categories/create', [QuestionCategoryController::class, 'create'])->name('question-categories.create'); // Form tambah kategori
        Route::post('/question-categories', [QuestionCategoryController::class, 'store'])->name('question-categories.store'); // Menyimpan kategori baru
        Route::get('/question-categories/{questionCategory}/edit', [QuestionCategoryController::class, 'edit'])->name('question-categories.edit'); // Form edit kategori
        Route::put('/question-categories/{questionCategory}', [QuestionCategoryController::class, 'update'])->name('question-categories.update'); // Memperbarui data kategori
        Route::delete('/question-categories/{questionCategory}', [QuestionCategoryController::class, 'destroy'])->name('question-categories.destroy'); // Menghapus kategori

        Route::get('/screening-classifications', [ScreeningClassificationController::class, 'index'])->name('screening-classifications.index'); // Menampilkan daftar klasifikasi
        Route::get('/screening-classifications/create', [ScreeningClassificationController::class, 'create'])->name('screening-classifications.create'); // Form tambah klasifikasi
        Route::post('/screening-classifications', [ScreeningClassificationController::class, 'store'])->name('screening-classifications.store'); // Menyimpan klasifikasi baru
        Route::get('/screening-classifications/{id}/edit', [ScreeningClassificationController::class, 'edit'])->name('screening-classifications.edit'); // Form edit klasifikasi
        Route::put('/screening-classifications/{id}', [ScreeningClassificationController::class, 'update'])->name('screening-classifications.update'); // Memperbarui klasifikasi
        Route::delete('/screening-classifications/{id}', [ScreeningClassificationController::class, 'destroy'])->name('screening-classifications.destroy'); // Menghapus klasifikasi


    }
);



// DOKTER
Route::get('/doctor', [LandingPageController::class, 'doctor'])->name('doctor.landing');
Route::get('/doctor/profile/{id}', [LandingPageController::class, 'showDoctor'])->name('doctor.show.landing');
Route::get('/search-doctor', [DoctorController::class, 'searchDoctor'])->name('doctor.search');

// MCU
Route::get('/medical-check-up/detail/{id}', [LandingPageController::class, 'showMcuDetail'])->name('mcu.detail.landing');


// PX ONLINE CONSULTATION
Route::group(['middleware' => ['checkrole:Pasien,Admin']], function () {

    Route::get('/consultation-form/{doctor_id}', [OnlineConsultationController::class, 'showConsultationForm'])->name('consultation.form');
    Route::post('/consultation-form', [OnlineConsultationController::class, 'storeReservation'])->name('consultation.store');
    Route::get('/consultation-confirmation/{id}', [OnlineConsultationController::class, 'showConfirmation'])->name('consultation.confirmation');
    Route::get('/consultation-detail/{id}', [OnlineConsultationController::class, 'showConsultationDetail'])->name('consultation.detail');
    Route::get('/consultation-invoice/{id}', [OnlineConsultationController::class, 'showInvoice'])->name('consultation.invoice');
    Route::post('/consultation-payment/{id}', [OnlineConsultationController::class, 'confirmPayment'])->name('consultation.payment');
    Route::get('/terms-and-conditions', [RegulationController::class, 'termsAndConditions'])->name('terms-and-conditions');

});

// OFFICE MANAGEMENT ONLINE CONSULTATION DATA
Route::group(['middleware' => ['checkrole:Admin,PLP']], function () {
    Route::post('/reservation/{id}/approve', [OnlineConsultationController::class, 'approveReservation'])->name('reservation.approve');
    Route::post('/reservation/{id}/cancel', [OnlineConsultationController::class, 'cancelReservation'])->name('reservation.cancel');
    Route::delete('/reservation/{id}/delete', [OnlineConsultationController::class, 'deleteReservation'])->name('reservation.delete');
    Route::post('/reservation/{id}/contact-patient', [OnlineConsultationController::class, 'contactPatient'])->name('reservation.contact');
    Route::post('/reservation/{id}/agree-schedule', [OnlineConsultationController::class, 'agreeSchedule'])->name('reservation.schedule');
    Route::post('/reservation/{id}/confirm-payment-status', [OnlineConsultationController::class, 'confirmPaymentStatus'])->name('reservation.confirm-paymet');
    Route::get('/reservation-online-consultation', [ReservationController::class, 'indexConsultation'])->name('reservation.onlineconsultation.index');
    Route::get('reservations/filterByDate', [ReservationController::class, 'filterByDate'])->name('reservations.filterByDate');
    Route::get('/reservation-count', [ReservationController::class, 'getReservationCount'])->name('reservation.count');
    Route::get('/reservation-online-consultation/detail/{id}', [ReservationController::class, 'detailConsultation'])->name('reservation.onlineconsultation.detail');
    Route::get('/reservation-online-consultation/invoice', [ReservationController::class, 'invoiceConsultation'])->name('reservation.onlineconsultation.invoice');
});

// PX ACCOUNT MANAGEMENT
Route::group(['middleware' => ['checkrole:Pasien,Admin']], function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account-index');
    Route::post('/account/update/{id}', [AccountController::class, 'update'])->name('account-update');
});

// OFFICE MANAGEMENT DASHBOARD
Route::group(['middleware' => ['checkrole:Admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-page');
});

// MCU MANAGEMENT DATA
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

// POLYCLINIC MANAGEMENT DATA
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/reservation-polyclinic', [ReservationController::class, 'indexPoly'])->name('reservation.poly.index');
});

// HOME SERVICE MANAGEMENT DATA
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/reservation-homeservice', [ReservationController::class, 'indexHomeService'])->name('reservation.homeservice.index');
});

// INFORMATION MANAGEMENT DATA
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
Route::get('/information-article', [InformationController::class, 'indexArticle'])->name('information.article.index');
Route::get('/information-article/create', [InformationController::class, 'createArticle'])->name('information.article.create');
Route::get('/information-article/edit', [InformationController::class, 'editArticle'])->name('information.article.edit');
Route::get('/information-article/detail', [InformationController::class, 'detailArticle'])->name('information.article.detail');

Route::get('/information-promote', [InformationController::class, 'indexPromote'])->name('information.promotion.index');
Route::get('/information-promote/create', [InformationController::class, 'createPromote'])->name('information.promote.create');
Route::get('/information-promote/edit', [InformationController::class, 'editPromote'])->name('information.promote.edit');

});

// DOCTOR MANAGEMENT DATA
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/doctor-data', [DoctorController::class, 'indexDataDoctor'])->name('doctor.data.index');

    Route::post('/doctor-data/{id}/update-published', [DoctorController::class, 'updatePublishedStatus'])->name('doctor.data.updatePublished');


    Route::get('/doctor-data/create', [DoctorController::class, 'create'])->name('doctor.data.create');
    Route::post('/doctor-data/store', [DoctorController::class, 'store'])->name('doctor.data.store');
    Route::get('/doctor-data/{id}/edit', [DoctorController::class, 'edit'])->name('doctor.data.edit');
    Route::put('/doctor-data/{id}', [DoctorController::class, 'update'])->name('doctor.data.update');
    Route::delete('/doctor-data/{id}', [DoctorController::class, 'destroy'])->name('doctor.data.destroy');
    Route::get('/doctor-data/{id}', [DoctorController::class, 'show'])->name('doctor.data.show');
    Route::get('/doctors-data/search', [DoctorController::class, 'searchDoctor'])->name('doctor.data.search');
});

// DOCTOR POLYCLINIC MANAGEMENT DATA
Route::group(['middleware' => ['checkrole:HBD,Admin']], function () {
    Route::get('/doctor-polyclinic', [DoctorController::class, 'indexPolyclinicDoctor'])->name('doctor.polyclinic.index');
    Route::get('/doctor-polyclinic/create', [DoctorController::class, 'createPolyclinicDoctor'])->name('doctor.polyclinic.create');
    Route::post('/doctor-polyclinic/store', [DoctorController::class, 'storePolyclinicDoctor'])->name('doctor.polyclinic.store');
    Route::get('/doctor-polyclinic/edit/{id}', [DoctorController::class, 'editPolyclinicDoctor'])->name('doctor.polyclinic.edit');
    Route::post('/doctor-polyclinic/update/{id}', [DoctorController::class, 'updatePolyclinicDoctor'])->name('doctor.polyclinic.update');
    Route::delete('/doctor-polyclinic/delete/{id}', [DoctorController::class, 'deletePolyclinicDoctor'])->name('doctor.polyclinic.delete');
});

// MASTER MANAGEMENT DATA

// USER MANAGEMENT DATA
Route::group(['middleware' => ['checkrole:Admin']], function () {
    Route::get('/master-user', [UserController::class, 'index'])->name('user.data.index');
    Route::get('/master-user/create', [UserController::class, 'create'])->name('user.data.create'); // Form tambah user baru
    Route::post('/master-user', [UserController::class, 'store'])->name('user.data.store'); // Menyimpan user baru
    Route::get('/master-user/{id}/edit', [UserController::class, 'edit'])->name('user.data.edit'); // Form edit user
    Route::put('/master-user/{id}', [UserController::class, 'update'])->name('user.data.update'); // Mengupdate user
    Route::delete('/master-user/{id}', [UserController::class, 'destroy'])->name('user.data.destroy'); // Menghapus user
});

// INFORMATION HOSPITAL AND GALLERY MANAGEMENT DATA
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
        Route::get(
            '/master-gallery-cmh',
            [MasterController::class, 'indexGallery']
        )->name('gallery.data.index');
        Route::get('/master-gallery-cmh/create', [MasterController::class, 'createGallery'])->name('gallery.data.create');
        Route::post('/master-gallery-cmh/store', [MasterController::class, 'storeGallery'])->name('gallery.data.store');
        Route::get('/master-gallery-cmh/edit/{id}', [MasterController::class, 'editGallery'])->name('gallery.data.edit');
        Route::put('/master-gallery-cmh/update/{id}', [MasterController::class, 'updateGallery'])->name('gallery.data.update');
        Route::delete('/master-gallery-cmh/destroy/{id}', [MasterController::class, 'destroyGallery'])->name('gallery.data.destroy');
    }
);

// ROLE MANAGEMENT DATA
Route::group(
    ['middleware' => ['checkrole:Admin']],
    function () {
        Route::get('/master-role', [RoleController::class, 'index'])->name('role.data.index');
        Route::get('/master-role/create', [RoleController::class, 'create'])->name('role.data.create');
        Route::post('/master-role/store', [RoleController::class, 'store'])->name('role.data.store');
        Route::get('/master-role/edit/{id}', [RoleController::class, 'edit'])->name('role.data.edit');
        Route::put('/master-role/update/{id}', [RoleController::class, 'update'])->name('role.data.update');
        Route::delete('/master-role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.data.destroy');
    }
);

// PX MANAGEMENT DATA
Route::group(
    ['middleware' => ['checkrole:Admin']],
    function () {
        Route::get('/patient-data', [PatientController::class, 'indexDataPatient'])->name('patient.data.index');
    }
);


// SKRININGGGGG
Route::get('/skrining', function () {
    return view('landing-page.contents.skrining');
});

// COMING SOON (ON PROGRESS AFTER PROD V.1)

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
Route::get('/promosi_detail', function () {
    return view('promosi_detail');
});
Route::get('/informasi', function () {
    return view('informasi');
});
Route::get('/informasi_detail', function () {
    return view('informasi_detail');
});
