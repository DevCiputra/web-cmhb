@extends('management-data.layouts.app')

{{-- @section('title', 'Data Patient') --}}

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
                        <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">MCU 2025 03 11</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                                <li class="breadcrumb-item">
                                    <a href="/mcu-sharing" style="text-decoration: none;">Data Instansi</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/company-folder" style="text-decoration: none;">Trakindo</a>
                                </li>
                                <li class="breadcrumb-item" style="color: #023770">MCU 2025 03 11</li>
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

            <!-- DataTable Card -->
            <div class="card"
                style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
                <div class="card-form">
                    <div class="d-flex mb-3">
                        <h4 class="card-title" style="color: #1C3A6B"><b>MCU Trakindo</b></h4>
                        <div class="ms-auto">
                            <a href="{{ route('role.data.create') }}" style="text-decoration: none;">
                                <button class="btn btn-md"
                                    style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                                    <img src="{{ asset('icons/plus.svg') }}" width="16" height="16"
                                        style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                    Tambah
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <p class="card-text">Berikut merupakan tabel data MCU.</p>
                    </div>
                    <div style="max-height: 550px; overflow-y: auto; width: 100%;">
                        <table class="table table-bordered" id="dataTableCompany"
                            style="width: 100%; border-top: 1px solid grey;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Pasien</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1100</td>
                                    <td><a href="/patient-file" style="text-decoration: none; color: inherit;">
                                            Jayandra Kevin Tn
                                        </a></td>
                                    <td>jaykev@mail.com</td>
                                    <td>
                                        <a href="/" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="/patient-file" class="btn btn-sm btn-secondary">Lihat</a>
                                        <form action="/" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-md"
                                                style="background-color: #dc3545; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1200</td>
                                    <td>Sharoon Pelita Nn</td>
                                    <td>shapelita@mail.com</td>
                                    <td>
                                        <a href="/" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="/patient-file" class="btn btn-sm btn-secondary">Lihat</a>
                                        <form action="/" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-md"
                                                style="background-color: #dc3545; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
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
        $(document).ready(function() {
            $('#dataTableComapany').DataTable();
        });
    </script>

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
