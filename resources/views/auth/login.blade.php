@extends('auth.layouts')

@section('title', 'Masuk')

@section('form-title', 'Masuk ke Akun Anda')
@section('form-description', 'Masukkan email dan kata sandi untuk masuk.')

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

<form method="POST" action="{{ route('login.post') }}">
    @csrf
    <div class="mb-3 text-start">
        <label for="username" class="form-label">Username</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
        </div>
        @error('username')
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
        </div>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Masuk</button>
    </div>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('password.reset.request') }}" class="text-decoration-none">Lupa kata sandi?</a>
</div>

<div class="mt-3 text-center">
    <!-- Link ke halaman registrasi -->
    <p>Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar di sini</a>.</p>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {


        togglePassword.addEventListener('click', function() {
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