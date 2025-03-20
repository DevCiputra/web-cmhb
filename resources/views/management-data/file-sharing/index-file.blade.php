@extends('management-data.layouts.app')

@section('content')
<div class="dashboard-app">
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class="dashboard-content">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">File Pasien: Jayandra Kevin Tn</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/mcu-sharing">Data Instansi</a></li>
                            <li class="breadcrumb-item"><a href="/company-folder">Trakindo</a></li>
                            <li class="breadcrumb-item"><a href="/mcu-folder">MCU 2025 03 11</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Jayandra Kevin Tn</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Grid Container -->
        <div class="row">
            @php
                // Dummy data file pasien
                $dummyFiles = [
                    ['name' => 'MCU_Jayandra_11-03-2025.pdf', 'path' => '#'],
                    ['name' => 'Lab_Report_11-03-2025.pdf', 'path' => '#'],
                    ['name' => 'Xray_Result_11-03-2025.pdf', 'path' => '#'],
                ];
            @endphp

            @foreach($dummyFiles as $file)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card shadow-sm border-0 p-3" style="border-radius: 14px;">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('icons/pdf-icon.png') }}" alt="PDF Icon" width="70" class="me-3">
                        <div class="flex-grow-1">
                            <h6 class="text-truncate mb-1" style="max-width: 200px;" title="{{ $file['name'] }}">
                                {{ $file['name'] }}
                            </h6>
                            <a href="{{ $file['path'] }}" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-download me-1"></i> Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
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