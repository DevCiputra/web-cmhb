@extends('landing-page.layouts.app')

@section('content')
<!-- Breadcrumb Section -->
<div class="container" style="margin-top: 110px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
            <li class="breadcrumb-item"><a href="/account">Profil</a></li>
            <li class="breadcrumb-item"><a href="/account">Riwayat Pesanan</a></li>
            <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Invoice Pembayaran</li>
        </ol>
    </nav>
</div>

<div class="invoice-container">
    <div class="invoice-header text-center">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
        </div>
        <h1>Halo, {{ $invoice->patient->name }}</h1> <!-- Nama pasien dari relasi -->
        <p>Pemesanan <strong>Konsultasi Online</strong> Anda telah dikonfirmasi. Silakan cek detailnya di bawah ini.</p>
    </div>

    <div class="invoice-details">
        <div class="order-id">
            <p><strong>Kode Pesanan:</strong> {{ $invoice->code }}</p> <!-- Kode pesanan -->
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Tanggal Jatuh Tempo:</strong></p>
                <p>{{ $invoice->doctorConsultationReservation->agreed_consultation_date ?? 'N/A' }}</p> <!-- Tanggal konsultasi -->
            </div>
            <div class="col">
                <p><strong>Subjek:</strong></p>
                <p>Konsultasi Online</p>
            </div>
            <div class="col">
                <p><strong>Ditagihkan Kepada:</strong></p>
                <p>{{ $invoice->patient->name }}</p> <!-- Nama pasien -->
                <p>{{ $invoice->patient->user->email }}</p> <!-- Email pasien -->
            </div>
            <div class="col">
                <p><strong>Mata Uang:</strong></p>
                <p>IDR - Rupiah Indonesia</p>
            </div>
        </div>
    </div>
    <!-- Informasi Zoom -->
    @if($invoice->doctorConsultationReservation->zoom_link)
    <div class="important-info">
        <p><strong>Link Zoom Meeting:</strong> <a href="{{ $invoice->doctorConsultationReservation->zoom_link }}" target="_blank">{{ $invoice->doctorConsultationReservation->zoom_link }}</a></p>
    </div>
    <div class="important-info">
        <p><strong>ID Zoom Meeting:</strong> {{ $invoice->doctorConsultationReservation->zoom_password ?? 'N/A' }}</p>
    </div>
    @endif


    <!-- Section for Patient Details -->
    <h4 class="mb-4 mt-5" style="color: #023770;">Detail Pasien</h4>
    <div class="row mb-4">
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="patientName" class="form-label">Nama Pasien</label>
                <p class="form-text">{{ $invoice->patient->name }}</p> <!-- Nama pasien -->
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="phoneNumber" class="form-label">No. HP</label>
                <p class="form-text">{{ $invoice->patient->user->whatsapp ?? 'N/A' }}</p> <!-- WhatsApp pasien -->
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <p class="form-text">{{ $invoice->patient->user->email }}</p> <!-- Email pasien -->
            </div>
        </div>
    </div>

    <!-- Section for Booking Details -->
    <h4 class="mb-4 mt-5" style="color: #023770;">Detail Pemesanan</h4>
    <div class="row mb-4">
        <div class="col-sm-12 col-md-3">
            <div class="form-group">
                <label for="doctorName" class="form-label">Nama Dokter</label>
                <p class="form-text">{{ $invoice->doctorConsultationReservation->doctor->name }}</p> <!-- Nama dokter -->
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            <div class="form-group">
                <label for="specialist" class="form-label">Spesialisasi</label>
                <p class="form-text">{{ $invoice->doctorConsultationReservation->doctor->specialization_name }}</p> <!-- Spesialisasi dokter -->
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            <div class="form-group">
                <label for="polyclinic" class="form-label">Poliklinik</label>
                <p class="form-text">{{ $invoice->doctorConsultationReservation->doctor->polyclinic->name ?? 'N/A' }}</p> <!-- Nama poliklinik -->
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            <div class="form-group">
                <label for="consultationTime" class="form-label">Waktu Konsultasi</label>
                <p class="form-text">{{ $invoice->doctorConsultationReservation->agreed_consultation_time ?? 'N/A' }}</p> <!-- Waktu konsultasi -->
            </div>
        </div>
    </div>

    <!-- Invoice Summary -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Paket Konsultasi</td>
                <td>Rp. {{ number_format($invoice->doctorConsultationReservation->doctor->consultation_fee, 0, ',', '.') }}</td> <!-- Biaya konsultasi -->
            </tr>
            <tr>
                <td>Jumlah: 1</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Additional Details -->
    <div class="row mb-4 additional-details">
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label class="form-label">Tanggal Reservasi</label>
                <p class="form-text">{{ $invoice->created_at->format('d F Y, H:i') }}</p> <!-- Tanggal reservasi -->
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label class="form-label">Tanggal Pembayaran</label>
                <p class="form-text">{{ $invoice->paymentRecords->last()->payment_confirmation_date ?? 'N/A' }}</p> <!-- Tanggal pembayaran -->
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label class="form-label">Tanggal Pemesanan Berhasil</label>
                <p class="form-text">{{ $invoice->status->name == 'Selesai' ? $invoice->updated_at->format('d F Y, H:i') : 'N/A' }}</p> <!-- Tanggal pemesanan berhasil -->
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