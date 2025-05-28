<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DoctorController;
use App\Http\Controllers\API\DoctorPolyclinicController;
use App\Http\Controllers\API\ServiceCategoryController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\ReservationStatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('v1/register', [AuthController::class, 'register']);
Route::post('v1/login', [AuthController::class, 'login']);
Route::post('v1/updatePassword/{id}', [AuthController::class, 'updatePassword']);
Route::post('v1/requestOTP', [AuthController::class, 'requestPasswordResetOtp']);
Route::post('v1/requestReset', [AuthController::class, 'resetPasswordWithOtp']);




Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::post('poly', [DoctorPolyclinicController::class, 'storeNew']);

    // RESTful routes for DoctorPolyclinic
    Route::prefix('doctor_polyclinic')->name('api.doctor_polyclinic.')->group(function () {
        Route::get('/', [DoctorPolyclinicController::class, 'index'])->name('index');         // GET all
        Route::get('{id}', [DoctorPolyclinicController::class, 'show'])->name('show');        // GET by ID
        Route::post('{id}', [DoctorPolyclinicController::class, 'update'])->name('update');    // PUT update
        Route::delete('{id}', [DoctorPolyclinicController::class, 'destroy'])->name('destroy'); // DELETE
    });



    // RESTful routes for Doctor
    Route::prefix('doctors')->name('api.doctors.')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('index');         // GET all
        Route::get('{id}', [DoctorController::class, 'show'])->name('show');        // GET by ID
        Route::post('/', [DoctorController::class, 'store'])->name('store');        // POST new
        Route::post('{id}', [DoctorController::class, 'update'])->name('update');    // PUT update
        Route::delete('{id}', [DoctorController::class, 'destroy'])->name('destroy'); // DELETE
    });

    Route::get('serviceCategory', [ServiceCategoryController::class, 'getServiceCategory']);
    Route::get('reservationStatus', [ReservationStatusController::class, 'getReservationStatus']);
});
