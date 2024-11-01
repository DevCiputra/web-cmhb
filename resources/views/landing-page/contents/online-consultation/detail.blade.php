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
                <div>
                    <h4 class="mb-0">Detail Pesanan</h4>
                    <span class="reservation-code" style="font-weight: bold; background-color:#0d7c5d; color: white; border-radius: 30px; padding: 2px 8px; font-size: 0.9em;"> 
                        {{ $reservation->code }} 
                    </span>
                </div>
                
                <!-- Reservation Status Section -->
                <p class="mb-0 ms-3">
                    <strong>Status Pemesanan:</strong>
                    <span class="status-badge badge
                        @if (is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran)) badge-secondary
                        @elseif($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran)) badge-warning
                        @elseif($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran)) badge-info
                        @elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi') badge-warning
                        @elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas') badge-info
                        @elseif($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas') badge-success
                        @elseif($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan') badge-danger
                        @else badge-secondary @endif">
                        {{-- Menampilkan teks status berdasarkan kondisi --}}
                        @if (is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran))
                            Menunggu Admin
                        @elseif($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran))
                            Konfirmasi Jadwal
                        @elseif($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran))
                            Menunggu Pembayaran
                        @elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi')
                            Menunggu Konfirmasi Pembayaran
                        @elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas')
                            Menunggu Approval Admin
                        @elseif($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas')
                            Pemesanan Berhasil
                        @elseif($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan')
                            Pemesanan Dibatalkan
                        @else
                            Status Tidak Diketahui
                        @endif
                    </span>
                </p>
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
                        <p><strong>Tanggal Konsultasi Diajukan:</strong>
                            {{ \Carbon\Carbon::parse(
                                $reservation->doctorConsultationReservation->preferred_consultation_date,
                            )->translatedFormat('l, d-m-Y') }}
                        </p>
                    </div>
                    <div class="col-md-6 consultation-info-item">
                        <p><strong>Tanggal Konsultasi Disepakati:</strong>
                            @if ($reservation->doctorConsultationReservation->agreed_consultation_date)
                                {{ \Carbon\Carbon::parse(
                                    $reservation->doctorConsultationReservation->agreed_consultation_date,
                                )->translatedFormat('l, d-m-Y') }}
                            @else
                                <span>(Menunggu konfirmasi dokter)</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 consultation-info-item">
                        <p><strong>Dokter:</strong> {{ $reservation->doctorConsultationReservation->doctor->name }}</p>
                    </div>
                    <div class="col-md-6 consultation-info-item">
                        <p><strong>Spesialisasi:</strong>
                            {{ $reservation->doctorConsultationReservation->doctor->specialization_name }}</p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <!-- Payment Information Section -->
                    <div class="col-md-6 consultation-payment-info">
                        <h5 class="card-title consultation-section-title">Informasi Pembayaran</h5>
                        <p class="mb-3"><strong>Metode Pembayaran:</strong>
                            {{ $reservation->paymentRecords->first()->payment_method ?? 'Belum Dipilih' }}
                        </p>
                        <p class="mb-3"><strong>Bukti Pembayaran:</strong>
                            @if ($reservation->paymentRecords->isNotEmpty())
                                <a href="{{ asset('storage/' . $reservation->paymentRecords->last()->payment_proof) }}"
                                    target="_blank" style="color:#0d7c5d">
                                    Lihat Bukti Pembayaran
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <!-- Total Cost Section, aligned with Payment Information -->
                    <div class="col-md-6 consultation-info-item">
                        <p class="mb-3"><strong>Total Biaya:</strong> Rp.
                            {{ number_format($reservation->doctorConsultationReservation->doctor->consultation_fee, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <div>
                            <!-- Button Section -->
                            <div class="col-md-6 consultation-button-section mt-4">
                                @if (is_null($reservation->status_pembayaran) && $reservation->reservation_status_id == 2)
                                    <a href="{{ route('consultation.confirmation', $reservation->id) }}"
                                        class="btn consultation-payment-button"
                                        style="background-color: #0d7c5d; color:white">Konfirmasi Pembayaran</a>
                                @elseif($reservation->status_pembayaran === 'Lunas' && $reservation->reservation_status_id == 2)
                                    <a href="{{ route('consultation.invoice', $reservation->id) }}"
                                        class="btn consultation-invoice-button"
                                        style="background-color: #023770; color:white">Lihat Invoice</a>
                                @elseif($reservation->status_pembayaran === 'Lunas' && $reservation->reservation_status_id == 3)
                                    <a href="{{ route('consultation.invoice', $reservation->id) }}"
                                        class="btn consultation-invoice-button"
                                        style="background-color: #023770; color:white">Lihat Invoice</a>
                                @endif
                            </div>

                            </p>
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
