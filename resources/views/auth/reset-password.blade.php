@extends('auth.layouts')

@section('title', 'Reset Kata Sandi')

@section('form-title', 'Ganti Kata Sandi Anda')
@section('form-description', 'Silakan masukkan kata sandi baru Anda.')

@section('form-content')
<div class="container mt-5">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{!! htmlspecialchars_decode(session('error')) !!}</div>
    @endif

    <form action="{{ route('password.update', ['token' => $token]) }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group mb-3">
            <label for="password">Kata Sandi Baru:</label>
            <div class="input-group">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                    <i id="passwordIcon" class="fa fa-eye"></i>
                </button>
            </div>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="password_confirmation">Konfirmasi Kata Sandi:</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                    <i id="confirmPasswordIcon" class="fa fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Ganti Kata Sandi</button>
    </form>
</div>
@endsection


<script>
    function togglePassword(inputId) {
        const passwordField = document.getElementById(inputId);
        const passwordIcon = document.getElementById(inputId === 'password' ? 'passwordIcon' : 'confirmPasswordIcon');

        if (passwordField.type === "password") {
            passwordField.type = "text";
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = "password";
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }
</script>