@extends('landing-page.layouts.app')

@section('content')
<!-- Breadcrumb Section -->
<div class="container" style="margin-top: 110px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
            <li class="breadcrumb-item"><a href="/account">Profil</a></li>
            <li class="breadcrumb-item"><a href="/account?tab=riwayat">Riwayat Pesanan</a></li>
            <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Detail Pesanan</li>
        </ol>
    </nav>
</div>

<!-- Consultation Detail Section -->
<div class="container mt-5 mb-5 consultation-detail-section">
    <div class="card consultation-detail-card">
        <div class="card-header d-flex justify-content-between align-items-center consultation-card-header">
            <h4>Detail Pesanan</h4>
            <span class="badge badge-info" style="font-size: 1.2rem; padding: 8px 14px; border-radius: 12px;">{{ $reservation->code }}</span>
        </div>
        <div class="card-body consultation-card-body">
            <!-- Informasi Konsultasi Section -->
            <h5 class="card-title consultation-section-title">Informasi Konsultasi</h5>
            <div class="row mb-3">
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Nama Pasien:</strong> {{ $reservation->patient->name }}</p>
                </div>
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Email Pasien:</strong> {{ $reservation->patient->user->email }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Tanggal Konsultasi:</strong> {{ $reservation->agreed_consultation_date }}</p> <!-- Mengambil dari kolom agreed_consultation_date -->
                </div>
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Waktu Konsultasi:</strong> {{ $reservation->agreed_consultation_time }}</p> <!-- Mengambil dari kolom agreed_consultation_time -->
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Dokter:</strong> {{ $reservation->doctorConsultationReservation->doctor->name }}</p>
                </div>
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Spesialisasi:</strong> {{ $reservation->doctorConsultationReservation->doctor->specialization_name }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Status Pemesanan:</strong>
                        <span class="badge {{ $reservation->status->class }}">{{ $reservation->status->name }}</span>
                    </p>
                </div>
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Total Biaya:</strong> Rp. {{ number_format($reservation->doctorConsultationReservation->doctor->consultation_fee, 0, ',', '.') }}</p>
                </div>
            </div>
            <hr>

            <!-- Detail Pembayaran Section -->
            <h5 class="card-title consultation-section-title">Detail Pembayaran</h5>
            <div class="row mb-3">
                <div class="col-md-6 consultation-payment-info">
                    <p><strong>Metode Pembayaran:</strong> {{ $reservation->paymentRecords->first()->payment_method ?? 'Belum Dipilih' }}</p>

                </div>
                <div class="col-md-6 consultation-payment-info">
                    <p><strong>Status Pembayaran:</strong>
                        <span class="badge {{ $reservation->status_pembayaran == 'Lunas' ? 'badge-success' : 'badge-warning' }}">
                            {{ $reservation->status_pembayaran == 'Lunas' ? 'Lunas' : 'Belum Dibayar' }} <!-- Mengambil dari kolom status_pembayaran -->
                        </span>
                    </p>
                </div>
            </div>

            <!-- Button Section -->
            <div class="mt-4 consultation-button-section">
                @if($reservation->status_pembayaran == 'Menunggu Pembayaran' && $reservation->reservation_status_id == 1)
                <a href="{{ route('consultation.confirmation', $reservation->id) }}" class="btn consultation-payment-button" style="background-color: #0d7c5d; color:white">Konfirmasi Pembayaran</a>
                @elseif($reservation->status_pembayaran == 'Lunas' && $reservation->reservation_status_id == 1)
                <a href="{{ route('consultation.invoice', $reservation->id) }}" class="btn consultation-invoice-button" style="background-color: #adb5bd; color:white">Lihat Invoice</a>
                @elseif($reservation->status_pembayaran == 'Lunas' && $reservation->reservation_status_id == 2)
                <a href="{{ route('consultation.invoice', $reservation->id) }}" class="btn consultation-invoice-button" style="background-color: #adb5bd; color:white">Lihat Invoice</a>
                @endif
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