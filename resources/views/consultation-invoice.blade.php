@extends('landing-page.layouts.app')

@section('content')
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/account">Profil</a></li>
                <li class="breadcrumb-item"><a href="/account">Riwayat Pemesanan</a></li>
                <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Invoice Pembayaran</li>
            </ol>
        </nav>
    </div>

    <div class="invoice-container">
        <div class="invoice-header text-center">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            </div>
            <h1>Halo, John Doe</h1>
            <p>Pemesanan <strong>Konsultasi Online</strong> Anda telah dikonfirmasi. Silakan cek detailnya di bawah ini.</p>
        </div>

        <div class="invoice-details">
            <div class="order-id">
                <p><strong>Kode Pesanan:</strong> INV-123456</p>
            </div>
            <div class="row">
                <div class="col">
                    <p><strong>Tanggal Jatuh Tempo:</strong></p>
                    <p>16 September 2024</p>
                </div>
                <div class="col">
                    <p><strong>Subjek:</strong></p>
                    <p>Konsultasi Online</p>
                </div>
                <div class="col">
                    <p><strong>Ditagihkan Kepada:</strong></p>
                    <p>John Doe</p>
                    <p>john.doe@email.com</p>
                </div>
                <div class="col">
                    <p><strong>Mata Uang:</strong></p>
                    <p>IDR - Rupiah Indonesia</p>
                </div>
            </div>
        </div>

        <!-- Informasi Penting -->
        <div class="important-info">
            <p><strong>Link Zoom Meeting:</strong> <a href="https://zoom.us/j/1234567890"
                    target="_blank">https://zoom.us/j/1234567890</a></p>
        </div>
        <div class="important-info">
            <p><strong>ID Zoom Meeting:</strong> 123 456 7890</p>
        </div>
        <div class="important-info">
            <p><strong>Password Zoom Meeting:</strong> abcdef</p>
        </div>

        <!-- Section for Patient Details -->
        <h4 class="mb-4 mt-5" style="color: #023770;">Detail Pasien</h4>
        <div class="row mb-4">
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label for="patientName" class="form-label">Nama Pasien</label>
                    <p class="form-text">John Doe</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label for="phoneNumber" class="form-label">No. HP</label>
                    <p class="form-text">0812-3456-7890</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <p class="form-text">johndoe@example.com</p>
                </div>
            </div>
        </div>

        <!-- Section for Booking Details -->
        <h4 class="mb-4 mt-5" style="color: #023770;">Detail Pemesanan</h4>
        <div class="row mb-4">
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <label for="doctorName" class="form-label">Nama Dokter</label>
                    <p class="form-text">dr. Jane Smith, Sp.JP.</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <label for="specialist" class="form-label">Spesialisasi</label>
                    <p class="form-text">Kardiologi</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <label for="polyclinic" class="form-label">Poliklinik</label>
                    <p class="form-text">Poliklinik Jantung</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <label for="consultationTime" class="form-label">Waktu Konsultasi</label>
                    <p class="form-text">Senin, 17:00 WIB</p>
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
                    <td>500.000 IDR</td>
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
                    <p class="form-text">15 September 2024, 14:00 WIB</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label class="form-label">Tanggal Pembayaran</label>
                    <p class="form-text">15 September 2024, 15:30 WIB</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label class="form-label">Tanggal Pemesanan Berhasil</label>
                    <p class="form-text">16 September 2024, 09:00 WIB</p>
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
