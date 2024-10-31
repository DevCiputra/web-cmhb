<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\Patient;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        // Validasi input dengan pesan khusus
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9_.-]*$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'whatsapp' => 'required|string|max:20|regex:/^08\d{8,11}$/',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Nama pengguna wajib diisi.',
            'username.regex' => 'Nama pengguna hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda hubung.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi harus minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, dan angka.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Format nomor WhatsApp tidak valid. Harus dimulai dengan 08.',
            'profile_picture.image' => 'Foto profil harus berupa gambar.',
            'profile_picture.mimes' => 'Foto profil harus berformat: jpeg, png, atau jpg.',
            'profile_picture.max' => 'Ukuran foto profil maksimal :max kilobytes.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi email dan nomor WhatsApp unik
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()
            ->with('error', 'Alamat email sudah terdaftar. Silakan gunakan alamat email lain.')
            ->withInput();
        }

        if (User::where('whatsapp', $request->whatsapp)->exists()) {
            return redirect()->back()
            ->with('error', 'Nomor WhatsApp sudah terdaftar. Silakan gunakan nomor lain.')
            ->withInput();
        }

        // Sanitasi data dan simpan user
        $profilePicture = $request->hasFile('profile_picture')
        ? $request->file('profile_picture')->store('profiles', 'public')
        : null;

        $user = User::create([
            'username' => htmlspecialchars($request->username, ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($request->email, FILTER_SANITIZE_EMAIL),
            'password' => Hash::make($request->password),
            'role' => 'Pasien',
            'whatsapp' => htmlspecialchars($request->whatsapp, ENT_QUOTES, 'UTF-8'),
        ]);

        if (!$user) {
            return redirect()->back()->with('error', 'Gagal membuat pengguna baru. Silakan coba lagi.')->withInput();
        }

        $patient = Patient::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'profile_picture' => $profilePicture,
        ]);

        if (!$patient) {
            $user->delete();
            return redirect()->back()->with('error', 'Gagal membuat profil pasien. Silakan coba lagi.')->withInput();
        }

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan masuk menggunakan akun Anda.');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $user = Auth::user();

            // Fetch the associated Patient record
            $patient = $user->patient; // Assuming a one-to-one relationship

            // Redirect user based on role
            switch ($user->role) {
                case 'Admin':
                    return redirect()->route('dashboard-page')->with('success', 'Selamat datang, ' . $user->name . ' (Admin)!');
                case 'Pasien':
                    // Use the patient's name instead
                    return redirect()->route('account-index')->with('success', 'Selamat datang, ' . ($patient ? $patient->name : 'User') . '!');
                case 'HBD':
                    return redirect()->route('reservation.mcu.index')->with('success', 'Selamat datang, HBD!');
                default:
                    auth()->logout();
                    return redirect()->route('login')->with('error', 'Peran pengguna tidak valid.');
            }
        }

        return redirect()->back()->with('error', 'username atau kata sandi salah.')->withInput();
    }


    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/')->with('success', 'Anda telah keluar.');
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

        // Temukan user berdasarkan WhatsApp dan email
        $user = User::where('whatsapp', $request->whatsapp)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna dengan nomor WhatsApp dan email tersebut tidak ditemukan.');
        }

        // Generate token dan simpan di database dengan created_at
        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => now(), // Menyimpan waktu saat ini
            ]
        );

        // Kirim email dengan link reset password (atau bisa melalui WhatsApp)
        Mail::to($user->email)->send(new ResetPasswordMail($token));

        return redirect()->back()->with('success', 'Permintaan reset password diterima, silahkan cek email untuk link resetnya');
    }


    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request, $token)
    {
        // Ambil token dari tabel `password_reset_tokens`
        $reset = DB::table('password_reset_tokens')->where('token', $token)->first();

        // Cek apakah token valid dan belum kedaluwarsa
        if (!$reset || now()->diffInMinutes($reset->created_at) > 10) {
            return redirect()->back()->with('error', 'Token tidak valid atau telah kedaluwarsa. Silakan <a href="' . route('password.reset.request') . '">request ulang reset password</a>.');
        }

        // Temukan user berdasarkan email dari token
        $user = User::where('email', $reset->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        // Validasi input password
        $request->validate([
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ], [
            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa string.',
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
            'password.regex' => 'Kata sandi harus memiliki setidaknya satu huruf besar, satu huruf kecil, dan satu angka.',
        ]);

        // Update password user
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token reset dari tabel `password_reset_tokens`
        DB::table('password_reset_tokens')->where('email', $reset->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi telah berhasil direset. Silakan login.');
    }


}
