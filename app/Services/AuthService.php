<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\EmailVerification;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService implements AuthServiceInterface
{
    public function register($data): ServiceResponse
    {
        try {
            $user = User::create([
                'username'     => $data->username,
                'email'        => $data->email,
                'password'     => Hash::make($data->password),
                'whatsapp'     => $data->whatsapp,
                'role'         => $data->role,
                'gender'       => $data->gender,
                'fcm'          => $data->fcm
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return ServiceResponse::success('Registrasi berhasil', [
                'user'  => $user,
                'token' => $token
            ]);
        } catch (Exception $e) {
            return ServiceResponse::error('Registrasi gagal', $e->getMessage());
        }
    }

    public function login($email, $password): ServiceResponse
    {
        try {
            $user = User::where('email', $email)->first();

            if (!$user || !Hash::check($password, $user->password)) {
                return ServiceResponse::error('Email atau password salah');
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return ServiceResponse::success('Login berhasil', [
                'user'  => $user,
                'token' => $token
            ]);
        } catch (Exception $e) {
            return ServiceResponse::error('Login gagal', $e->getMessage());
        }
    }

    public function logout(Request $request): ServiceResponse
    {
        try {
            if (!$request->user()) {
                return ServiceResponse::error('Logout gagal', null);
            }
            $request->user()->currentAccessToken()->delete();
            return ServiceResponse::success('Logout berhasil');
        } catch (Exception $e) {
            return ServiceResponse::error('Logout gagal', $e->getMessage());
        }
    }

    public function requestPasswordResetOtp($email): ServiceResponse
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return ServiceResponse::error('Email tidak terdaftar');
        }

        $otp = random_int(100000, 999999);

        EmailVerification::updateOrCreate(
            ['email' => $email],
            ['otp' => $otp, 'created_at' => now()]
        );

        Mail::to($email)->send(new OtpMail($otp));

        return ServiceResponse::success('OTP sudah dikirim');
    }

    public function resetPasswordWithOtp(String $email, String $otp): ServiceResponse
    {
        try {
            // Step 1: Verify the OTP
            $verification = EmailVerification::where('email', $email)
                ->where('otp', $otp)
                ->first();

            if (!$verification) {
                return ServiceResponse::error('Kode OTP salah atau email tidak ditemukan', null);
            }

            // Step 2: Find user with the email
            $user = User::where('email', $email)->first();
            if (!$user) {
                return ServiceResponse::error('User tidak ditemukan', null);
            }

            // Step 4: Delete the OTP after successful password reset
            $verification->delete();
            return ServiceResponse::success('Silahkan melanjutkan Reset Password', $user);
        } catch (Exception $e) {
            return ServiceResponse::error('OTP Gagal', $e->getMessage());
        }
    }


    public function updatePassword(int $id, string $password): ServiceResponse
    {
        try {
            $user = User::findOrFail($id);

            $user->password = Hash::make($password); // ✅ hash password
            $user->save(); // ✅ save data

            return ServiceResponse::success('Update Password sudah berhasil');
        } catch (\Throwable $th) {
            return ServiceResponse::error('Update password gagal', $th->getMessage()); // ✅ tangani error
        }
    }
}
