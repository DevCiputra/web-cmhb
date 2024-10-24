@extends('management-data.layouts.app')

@section('title', 'Invoice')

@section('content')

    <div class='dashboard-app'>
        <!-- Toolbar -->
        <header class='dashboard-toolbar'>
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        </header>

        <!-- Dashboard Content -->
        <div class='dashboard-content'>

            <!-- Card Header Section -->
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <!-- Breadcrumbs and Title -->
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Konsultasi Online</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard-page') }}"
                                        style="text-decoration: none; color: #1C3A6B;">Beranda</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                                <li class="breadcrumb-item"><a href="#">Konsultasi Online</a></li>
                                <li class="breadcrumb-item"><a href="#">Detail Pemesanan</a></li>
                                <li class="breadcrumb-item active" style="color: #023770">Invoice</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Flash Message Section -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Invoice Content -->
            <div class="invoice-container" style="background-color: white; padding: 100px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">


                <!-- Invoice Header -->
                <div class="invoice-header text-center">
                    <div class="logo">
                        <img src="logo.png" alt="Logo" class="logo-img">
                    </div>
                    <h1>Hi John Doe,</h1>
                    <p>Your order <strong>Consultation Package</strong> was confirmed. Check the details below.</p>
                </div>

                <!-- Invoice Details -->
                <div class="invoice-details">
                    <div class="order-id">
                        <p><strong>Your Order</strong> INV-123456</p>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p><strong>Due date:</strong> 16 September 2024</p>
                        </div>
                        <div class="col">
                            <p><strong>Subject:</strong> Online Consultation</p>
                        </div>
                        <div class="col">
                            <p><strong>Billed to:</strong></p>
                            <p>John Doe</p>
                            <p>john.doe@email.com</p>
                        </div>
                        <div class="col">
                            <p><strong>Currency:</strong> IDR - Indonesian Rupiah</p>
                        </div>
                    </div>
                </div>

                <!-- Important Information -->
                <div class="important-info">
                    <p><strong>Kode Pemesanan:</strong> INV-123456</p>
                    <p><strong>Link Zoom Meeting:</strong> <a href="https://zoom.us/j/1234567890" target="_blank">https://zoom.us/j/1234567890</a></p>
                    <p><strong>ID Zoom Meeting:</strong> 123 456 7890</p>
                    <p><strong>Password Zoom Meeting:</strong> abcdef</p>
                </div>

                <!-- Patient Details Section -->
                <div class="patient-details mb-4">
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
                </div>

                <!-- Additional Information Section -->
                <div class="additional-details mb-4">
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
                </div>

                <!-- Invoice Summary Table -->
                <table class="invoice-table table table-striped">
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

                <!-- Invoice Summary -->
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

            </div> <!-- End of Invoice Container -->
        </div> <!-- End of Dashboard Content -->
    </div> <!-- End of Dashboard App -->

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Dropdown toggle for mobile
            $(".dashboard-nav-dropdown-toggle").click(function() {
                $(this).closest(".dashboard-nav-dropdown").toggleClass("show")
                    .find(".dashboard-nav-dropdown").removeClass("show");
                $(this).parent().siblings().removeClass("show");
            });

            // Menu toggle for mobile and desktop
            $(".menu-toggle").click(function() {
                if (window.matchMedia("(max-width: 990px)").matches) {
                    $(".dashboard-nav").toggleClass("mobile-show");
                } else {
                    $(".dashboard").toggleClass("dashboard-compact");
                }
            });
        });
    </script>
@endpush
