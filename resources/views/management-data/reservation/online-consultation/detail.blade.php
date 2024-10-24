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
                            <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="#">Konsultasi Online</a></li>
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

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <div class="card p-4" style="box-shadow: 4px 4px 24px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <h5 class="fw-bold" style="color: #1C3A6B;">Kode Pemesanan</h5>
            <h4 class="mb-4" style="color: #000;">{{ $reservation->code }}</h4>

            <div class="d-flex mb-4">
                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                    <i class="fas fa-check-circle me-1"></i> Approve Order
                </button>
                <!-- Ubah ini -->
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>

                <!-- Tombol Delete dengan Form -->
                <form action="{{ route('reservation.delete', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Yakin ingin menghapus reservasi ini?')">
                        <i class="fas fa-trash me-1"></i> Delete Order
                    </button>
                </form>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Pasien:</strong> {{ $reservation->patient->name }}</p>
                    <p><strong>No HP:</strong> {{ $reservation->patient->user->whatsapp }}</p>
                    <p><strong>Email:</strong> {{ $reservation->patient->user->email }}</p>
                    <p><strong>Nama Dokter:</strong> {{ $reservation->doctorConsultationReservation->doctor->name }}</p>
                    <p><strong>Spesialis:</strong> {{ $reservation->doctorConsultationReservation->doctor->specialization_name }}</p>
                    <p><strong>Poliklinik:</strong> {{ $reservation->doctorConsultationReservation->doctor->polyclinic->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Waktu Konsultasi:</strong>
                        @if ($reservation->doctorConsultationReservation->agreed_consultation_time)
                        {{-- Jika agreed_consultation_time tidak kosong, tampilkan agreed --}}
                        {{ \Carbon\Carbon::parse($reservation->doctorConsultationReservation->agreed_consultation_time)->format('d F Y, H:i') }}
                        @else
                        {{-- Jika agreed_consultation_time kosong, tampilkan preferred --}}
                        {{ \Carbon\Carbon::parse($reservation->doctorConsultationReservation->preferred_consultation_date)->format('d F Y, H:i') }}
                        @endif
                    </p>

                    <p><strong>Bukti Pembayaran:</strong>
                        @if ($reservation->paymentRecords->isNotEmpty())
                        <a href="{{ asset('storage/' . $reservation->paymentRecords->last()->payment_proof) }}" target="_blank">Lihat Bukti Pembayaran</a>
                        @else
                        N/A
                        @endif
                    </p>
                    <p><strong>Biaya Konsultasi:</strong> Rp {{ number_format($reservation->doctorConsultationReservation->doctor->consultation_fee, 2) }}</p>
                    <p><strong>Tanggal Reservasi:</strong> {{ $reservation->created_at->format('d F Y, H:i') }}</p>
                    <p><strong>Status Pembayaran:</strong>
                        @if ($reservation->paymentRecords->last()?->payment_confirmation_date)
                        {{ $reservation->paymentRecords->last()->payment_confirmation_date }}
                        @else
                        Belum Dibayar
                        @endif
                    </p>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold" style="color: #1C3A6B;">Informasi Zoom Meeting</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Link Zoom (Pasien):</strong><br>
                        @if ($reservation->doctorConsultationReservation->zoom_link)
                        <a href="{{ $reservation->doctorConsultationReservation->zoom_link }}" target="_blank" class="link-primary">Gabung Zoom</a>
                        @else
                        Belum Tersedia
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Link Zoom (Dokter):</strong><br>
                        @if ($reservation->doctorConsultationReservation->zoom_host_link)
                        <a href="{{ $reservation->doctorConsultationReservation->zoom_host_link }}" target="_blank" class="link-primary">Masuk sebagai Host</a>
                        @else
                        Belum Tersedia
                        @endif
                    </p>
                    <p><strong>Password Meeting:</strong>
                        {{ $reservation->doctorConsultationReservation->zoom_password ?? 'Tidak Ada' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve Order -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('reservation.approve', $reservation->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Konsultasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agreedDate" class="form-label">Tanggal Disepakati</label>
                        <input type="date" class="form-control" id="agreedDate" name="agreed_consultation_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="agreedTime" class="form-label">Waktu Disepakati</label>
                        <input type="time" class="form-control" id="agreedTime" name="agreed_consultation_time" required>
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

<!-- Modal Cancel Order -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('reservation.cancel', $reservation->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderModalLabel">Pembatalan Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cancellationReason" class="form-label">Alasan Pembatalan</label>
                        <textarea class="form-control" id="cancellationReason" name="cancellation_reason" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="authorizationPassword" class="form-label">Password Otorisasi</label>
                        <input type="password" class="form-control" id="authorizationPassword" name="authorization_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cancel Order -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('reservation.cancel', $reservation->id) }}">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderModalLabel">Pembatalan Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cancellationReason" class="form-label">Alasan Pembatalan</label>
                        <textarea class="form-control @error('cancellation_reason') is-invalid @enderror"
                            id="cancellationReason" name="cancellation_reason" rows="3">{{ old('cancellation_reason') }}</textarea>
                        @error('cancellation_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="authorizationPassword" class="form-label">Password Otorisasi</label>
                        <input type="password" class="form-control @error('authorization_password') is-invalid @enderror"
                            id="authorizationPassword" name="authorization_password">
                        @error('authorization_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
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