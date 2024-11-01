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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
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
            <div class="card-form">
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

@push('scripts')
<script>
    // Simpan jumlah reservasi awal
    let previousCount = "{{ $reservations->count() }}";

    // Fungsi untuk mengecek apakah ada reservasi baru
    function checkNewReservations() {
        $.get("{{ route('reservation.count') }}", function(data) {
            // Jika ada reservasi baru
            if (data.count > previousCount) {
                alert('Ada reservasi baru!');
                // Update jumlah reservasi
                previousCount = data.count;
            }
        });
    }

    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#dataTableKonsultasi').DataTable({
            paging: true,
            lengthMenu: [5, 10, 25, 50],
            ordering: true,
            searching: true,
            info: true,
            autoWidth: false,
            order: [
                [1, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [7, 9]
            }],
            language: {
                paginate: {
                    previous: "Sebelumnya",
                    next: "Selanjutnya"
                },
                lengthMenu: "Tampilkan _MENU_ entri",
                search: "Cari:",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Tidak ada data tersedia",
                zeroRecords: "Tidak ada hasil ditemukan",
            },
        });

        // Panggil fungsi cek reservasi baru setiap 3 menit (180000 ms)
        setInterval(function() {
            checkNewReservations(); // Cek reservasi baru
            location.reload(); // Refresh halaman setiap 3 menit
        }, 180000); // 180000 ms = 3 menit

        // Cek reservasi baru setelah halaman dimuat
        checkNewReservations();
    });
</script>
@endpush