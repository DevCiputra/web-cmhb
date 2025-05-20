<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormater;
use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\EmailVerification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username'     => 'required|string|max:255',
                'email'    => 'required|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'whatsapp' => 'sometimes|string|max:20',
                'role' => 'sometimes|string|max:10',
                'gender'     => 'required|string|max:255',
                // 'status_aktif' => 'sometimes',
                'fcm' => 'sometimes|nullable'
            ]);
            if ($validator->fails()) {
                return ResponseFormater::error(null, $validator->errors()->first(), 400);
            }


            // simpan data user
            $user = User::create([
                'username'     => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'whatsapp' => $request->whatsaap,
                'role' => $request->role,
                'gender'     => $request->gender,
                // 'status_aktif' => $request->status_aktif,
                'fcm' => $request->fcm
            ]);

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormater::success([
                'access_token' => $tokenResult,
                'token_type'   => 'Bearer',
                'user'         => $user,
                // 'otp'          => $otp // kalau di production sebaiknya jangan kirim OTP ke response
            ], 'Register Success, kode verifikasi telah dikirim ke email');
        } catch (Exception $error) {
            return ResponseFormater::error([
                'message' => 'Register Failed',
                'error'   => $error->getMessage()
            ], 'Register Failed', 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $crendetials = request(['email', 'password']);

            if (!Auth::attempt($crendetials)) {
                return ResponseFormater::error([
                    'message' => 'Unauthorized'
                ], 'Unauthorized Failed', 404);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new Exception('password is incorrect');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormater::success([
                'access_token' =>  $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login Success');
        } catch (Exception $error) {
            return ResponseFormater::error([
                'message' => 'Login Failed',
                'error' => $error
            ], 'Login Failed', 404);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke the token that was used to authenticate the current request
            $request->user()->currentAccessToken()->delete();

            return ResponseFormater::success(null, 'Logout Success');
        } catch (Exception $error) {
            return ResponseFormater::error([
                'message' => 'Logout Failed',
                'error'   => $error->getMessage()
            ], 'Logout Failed', 500);
        }
    }

    public function requestPasswordResetOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $email = $request->email;
            $user = User::where('email', $email)->first();

            if (!$user) {
                return ResponseFormater::error(null, 'Email tidak terdaftar', 404);
            }

            // Generate OTP (6 digit random number)
            $otp = random_int(100000, 999999);

            // Save OTP to database (replace any existing OTP)
            EmailVerification::updateOrCreate(
                ['email' => $email],
                ['otp' => $otp, 'created_at' => now()]
            );

            // Send OTP email
            Mail::to($email)->send(new OtpMail($otp));

            return ResponseFormater::success([
                'message' => 'Kode OTP telah dikirim ke email Anda',
            ], 'Permintaan Reset Password Berhasil');
        } catch (Exception $error) {
            return ResponseFormater::error([
                'message' => 'Permintaan Reset Password Gagal',
                'error' => $error->getMessage()
            ], 'Permintaan Reset Password Gagal', 500);
        }
    }

    public function resetPasswordWithOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required',
            ]);

            // Step 1: Verify the OTP
            $verification = EmailVerification::where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

            if (!$verification) {
                return ResponseFormater::error(null, 'Kode OTP salah atau email tidak ditemukan', 400);
            }

            // Memperpanjang waktu kedaluwarsa OTP dari 10 menit menjadi 30 menit
            // $otpExpiry = 30; // dalam menit

            // // Check if OTP has expired
            // if (now()->diffInMinutes($verification->created_at) > $otpExpiry) {
            //     return ResponseFormmater::error(null, 'Kode OTP sudah kedaluwarsa', 400);
            // }

            // Step 2: Find user with the email
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return ResponseFormater::error(null, 'User tidak ditemukan', 404);
            }

            // Step 4: Delete the OTP after successful password reset
            $verification->delete();

            return ResponseFormater::success([
                'message' => 'Silahkan melanjutkan Reset Password',
            ], 'OTP VALID');
        } catch (Exception $error) {
            return ResponseFormater::error([
                'message' => 'OTP TIDAK VALID',
                'error' => $error->getMessage()
            ], 'OTP TIDAK VALID', 500);
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $existingData = User::where('email', $request->email)->where('id', '!=', $id)->first();

        if ($existingData) {
            return ResponseFormater::error(
                null,
                'Email sudah dimiliki orang lain',
                505
            );
        }

        $data = $request->all();

        if ($request->input('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data = Arr::except($data, ['password']);
        }


        $user->update($data);
        return ResponseFormater::success(
            $user,
            'Data User berhasil diupdate'
        );
    }
}
