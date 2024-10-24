@extends('auth.layouts')

@section('title', 'Daftar')

@section('form-title', 'Buat Akun')
@section('form-description', 'Isi detail di bawah untuk mendaftar sebagai pasien.')

@section('form-content')

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
    @csrf <!-- Token CSRF untuk perlindungan -->
    <div class="mb-3 text-start">
        <label for="name" class="form-label">Nama Lengkap</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>    
    <div class="mb-3 text-start">
        <label for="username" class="form-label">Nama Pengguna / Username</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required autofocus>
        </div>
        @error('username')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 text-start">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        @error('email')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 text-start">
        <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fas fa-phone"></i></div>
            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="08xxxxxxxxxxx">
        </div>
        @error('whatsapp')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>    
    <div class="mb-3 text-start">
        <label for="password" class="form-label">Kata Sandi</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
            <input type="password" class="form-control" id="password" name="password" required>
            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                <i class="fa-solid fa-eye" id="eyeIcon"></i>
            </button>
            <small class="form-text text-muted">
                Kata sandi harus memiliki minimal satu huruf kapital, satu angka, dan panjang minimal 8 karakter.
            </small>
        </div>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3 text-start">
        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirmation">
                <i class="fa-solid fa-eye" id="eyeIconConfirm"></i>
            </button>
        </div>
    </div>
     
    <div class="mb-3 text-start">
        <label for="profile_picture" class="form-label">Foto Profil (Opsional)</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Daftar</button>
    </div>
</form>

<div class="mt-3 text-center">
    <span>Sudah punya akun?</span>
    <p><a href="{{ route('login') }}" class="text-decoration-none">Masuk di sini</a>.</p>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {


        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute between 'password' and 'text'
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the eye icon
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Toggle Password Visibility for the confirmation field
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmation = document.querySelector('#password_confirmation');
        const eyeIconConfirm = document.querySelector('#eyeIconConfirm');

    });
</script>


