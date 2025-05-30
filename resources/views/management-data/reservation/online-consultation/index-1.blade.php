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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reservation.onlineconsultation.index') }}">Reservasi</a></li>
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
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="d-flex mb-3">
                    <h4 style="color: #1C3A6B"><b>Data Reservasi Konsultasi Online</b></h4>
                </div>

                <!-- Filter Status -->
                <div class="mb-3">
                    <label for="filterStatus" class="form-label">Filter Status</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Admin">Menunggu Admin</option>
                        <option value="Konfirmasi Jadwal">Konfirmasi Jadwal</option>
                        <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                        <option value="Menunggu Konfirmasi Pembayaran">Menunggu Konfirmasi Pembayaran</option>
                        <option value="Menunggu Approval Admin">Menunggu Approval Admin</option>
                        <option value="Pemesanan Berhasil">Pemesanan Berhasil</option>
                        <option value="Pemesanan Dibatalkan">Pemesanan Dibatalkan</option>
                        <option value="Status Tidak Diketahui">Status Tidak Diketahui</option>
                    </select>
                </div>

                <!-- Datepicker for filtering -->
                <div class="mb-3">
                    <label for="filterPreferredDate" class="form-label">Filter Tanggal Konsultasi Diajukan</label>
                    <input type="text" id="filterPreferredDate" class="form-control datepicker" placeholder="Pilih Tanggal">
                </div>
                <div class="mb-3">
                    <label for="filterAgreedDate" class="form-label">Filter Tanggal Konsultasi Disepakati</label>
                    <input type="text" id="filterAgreedDate" class="form-control datepicker" placeholder="Pilih Tanggal">
                </div>

                <!-- Description -->
                <div class="d-flex mb-4">
                    <p class="card-text">Berikut merupakan tabel data Konsultasi Online.</p>
                </div>

                <!-- Data Table -->
                <div style="max-height: 550px; overflow-y: auto; width: 100%;">
                    <table class="table table-bordered" id="dataTableKonsultasi" style="width: 100%; border-top: 1px solid grey;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Order ID</th>
                                <th>Nama Pasien</th>
                                <th>No. Hp</th>
                                <th>Nama Dokter</th>
                                <th>Spesialis</th>
                                <th>Waktu Konsul Diajukan</th>
                                <th>Waktu Konsul Disepakati</th>
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
                                <td>{{ $reservation->patient->user->whatsapp }}</td>
                                <td>{{ $reservation->doctorConsultationReservation->doctor->name }}</td>
                                <td>{{ $reservation->doctorConsultationReservation->doctor->specialization_name }}</td>
                                <td>{{ $reservation->doctorConsultationReservation->preferred_consultation_date }}</td>
                                <td>{{ $reservation->doctorConsultationReservation->agreed_consultation_date }}</td>
                                <td>
                                    @if ($reservation->paymentRecords->isNotEmpty() && $reservation->paymentRecords->last()->payment_proof)
                                    <a href="{{ asset('storage/' . $reservation->paymentRecords->last()->payment_proof) }}" target="_blank">Lihat Bukti Pembayaran</a>
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge badge
                                    @if (is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran))
                                    badge-secondary
                                    @elseif ($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran))
                                    badge-warning
                                    @elseif ($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran))
                                    badge-info
                                    @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi')
                                    badge-warning
                                    @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas')
                                    badge-info
                                    @elseif ($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas')
                                    badge-success
                                    @elseif ($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan')
                                    badge-danger
                                    @else
                                    badge-light
                                    @endif"
                                        style="color: white;
                                    @if (is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran))
                                    background-color: #6c757d; /* Secondary color */
                                    @elseif ($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran))
                                    background-color: #FFC107; /* Warning color */
                                    @elseif ($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran))
                                    background-color: #17a2b8; /* Info color */
                                    @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi')
                                    background-color: #FFC107; /* Warning color */
                                    @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas')
                                    background-color: #17a2b8; /* Info color */
                                    @elseif ($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas')
                                    background-color: #28A745; /* Success color */
                                    @elseif ($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan')
                                    background-color: #dc3545; /* Danger color */
                                    @else
                                    background-color: #F8F9FA; /* Light color */
                                    @endif">
                                        {{-- Menampilkan teks status berdasarkan kondisi --}}
                                        @if (is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran))
                                        Menunggu Admin
                                        @elseif ($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran))
                                        Konfirmasi Jadwal
                                        @elseif ($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran))
                                        Menunggu Pembayaran
                                        @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi')
                                        Menunggu Konfirmasi Pembayaran
                                        @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas')
                                        Menunggu Approval Admin
                                        @elseif ($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas')
                                        Pemesanan Berhasil
                                        @elseif ($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan')
                                        Pemesanan Dibatalkan
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

@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize the datepicker
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd" // Format to match your database date format
        });

        // Initialize DataTable
        var table = $('#dataTableKonsultasi').DataTable();

        // Filter by status
        $('#filterStatus').on('change', function() {
            var statusValue = $(this).val();
            table.column(9).search(statusValue).draw();
        });

        // Filter by preferred consultation date
        $('#filterPreferredDate').on('change', function() {
            var dateValue = $(this).val();
            // Apply filter
            table.column(6).search(dateValue).draw();
        });

        // Filter by agreed consultation date
        $('#filterAgreedDate').on('change', function() {
            var dateValue = $(this).val();
            // Apply filter
            table.column(7).search(dateValue).draw();
        });
    });
</script>
@endpush