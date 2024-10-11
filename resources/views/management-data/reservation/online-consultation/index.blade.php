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
                <!-- Left Side: Text -->
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Konsultasi Online</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Konsultasi Online</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Display flash messages -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- DataTable Card for Konsultasi Online -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-body">
                <!-- Title and Add Button -->
                <div class="d-flex mb-3">
                    <h4 style="color: #1C3A6B"><b>Data Reservasi Konsultasi Online</b></h4>
                </div>

                <!-- Description -->
                <div class="d-flex mb-4">
                    <p class="card-text">Berikut merupakan tabel data Konsultasi Online.</p>
                </div>

                <!-- Data Table -->
                <div style="max-height: 550px; overflow-y: auto; width: 100%;">
                    <table class="table table-bordered" id="dataTableKonsultasi"
                        style="width: 100%; border-top: 1px solid grey;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Order ID</th>
                                <th>Nama Pasien</th>
                                <th>No. Hp</th>
                                <th>Nama Dokter</th>
                                <th>Spesialis</th>
                                <th>Waktu Konsul</th>
                                <th>Bukti Pembayaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $index => $reservation)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $reservation->code }}</td>
                                <td>{{ $reservation->patient->name }}</td>
                                <td>{{ $reservation->patient->user->whatsapp }}</td> <!-- Pastikan kolom ini ada di model Patient -->
                                <td>{{ $reservation->doctorConsultationReservation->doctor->name }}</td> <!-- Ganti dengan nama dokter sesuai data -->
                                <td>{{ $reservation->doctorConsultationReservation->doctor->specialization_name }}</td> <!-- Ganti dengan spesialisasi sesuai data -->
                                <td>{{ $reservation->doctorConsultationReservation->preferred_consultation_date }}</td> <!-- Format tanggal -->
                                <td>
                                    @if ($reservation->paymentRecords->isNotEmpty() && $reservation->paymentRecords->last()->payment_proof)
                                    <a href="{{ asset('storage/' . $reservation->paymentRecords->last()->payment_proof) }}" target="_blank">Lihat Bukti Pembayaran</a>
                                    @else
                                    N/A
                                    @endif
                                </td>

                                <td>
                                    <span class="status-badge badge
                @if ($reservation->status_pembayaran == 'Menunggu Pembayaran' && $reservation->reservation_status_id == 1)
                    badge-warning
                @elseif ($reservation->status_pembayaran == 'Lunas' && $reservation->reservation_status_id == 1)
                    {{ $reservation->status->class ?? 'badge-secondary' }}
                @elseif ($reservation->status_pembayaran == 'Lunas' && $reservation->reservation_status_id == 2)
                    {{ $reservation->status->class ?? 'badge-success' }}
                @else
                    badge-secondary
                @endif"
                                        style="color: black;">
                                        @if ($reservation->status_pembayaran == 'Menunggu Pembayaran' && $reservation->reservation_status_id == 1)
                                        Menunggu Pembayaran
                                        @elseif ($reservation->status_pembayaran == 'Lunas' && $reservation->reservation_status_id == 1)
                                        {{ $reservation->status->name }}
                                        @elseif ($reservation->status_pembayaran == 'Lunas' && $reservation->reservation_status_id == 2)
                                        {{ $reservation->status->name }}
                                        @else
                                        Status Tidak Diketahui
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('reservation.onlineconsultation.detail', $reservation->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <!-- Tambahkan action button lain sesuai kebutuhan -->
                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
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