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
                <!-- Tombol Approve Order -->
                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                    <i class="fas fa-check-circle me-1"></i> Approve Order
                </button>
                <form action="{{ route('reservation.cancel', $reservation->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger me-2">
                        <i class="fas fa-times-circle me-1"></i> Cancel Order
                    </button>
                </form>
                
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
                    <p><strong>Waktu Konsultasi</strong><br> {{ \Carbon\Carbon::parse($reservation->doctorConsultationReservation->preferred_consultation_date) }}</p> <!-- Format tanggal konsultasi -->
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
                        {{ $reservation->paymentRecords->last()->payment_confirmation_date}}
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

<!-- Modal untuk Approve Reservation -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="approveForm" method="POST" action="{{ route('reservation.approve', $reservation->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Konsultasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agreedDate" class="form-label">Tanggal Konsultasi yang Disepakati</label>
                        <input type="text" class="form-control" id="agreedDate" name="agreed_consultation_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="agreedTime" class="form-label">Waktu Konsultasi yang Disepakati</label>
                        <input type="text" class="form-control" id="agreedTime" name="agreed_consultation_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

<script>
    // Inisialisasi flatpickr untuk input waktu dengan format 24 jam
    flatpickr("#agreedTime", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // Format 24 jam
        time_24hr: true, // Aktifkan 24 jam
    });

    flatpickr("#agreedDate", {
        dateFormat: "Y-m-d", // Format tanggal (ISO)
    });
</script>
@endpush