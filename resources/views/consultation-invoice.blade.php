@extends('landing-page.layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px;">

        <!-- Breadcrumb Section -->
        <div class="container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="/account">Profile</a></li>
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
                <h1>Hi John Doe,</h1>
                <p>Your order <strong>Consultation Package</strong> was confirmed. Check the details below.</p>
            </div>

            <div class="invoice-details">
                <div class="order-id">
                    <p><strong>Your Order</strong> INV-123456</p>
                </div>
                <div class="row">
                    <div class="col">
                        <p><strong>Due date:</strong></p>
                        <p>16 September 2024</p>
                    </div>
                    <div class="col">
                        <p><strong>Subject:</strong></p>
                        <p>Online Consultation</p>
                    </div>
                    <div class="col">
                        <p><strong>Billed to:</strong></p>
                        <p>John Doe</p>
                        <p>john.doe@email.com</p>
                    </div>
                    <div class="col">
                        <p><strong>Currency:</strong></p>
                        <p>IDR - Indonesian Rupiah</p>
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="important-info">
                <p><strong>Kode Pemesanan:</strong> INV-123456</p>
            </div>
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

            <!-- Patient Details -->
            <div class="form-group mb-4">
                <label for="patientName" class="form-label">Nama Pasien</label>
                <p class="form-text">John Doe</p>
            </div>

            <div class="form-group mb-4">
                <label for="phoneNumber" class="form-label">No. HP</label>
                <p class="form-text">0812-3456-7890</p>
            </div>

            <div class="form-group mb-4">
                <label for="email" class="form-label">Email</label>
                <p class="form-text">johndoe@example.com</p>
            </div>

            <div class="form-group mb-4">
                <label for="doctorName" class="form-label">Nama Dokter</label>
                <p class="form-text">Dr. Jane Smith</p>
            </div>

            <div class="form-group mb-4">
                <label for="specialist" class="form-label">Spesialis</label>
                <p class="form-text">Kardiologi</p>
            </div>

            <div class="form-group mb-4">
                <label for="polyclinic" class="form-label">Poliklinik</label>
                <p class="form-text">Poliklinik Jantung</p>
            </div>

            <div class="form-group mb-4">
                <label for="consultationTime" class="form-label">Waktu Konsultasi</label>
                <p class="form-text">Senin, 17:00 WIB</p>
            </div>


            <!-- Additional Details -->
            <div class="form-group mb-4">
                <label class="form-label">Tanggal dan Waktu Reservasi</label>
                <p class="form-text">15 September 2024, 14:00 WIB</p>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Tanggal dan Waktu Pembayaran</label>
                <p class="form-text">15 September 2024, 15:30 WIB</p>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Tanggal dan Waktu Konfirmasi</label>
                <p class="form-text">16 September 2024, 09:00 WIB</p>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Tanggal dan Waktu Pemesanan Berhasil</label>
                <p class="form-text">16 September 2024, 09:00 WIB</p>
            </div>

            <!-- Invoice Summary -->
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Consultation Package</td>
                        <td>500.000 IDR</td>
                    </tr>
                    <tr>
                        <td>Qty: 1</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <div class="invoice-summary">
                <div class="row">
                    <div class="col">
                        <p><strong>Subtotal:</strong> 500.000 IDR</p>
                    </div>
                    <div class="col">
                        <p><strong>Discount:</strong> -50.000 IDR</p>
                    </div>
                    <div class="col">
                        <p><strong>Total:</strong> 450.000 IDR</p>
                    </div>
                    <div class="col">
                        <p><strong>Amount due:</strong> 450.000 IDR</p>
                    </div>
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
