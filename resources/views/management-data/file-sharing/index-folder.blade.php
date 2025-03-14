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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Trakindo</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item">
                                <a href="/mcu-sharing" style="text-decoration: none;">Data Instansi</a>
                            </li>
                            
                            <li class="breadcrumb-item" style="color: #023770">Trakindo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Display flash messages -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- DataTable Card -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="d-flex mb-3">
                    <h4 class="card-title" style="color: #1C3A6B"><b>Folder Instansi</b></h4>
                    <div class="ms-auto">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addFolderModal"
                        style="text-decoration: none;">
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
                    <p class="card-text">Berikut merupakan tabel data Instansi yang terdaftar pada MCU.</p>
                </div>
                <div style="max-height: 550px; overflow-y: auto; width: 100%;">
                    <table class="table table-bordered" id="dataTableCompany" style="width: 100%; border-top: 1px solid grey;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Folder</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1100</td>
                                <td>
                                    <a href="/mcu-folder" style="text-decoration: none; color: inherit;">
                                        MCU 2025 03 11
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editFolderModal">Edit</a>
                                    <a href="/mcu-folder" class="btn btn-sm btn-secondary">Lihat</a>
                                    <form action="/" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md" style="background-color: #dc3545; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>1200</td>
                                <td>MCU 2025 03 12</td>
                                <td>
                                    <a href="/" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="/mcu-folder" class="btn btn-sm btn-secondary">Lihat</a>
                                    <form action="/" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md" style="background-color: #dc3545; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
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

    <!-- Tambah Modal -->
    <div class="modal fade" id="addFolderModal" tabindex="-1" aria-labelledby="addFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header"
                    style="background-color: #1C3A6B; color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title" id="addFolderModalLabel">Tambah Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="filter: invert(1);"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_folder" class="form-label fw-bold">Nama Folder</label>
                            <input type="text" class="form-control" id="nama_folder" name="nama_folder"
                                placeholder="Masukkan nama folder" required>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn"
                                style="background-color: #007858; border-color: #007858; border-radius: 8px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editFolderModal" tabindex="-1" aria-labelledby="editFolderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header"
                    style="background-color: #1C3A6B; color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title" id="editFolderModalLabel">Edit Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="filter: invert(1);"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3">
                            <label for="edit_nama_folder" class="form-label fw-bold">Nama Folder</label>
                            <input type="text" class="form-control" id="edit_nama_folder" name="nama_folder"
                                required>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn"
                                style="background-color: #007858; border-color: #007858; border-radius: 8px;">Simpan
                                Perubahan</button>
                        </div>
                    </form>
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