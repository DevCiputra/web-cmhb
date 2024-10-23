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
            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="62xxxxxxxxxxx">
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
        </div>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">
            Kata sandi harus memiliki minimal satu huruf kapital, satu angka, dan panjang minimal 8 karakter.
        </small>
    </div>    
    <div class="mb-3 text-start">
        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
