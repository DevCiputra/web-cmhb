@extends('auth.layouts')

@section('title', 'Login')

@section('form-title', 'Login to Your Account')
@section('form-description', 'Enter your email and password to login.')

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
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('password.reset.request') }}" class="text-decoration-none">Forgot your password?</a>
</div>
@endsection