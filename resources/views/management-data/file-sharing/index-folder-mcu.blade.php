@extends('management-data.layouts.app')

@section('content')
    <div class='dashboard-app'>
        <header class='dashboard-toolbar'>
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        </header>
        <div class='dashboard-content'>
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">MCU 2025 03 11</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="/sharing-master">File Sharing</a></li>
                                <li class="breadcrumb-item"><a href="/folder-sharing">Data Instansi</a></li>
                                <li class="breadcrumb-item"><a href="/company-folder">Trakindo</a></li>
                                <li class="breadcrumb-item" style="color: #023770">MCU 2025 03 11</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Flash Message -->
            <div class="alert alert-success" style="display: none;">
                Berhasil menghapus file!
            </div>

            <!-- Folder & File List -->
            <div class="card"
                style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
                <div class="card-form">
                    <div class="d-flex justify-content-between mb-3">
                        <!-- Filter Tanggal -->
                        <div class="d-flex align-items-center">
                            <label for="filterTanggal" class="me-2">Filter Tanggal:</label>
                            <input type="date" id="filterTanggal" class="form-control form-control-sm">
                        </div>
                    
                        <!-- Search Box -->
                        <div class="d-flex align-items-center">
                            <label for="searchFolder" class="me-2">Cari Folder:</label>
                            <input type="text" id="searchFolder" class="form-control form-control-sm" placeholder="Cari folder...">
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <h4 class="card-title" style="color: #1C3A6B"><b>Daftar Pasien</b></h4>
                        <div class="ms-auto">
                            <button class="btn btn-md"
                                style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <p class="card-text">Berikut merupakan daftar folder dan file MCU.</p>
                    </div>

                    <!-- Dummy Folder List -->
                    <div class="list-group mb-3">
                        <a href="/patient-file" class="list-group-item list-group-item-action">
                            <i class="fas fa-folder text-warning"></i> Jayandra Kevin Tn
                        </a>
                        <a href="/patient-file" class="list-group-item list-group-item-action">
                            <i class="fas fa-folder text-warning"></i> Sharoon Pelita Ny
                        </a>
                        <a href="/patient-file" class="list-group-item list-group-item-action">
                            <i class="fas fa-folder text-warning"></i> Arsean Jeffrey An
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    alert('File berhasil dihapus! (Dummy action)');
                });
            });
        });
    </script>
@endsection
