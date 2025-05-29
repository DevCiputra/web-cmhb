<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormater;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    public function register(Request $request)
    {
        try {
            // 🔐 Validation
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

            // ⚙️ Service
            // Didalam result terdapat props user dan token
            $service = $this->authService->register($request);

            // 💬 Response
            if (!$service->status) {
                return ResponseFormater::error([
                    'message' => 'Register Failed',
                    'error'   => $service->message,
                ], 'Register Failed', 500);
            }
            return ResponseFormater::success([
                'access_token' => $service->data["token"],
                'token_type'   => 'Bearer',
                'user'         => $service->data["user"],
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
            // 🔐 Validation
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // 🔍 Cek user dan status sebelum attempt
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return ResponseFormater::error([
                    'message' => 'Email tidak ditemukan'
                ], 'Login Failed', 404);
            }

            // 🚫 Cek status sebelum verify password
            if ($user->status_activity === 'online') {
                return ResponseFormater::error([
                    'message' => 'Akun Anda sedang aktif di perangkat lain. Silakan logout terlebih dahulu.'
                ], 'Already Logged In', 409);
            }

            // 🔐 Baru cek credentials
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormater::error([
                    'message' => 'Email atau password salah'
                ], 'Unauthorized Failed', 401);
            }

            // ⚙️ Service (sekarang pasti berhasil)
            $service = $this->authService->login($request->email, $request->password);

            // 💬 Response
            return ResponseFormater::success([
                'access_token' => $service->data['token'],
                'token_type' => 'Bearer',
                'user' => $service->data['user'],
            ], 'Login Success');

        } catch (Exception $error) {
            return ResponseFormater::error([
                'message' => 'Login Failed',
                'error' => $error->getMessage()
            ], 'Login Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // ⚙️ Service
            $this->authService->logout($request);
            // 💬 Response
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

            // 🔐 Validation
            $request->validate([
                'email' => 'required|email',
            ]);

            // ⚙️ Service
            $serviceResult = $this->authService->requestPasswordResetOtp($request->email);
            if (!$serviceResult->status) {
                return ResponseFormater::error(null, $serviceResult->message, 404);
            }

            // 💬 Response
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
            // 🔐 Validation
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required',
            ]);

            $serviceResult = $this->authService->resetPasswordWithOtp($request->email, $request->otp);

            // ⚙️ Service
            if (!$serviceResult->status) {
                return ResponseFormater::error(null, $serviceResult->message, 400);
            }

            // 💬 Response
            return ResponseFormater::success($serviceResult->data, $serviceResult->message);
        } catch (Exception $error) {
            return ResponseFormater::error([
                'message' => 'OTP TIDAK VALID',
                'error' => $error->getMessage()
            ], 'OTP TIDAK VALID', 500);
        }
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            // 🔐 Validation
            $request->validate([
                'password' => 'required|string',
            ]);
            // ⚙️ Service
            $serviceResult = $this->authService->updatePassword($id, $request->password);

            // 💬 Response
            if (!$serviceResult->status) {
                return ResponseFormater::error(null, $serviceResult->message);
            }

            return ResponseFormater::success(null, $serviceResult->message);
        } catch (\Throwable $th) {
            return ResponseFormater::error(null, $th->getMessage(), 500);
        }
    }

    public function fetchUser($id) {
    $user = User::with(['patient'])->find($id);

        if($user) {
            // Clean patient data jika ada
            if ($user->patient) {
                $user->patient->address = $this->cleanText($user->patient->address);
                $user->patient->name = $this->cleanText($user->patient->name);
            }

            return ResponseFormater::success(
                $user,
                'Data User berhasil diambil'
            );
        }
        else {
            return ResponseFormater::error(
                null,
                'User tidak ada',
                404
            );
        }
    }

// Helper method di controller
    private function cleanText($text)
    {
        if (!$text) return $text;

        // Hapus \r\n, \n, \r
        $cleaned = str_replace(["\r\n", "\r", "\n"], ' ', $text);

        // Hapus multiple spaces
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        return trim($cleaned);
    }
}
