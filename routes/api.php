<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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
Route::post('v1/requestOTP', [AuthController::class, 'requestPasswordResetOtp']);
Route::post('v1/requestReset', [AuthController::class, 'resetPasswordWithOtp']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('v1/logout', [AuthController::class, 'logout']);
    Route::post('v1/updateUser/{id}', [AuthController::class, 'updateUser']);
});
