<?php

namespace Tests\Unit;

use App\Models\EmailVerification;
use App\Models\User;
use App\Services\AuthService;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Nette\Utils\Random;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_register_successfully()
    {
        // Arrange
        $service = new AuthService();
        $data = (object)[
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'whatsaap' => '08123456789',
            'role' => 'Patient',
            'gender' => 'male',
            'fcm' => null,
        ];

        // Act
        $response = $service->register($data);

        // Assert
        $this->assertTrue($response->status);
        $this->assertEquals('Registrasi berhasil', $response->message);
        $this->assertArrayHasKey('user', (array)$response->data);
        $this->assertArrayHasKey('token', (array)$response->data);
    }

    public function test_register_fails_with_duplicate_email()
    {
        $user = User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        $service = new AuthService();
        $data = (object)[
            'username' => 'newuser',
            'email' => 'existing@example.com', // email sudah dipakai
            'password' => 'password',
            'whatsaap' => '08123456789',
            'role' => 'user',
            'gender' => 'male',
            'fcm' => null,
        ];

        $response = $service->register($data);

        $this->assertFalse($response->status);
        $this->assertEquals('Registrasi gagal', $response->message);
    }

    public function test_login_successfully()
    {
        $email = 'test@example.com';
        $password = 'password';
        User::factory()->create(['email' => $email]);
        $service = new AuthService();

        $response = $service->login($email, $password);

        $this->assertTrue($response->status);
        $this->assertEquals($email, $response->data['user']['email']);
        $this->assertArrayHasKey('token', (array)$response->data);
    }

    public function test_login_fail_with_wrong_username()
    {
        $email = 'test@example.com';
        $password = 'password';
        User::factory()->create(['email' => $email]);
        $service = new AuthService();

        $response = $service->login("wrong@example.com", $password);

        $this->assertFalse($response->status);
        $this->assertEquals('Email atau password salah', $response->message);
    }

    public function test_login_fail_with_wrong_password()
    {
        $email = 'test@example.com';
        $password = 'password';
        User::factory()->create(['email' => $email]);
        $service = new AuthService();
        $service = new AuthService();

        $response = $service->login($email, "password_salah");

        $this->assertFalse($response->status);
        $this->assertEquals('Email atau password salah', $response->message);
    }

    public function test_logout_successfully()
    {
        // Arrange: buat user dan login untuk mendapatkan token
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => "password"
        ]);

        Sanctum::actingAs($user); // Set user sebagai user yang sedang login

        // Buat instance request palsu dengan user terautentikasi
        $request = Request::create('/logout', 'POST');
        $request->setUserResolver(fn() => $user); // Simulasikan user di request

        $service = new AuthService();

        // Act: panggil method logout
        $response = $service->logout($request);

        // Assert
        $this->assertTrue($response->status);
        $this->assertEquals('Logout berhasil', $response->message);
    }

    /** @test */
    public function test_logout_fails_without_user()
    {
        $request = Request::create('/logout', 'POST');
        $request->setUserResolver(fn() => null); // tidak ada user

        $service = new AuthService();

        $response = $service->logout($request);

        $this->assertFalse($response->status);
        $this->assertEquals('Logout gagal', $response->message);
    }

    public function test_request_reset_password_otp_succesfully()
    {
        $email = 'test@example.com';

        User::factory()->create([
            'email' => $email,
            'password' => "password"
        ]);
        $service = new AuthService();
        $response = $service->requestPasswordResetOtp($email);

        $this->assertTrue($response->status);
    }

    public function test_request_reset_password_otp_fail_email_never_registered()
    {
        $email = 'test@example.com';

        User::factory()->create([
            'email' => $email,
            'password' => "password"
        ]);
        $service = new AuthService();
        $response = $service->requestPasswordResetOtp("emailsalah@example.com");

        $this->assertFalse($response->status);
    }

    public function test_request_password_with_otp_succesfully()
    {
        $service = new AuthService();

        $email = 'test@example.com';
        $otp = "12345";
        User::factory()->create(['email' => $email]);
        EmailVerification::factory()->create(['email' => $email,  'otp' => $otp]);

        $response = $service->resetPasswordWithOtp($email, $otp);
        $this->assertTrue($response->status);
        $this->assertEquals('Silahkan melanjutkan Reset Password', $response->message);
    }

    public function test_request_password_with_otp_fail_if_otp_is_wrong()
    {
        $service = new AuthService();

        $email = 'test@example.com';
        $otp = "12345";
        User::factory()->create(['email' => $email]);
        EmailVerification::factory()->create(['email' => $email,  'otp' => $otp]);

        $response = $service->resetPasswordWithOtp($email, "salah");
        $this->assertFalse($response->status);
        $this->assertEquals('Kode OTP salah atau email tidak ditemukan', $response->message);
    }

    public function test_request_password_with_otp_fail_if_email_not_found()
    {
        $service = new AuthService();

        $otp = "12345";

        $response = $service->resetPasswordWithOtp('test@example.com', "salah");
        $this->assertFalse($response->status);
        $this->assertEquals('Kode OTP salah atau email tidak ditemukan', $response->message);
    }

    public function test_update_password_succesfully()
    {
        $service = new AuthService();

        $user = User::factory()->create();
        $id = $user->id;
        $password = 'password_baru';
        $response = $service->updatePassword($id, $password);

        $newUser = User::findOrFail($id);

        $userVerified = Hash::check($password, $newUser->password);
        $this->assertTrue($response->status);
        $this->assertTrue($userVerified);
        $this->assertEquals('Update Password sudah berhasil', $response->message);
    }

    public function test_update_password_fail_id_not_found()
    {
        $service = new AuthService();

        $id = rand(100000, 999999);
        $password = 'password_baru';
        $response = $service->updatePassword($id, $password);

        $this->assertFalse($response->status);
        $this->assertEquals('Update password gagal', $response->message);
    }
}
