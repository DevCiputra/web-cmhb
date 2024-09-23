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
                        <h4 class="card-title" style="color: #1C3A6B"><b>Data Reservasi Konsultasi Online</b></h4>
                        <div class="ms-auto">
                            <a href="/tambah_konsultasi" style="text-decoration: none;">
                                <button class="btn btn-md"
                                    style="background-color: #007858; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                                    <img src="{{ asset('icons/plus.svg') }}" width="16" height="16"
                                        style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                    Tambah
                                </button>
                            </a>
                        </div>
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
                            <!-- Data will be loaded dynamically with AJAX -->
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
