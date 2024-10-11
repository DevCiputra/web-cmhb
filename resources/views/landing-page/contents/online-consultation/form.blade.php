@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/online-consultation">Konsultasi Online</a></li>
                <li class="breadcrumb-item"><a href="/doctor">Profile Dokter</a></li>
                <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Reservasi Konsultasi Online</li>
            </ol>
        </nav>
    </div>

    <div id="form-reservation" class="header-section">
        <div class="container-fluid">
            <h1 class="h3">Reservasi Konsultasi Online</h1>
            <p class="text-muted">Isi form berikut untuk melanjutkan proses reservasi konsultasi online dengan dokter pilihan Anda.</p>

            <div class="card-form">
                <div class="card-body">
                    <form action="{{ route('consultation.store') }}" method="POST">
                        @csrf
                        <!-- Nama Dokter -->
                        <div class="form-group mb-4">
                            <label for="doctorName" class="form-label">Nama Dokter</label>
                            <input type="text" class="form-control" id="doctorName" value="{{ $doctor->name }}" readonly style="height: 48px;">
                        </div>

                        <!-- Hidden Input Doctor ID -->
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                        <!-- Spesialis -->
                        <div class="form-group mb-4">
                            <label for="specialist" class="form-label">Spesialis</label>
                            <input type="text" class="form-control" id="specialist" value="{{ $doctor->specialization_name }}" readonly style="height: 48px;">
                        </div>

                        <!-- Poliklinik -->
                        <div class="form-group mb-4">
                            <label for="polyclinic" class="form-label">Poliklinik</label>
                            <input type="text" class="form-control" id="polyclinic" value="{{ $doctor->polyclinic->name ?? 'Umum' }}" readonly style="height: 48px;">
                        </div>

                        <!-- Nama Pasien -->
                        <div class="form-group mb-4">
                            <label for="patientName" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="patientName" name="patient_name" value="{{ $user->patient->name }}" readonly style="height: 48px;">
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="form-group mb-4">
                            <label for="phoneNumber" class="form-label">No. HP</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phone_number" value="{{ $user->whatsapp }}" required style="height: 48px;">
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required style="height: 48px;">
                        </div>

                        <!-- Pilih Tanggal Konsultasi -->
                        <div class="form-group mb-4">
                            <label for="consultationDay" class="form-label">Pilih Tanggal Konsultasi</label>
                            <input type="date" name="preferred_consultation_date" class="form-control" required>
                        </div>

                        <!-- Biaya Konsultasi -->
                        <div class="form-group mb-4">
                            <label for="consultationFee" class="form-label">Biaya Konsultasi</label>
                            <p class="consultation-fee">Rp. {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</p>
                        </div>

                        <!-- Button Submit -->
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary px-5" style="height: 48px; background-color: #007858; border-color: #007858; border-radius: 12px;">Reservasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush


@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush