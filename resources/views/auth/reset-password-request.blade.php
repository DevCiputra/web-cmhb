@extends('auth.layouts')

@section('title', 'Reset Password')

@section('form-title', 'Ganti Kata Sandi')
@section('form-description', 'Masukkan nomor WhatsApp dan email untuk mengganti kata sandi.')

@section('form-content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('password.reset.process') }}" method="POST">
    @csrf
    <div class="mb-3 text-start">
        <label for="whatsapp" class="form-label">Nomor WhatsApp:</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-phone"></i></div>
            <input type="text" name="whatsapp" class="form-control" id="whatsapp" required>
        </div>
        @error('whatsapp')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 text-start">
        <label for="email" class="form-label">Email:</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        @error('email')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Kirim Permintaan Ganti Kata Sandi </button>
    </div>
</form>
@endsection