<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Services\ServiceResponse;

interface AuthServiceInterface
{
    public function register($data): ServiceResponse;
    public function login($email, $password): ServiceResponse;
    public function logout(Request $request): ServiceResponse;
    public function requestPasswordResetOtp($email): ServiceResponse;
    public function resetPasswordWithOtp(String $email, String $otp): ServiceResponse;
    public function updatePassword(int $id, string $password): ServiceResponse;
}
