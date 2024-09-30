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
                                <li class="breadcrumb-item"><a href=" ">Konsultasi Online</a></li>
                                <li class="breadcrumb-item" style="color: #023770">Detail Pemesanan</li>
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

            <!-- Order Code Section -->
    <div class="card p-4" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
        <h5 class="fw-bold" style="color: #1C3A6B;">Kode Pemesanan</h5>
        <h4 class="mb-4" style="color: #000;">ASDFGHJIO89ZXC</h4>
        
        <!-- Action Buttons -->
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
        <!-- Patient and Order Information -->
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Pasien</strong><br> Jhon Doe</p>
                <p><strong>No HP</strong><br> 6289560003254</p>
                <p><strong>Email</strong><br> johndoe@mail.com</p>
                <p><strong>Nama Dokter</strong><br> dr. Jane Smith Sp.M</p>
                <p><strong>Spesialis</strong><br> Mata</p>
                <p><strong>Poliklinik</strong><br> Mata</p>
            </div>
            <div class="col-md-6">
                <p><strong>Waktu Konsultasi</strong><br> Jum'at, 09:00 AM</p>
                <p><strong>Bukti Pembayaran</strong><br><a href="#" class="link-primary">Bukti Pembayaran</a></p>
                <p><strong>Biaya Konsultasi</strong><br> Rp. 500.000,00</p>
                <p><strong>Tanggal & Waktu Reservasi</strong><br> 15 September 2024, 14:00 WITA</p>
                <p><strong>Tanggal & Waktu Pembayaran</strong><br> 15 September 2024, 15:30 WITA</p>
                {{-- <p><strong>Tanggal & Waktu Konfirmasi</strong><br> 15 September 2024, 15:34 WITA</p> --}}
                <p><strong>Tanggal & Waktu Pemesanan Berhasil</strong><br> 15 September 2024, 16:00 WITA</p>
            </div>
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
