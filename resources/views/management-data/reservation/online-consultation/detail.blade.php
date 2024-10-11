@extends('management-data.layouts.app')

@section('title', 'Konsultasi Online')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Konsultasi Online</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href=" ">Konsultasi Online</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Pemesanan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card p-4" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <h5 class="fw-bold" style="color: #1C3A6B;">Kode Pemesanan</h5>
            <h4 class="mb-4" style="color: #000;">{{ $reservation->code }}</h4>

            <div class="d-flex mb-4">
                <button class="btn btn-success me-2" style="border-radius: 6px; display: flex; align-items: center;">
                    <i class="fas fa-check-circle me-1"></i> Approve Order
                </button>
                <button class="btn btn-danger me-2" style="border-radius: 6px; display: flex; align-items: center;">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>
                <button class="btn btn-secondary" style="border-radius: 6px; display: flex; align-items: center;">
                    <i class="fas fa-trash me-1"></i> Delete Order
                </button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Pasien</strong><br> {{ $reservation->patient->name }}</p> <!-- Nama pasien dari tabel patients -->
                    <p><strong>No HP</strong><br> {{ $reservation->patient->user->whatsapp }}</p> <!-- No HP pasien dari tabel users -->
                    <p><strong>Email</strong><br> {{ $reservation->patient->user->email }}</p> <!-- Email pasien dari tabel users -->
                    <p><strong>Nama Dokter</strong><br> {{ $reservation->doctorConsultationReservation->doctor->name }}</p> <!-- Nama dokter dari tabel doctors -->
                    <p><strong>Spesialis</strong><br> {{ $reservation->doctorConsultationReservation->doctor->specialization_name }}</p> <!-- Spesialis dokter -->
                    <p><strong>Poliklinik</strong><br> {{ $reservation->doctorConsultationReservation->doctor->polyclinic->name ?? 'N/A' }}</p> <!-- Nama poliklinik dari tabel polyclinics -->
                </div>
                <div class="col-md-6">
                    <p><strong>Waktu Konsultasi</strong><br> {{ \Carbon\Carbon::parse($reservation->doctorConsultationReservation->preferred_consultation_date)->format('l, d F Y') }}</p> <!-- Format tanggal konsultasi -->
                    <p><strong>Bukti Pembayaran</strong><br>
                        @if ($reservation->paymentRecords->isNotEmpty())
                        <a href="{{ asset('storage/' . $reservation->paymentRecords->last()->payment_proof) }}" class="link-primary" target="_blank">Lihat Bukti Pembayaran</a>
                        @else
                        N/A
                        @endif
                    </p>
                    <p><strong>Biaya Konsultasi</strong><br> Rp. {{ number_format($reservation->doctorConsultationReservation->doctor->consultation_fee, 2) }}</p> <!-- Biaya konsultasi -->
                    <p><strong>Tanggal & Waktu Reservasi</strong><br> {{ $reservation->created_at->format('d F Y, H:i') }}</p> <!-- Tanggal reservasi -->
                    <p><strong>Tanggal & Waktu Pembayaran</strong><br>
                        @if ($reservation->paymentRecords->isNotEmpty() && $reservation->paymentRecords->last()->payment_confirmation_date)
                        {{ $reservation->paymentRecords->last()->payment_confirmation_date->format('d F Y, H:i') }}
                        @else
                        'Belum Dibayar'
                        @endif
                    </p> <!-- Tanggal pembayaran -->

                    <p><strong>Tanggal & Waktu Pemesanan Berhasil</strong><br> {{ $reservation->updated_at->format('d F Y, H:i') }}</p> <!-- Tanggal pemesanan berhasil -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    const mobileScreen = window.matchMedia("(max-width: 990px )");
    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this).closest(".dashboard-nav-dropdown")
                .toggleClass("show")
                .find(".dashboard-nav-dropdown")
                .removeClass("show");
            $(this).parent()
                .siblings()
                .removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (mobileScreen.matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });
</script>
@endpush