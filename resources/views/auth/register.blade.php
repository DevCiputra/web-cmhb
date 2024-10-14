@extends('auth.layouts')

@section('title', 'Register')

@section('form-title', 'Create an Account')
@section('form-description', 'Fill in the details to register as a patient.')

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
        <label for="username" class="form-label">Username</label>
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
        <label for="whatsapp" class="form-label">WhatsApp Number</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fas fa-phone"></i></div>
            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="62xxxxxxxxxxx">
        </div>
        @error('whatsapp')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 text-start">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">
            Your password must contain at least one uppercase letter, one number, and be at least 8 characters long.
        </small>
    </div>    
    <div class="mb-3 text-start">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
    </div>
    <div class="mb-3 text-start">
        <label for="profile_picture" class="form-label">Profile Picture (Optional)</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Register</button>
    </div>
</form>

<div class="mt-3 text-center">
    <span>Already have an account?</span>
    <p><a href="{{ route('login') }}" class="text-decoration-none">Login Here</a>.</p>
</div>

@endsection