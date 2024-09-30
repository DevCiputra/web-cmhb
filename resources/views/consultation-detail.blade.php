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
            <span class="badge badge-info" style="font-size: 1.2rem; padding: 8px 14px; border-radius: 12px;">INV-123456</span>
        </div>        
        <div class="card-body consultation-card-body">
            <!-- Informasi Konsultasi Section -->
            <h5 class="card-title consultation-section-title">Informasi Konsultasi</h5>
            <div class="row mb-3">
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Nama Pasien:</strong> Jhon Doe</p>
                </div>
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Email Pasien:</strong> john.doe@email.com</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Tanggal Konsultasi:</strong> Senin</p>
                </div>
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Waktu Konsultasi:</strong> 17:00 WITA</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Dokter:</strong> dr. Jane Smith, Sp.JP.</p>
                </div>
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Spesialisasi:</strong> Kardiologi</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Status Pemesanan:</strong> 
                        {{-- @if($booking->status == 'success')
                            <span class="badge badge-success">Berhasil</span>
                        @elseif($booking->status == 'pending')
                            <span class="badge badge-warning">Menunggu Pembayaran</span>
                        @elseif($booking->status == 'approved')
                            <span class="badge badge-info">Menunggu Approval</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="badge badge-danger">Cancelled</span>
                        @endif --}}
                    </p>
                </div>
                <div class="col-md-6 consultation-info-item">
                    <p><strong>Total Biaya:</strong> Rp. 500.000</p>
                </div>
            </div>
            <hr>
            
            <!-- Detail Pembayaran Section -->
            <h5 class="card-title consultation-section-title">Detail Pembayaran</h5>
            <div class="row mb-3">
                <div class="col-md-6 consultation-payment-info">
                    <p><strong>Metode Pembayaran:</strong> Bank Transfer</p>
                </div>
                <div class="col-md-6 consultation-payment-info">
                    <p><strong>Status Pembayaran:</strong> 
                        {{-- @if($booking->payment_status == 'paid')
                            <span class="badge badge-success">Lunas</span>
                        @else
                            <span class="badge badge-warning">Belum Dibayar</span>
                        @endif --}}
                    </p>
                </div>
            </div>

            <!-- Button Section -->
            <div class="mt-4 consultation-button-section">
                {{-- @if($booking->payment_status == 'pending') --}}
                    <a href="" class="btn consultation-payment-button" style="background-color: #0d7c5d; color:white">Konfirmasi Pembayaran</a>
                {{-- @elseif($booking->payment_status == 'paid') --}}
                    <a href="/consultation-invoice" class="btn consultation-invoice-button" style="background-color: #adb5bd; color:white" >Lihat Invoice</a>
                {{-- @endif --}}
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