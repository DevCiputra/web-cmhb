<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public static function register($data)
    {
        $user = User::create([
            'username'     => $data->username,
            'email'    => $data->email,
            'password' => Hash::make($data->password),
            'whatsapp' => $data->whatsaap,
            'role' => $data->role,
            'gender'     => $data->gender,
            // 'status_aktif' => $data->status_aktif,
            'fcm' => $data->fcm
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return [
            "user" => $user,
            "token" => $token
        ];
    }

    public static function login($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!Hash::check($password, $user->password, [])) {
            throw new Exception('password is incorrect');
        }

        $token = $user->createToken('authToken')->plainTextToken;
        return [
            "user" => $user,
            "token" => $token
        ];
    }

    public static function logout($request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();
    }
}
