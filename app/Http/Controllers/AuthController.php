<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input yang lebih ketat
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9_.-]*$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'whatsapp' => 'required|string|max:20|regex:/^\+?62\d{9,12}$/',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi jika email sudah digunakan
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->back()->with('error', 'The email address is already registered. Please use a different one.')->withInput();
        }

        // Validasi jika nomor WhatsApp sudah digunakan
        $existingWhatsApp = User::where('whatsapp', $request->whatsapp)->first();
        if ($existingWhatsApp) {
            return redirect()->back()->with('error', 'The WhatsApp number is already registered. Please use a different one.')->withInput();
        }

        // Proses pembuatan User baru
        $sanitizedUsername = htmlspecialchars($request->username, ENT_QUOTES, 'UTF-8');
        $sanitizedEmail = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $sanitizedWhatsapp = htmlspecialchars($request->whatsapp, ENT_QUOTES, 'UTF-8');

        // Handle Profile Picture Upload
        $profilePicture = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture')->store('profiles', 'public');
        }

        // Simpan data ke database
        $userCreated = User::create([
            'username' => $sanitizedUsername,
            'email' => $sanitizedEmail,
            'password' => Hash::make($request->password),
            'role' => 'Pasien',
            'whatsapp' => $sanitizedWhatsapp,
            'profile_picture' => $profilePicture,
        ]);

        // Jika user gagal dibuat
        if (!$userCreated) {
            return redirect()->back()->with('error', 'Failed to create a new user. Please try again.')->withInput();
        }

        // Buat data Pasien yang terhubung dengan User
        $patientCreated = Patient::create([
            'name' => $sanitizedUsername,
            'user_id' => $userCreated->id,
        ]);

        if (!$patientCreated) {
            $userCreated->delete(); // Hapus user yang sudah dibuat
            return redirect()->back()->with('error', 'Failed to create patient profile. Please try again.')->withInput();
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = Auth::user();

            // Redirect user based on role
            switch ($user->role) {
                case 'Admin':
                    return redirect()->route('dashboard-page')->with('success', 'Welcome Admin!');
                case 'Pasien':
                    return redirect()->route('account-index')->with('success', 'Welcome Pasien!');
                case 'HBD':
                    return redirect()->route('reservation.mcu.index')->with('success', 'Welcome HBD!');
                default:
                    auth()->logout();
                    return redirect()->route('login')->with('error', 'Invalid role detected.');
            }
        }

        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    }


    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/'); // Atau redirect ke route lain sesuai kebutuhan
    }

    public function showResetPasswordRequestForm(Request $request)
    {

        return view('auth.reset-password-request');
    }

    public function resetPasswordRequest(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string',
            'email' => 'required|string|email',
        ]);

        // Temukan user berdasarkan nomor WhatsApp dan email
        $user = User::where('whatsapp', $request->whatsapp)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found with this WhatsApp number and email.');
        }

        // Generate token dan simpan ke tabel `password_reset_tokens`
        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Arahkan user ke halaman ganti password dengan token yang dihasilkan
        return redirect()->route('password.reset.token', ['token' => $token]);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }


    public function updatePassword(Request $request, $token)
    {
        // Validasi input password
        $request->validate([
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        // Ambil email berdasarkan token dari tabel `password_reset_tokens`
        $reset = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!$reset) {
            return redirect()->back()->with('error', 'Invalid token or token has expired.');
        }

        // Temukan user berdasarkan email dari token
        $user = User::where('email', $reset->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Update password user
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token reset dari tabel `password_reset_tokens`
        DB::table('password_reset_tokens')->where('email', $reset->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset successfully. Please login.');
    }
}
