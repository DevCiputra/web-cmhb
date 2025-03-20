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
                        <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Instansi</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                                <li class="breadcrumb-item" style="color: #023770">Data Instansi</li>
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

            <div class="card"
                style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; min-height: 95vh;">
                <div class="card-form">
                    <div class="d-flex mb-3">
                        <h4 class="card-title" style="color: #1C3A6B"><b>Data Instansi</b></h4>
                        <div class="ms-auto">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addInstansiModal"
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
                        <p class="card-text">Berikut merupakan daftar instansi yang terdaftar pada MCU.</p>
                    </div>
                    <div class="row row-cols-2 row-cols-md-4 g-3">
                        <!-- Card Folder -->
                        <div class="col position-relative">
                            <a href="/company-folder" class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Trakindo</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col position-relative">
                            <a href="/company-folder" class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Astra</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col position-relative">
                            <a href="/company-folder" class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Trakindo</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col position-relative">
                            <a href="/company-folder"
                                class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Astra</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col position-relative">
                            <a href="/company-folder"
                                class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Trakindo</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col position-relative">
                            <a href="/company-folder"
                                class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Astra</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col position-relative">
                            <a href="/company-folder"
                                class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Trakindo</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col position-relative">
                            <a href="/company-folder"
                                class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Astra</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col position-relative">
                            <a href="/company-folder"
                                class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Trakindo</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col position-relative">
                            <a href="/company-folder"
                                class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Astra</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col position-relative">
                            <a href="/company-folder"
                                class="folder-card text-decoration-none text-center position-relative"
                                style="background-color: #f5f2dc">
                                <div class="folder-icon">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                </div>
                                <p class="folder-name mt-2">PT Trakindo</p>
                            </a>

                            <!-- Responsive Dropdown Button -->
                            <div class="dropdown position-absolute top-0 end-0 p-1 me-2">
                                <button class="btn btn-sm btn-light text-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item text-secondary edit-folder" data-bs-toggle="modal"
                                            data-bs-target="#editInstansiModal">
                                            <i class="fas fa-edit me-2"></i>Edit Folder
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-folder">
                                            <i class="fas fa-trash me-2"></i>Delete Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        
                        


                        <!-- Tambahkan lebih banyak card sesuai jumlah data -->
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Tambah Modal -->
    <div class="modal fade" id="addInstansiModal" tabindex="-1" aria-labelledby="addInstansiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header"
                    style="background-color: #1C3A6B; color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title" id="addInstansiModalLabel">Tambah Instansi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="filter: invert(1);"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_instansi" class="form-label fw-bold">Nama Instansi</label>
                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi"
                                placeholder="Masukkan nama instansi" required>
                        </div>
                        <div class="mb-3">
                            <label for="penanggung_jawab" class="form-label fw-bold">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab"
                                placeholder="Masukkan nama penanggung jawab" required>
                        </div>
                        <div class="mb-3">
                            <label for="file_instansi" class="form-label fw-bold">Upload File (XLS, CSV, dll.)</label>
                            <input type="file" class="form-control" id="file_instansi" name="file_instansi"
                                accept=".xls,.xlsx,.csv" required>
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
    <div class="modal fade" id="editInstansiModal" tabindex="-1" aria-labelledby="editInstansiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header"
                    style="background-color: #1C3A6B; color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title" id="editInstansiModalLabel">Edit Instansi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="filter: invert(1);"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3">
                            <label for="edit_nama_instansi" class="form-label fw-bold">Nama Instansi</label>
                            <input type="text" class="form-control" id="edit_nama_instansi" name="nama_instansi"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_penanggung_jawab" class="form-label fw-bold">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="edit_penanggung_jawab"
                                name="penanggung_jawab" required>
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

<style>
    td a {
        text-decoration: none;
        color: inherit;
        transition: color 0.3s ease;
    }

    td a:hover {
        color: #007858;
        /* Ganti dengan warna yang kamu inginkan */
        font-weight: bold;
    }
</style>

<style>
    .folder-card {
        display: block;
        padding: 16px;
        border-radius: 10px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .folder-card:hover {
        background-color: #e8e5c3 !important;
        /* Warna latar belakang lebih gelap saat hover */
        transform: translateY(-3px);
        /* Efek mengangkat sedikit */
    }

    .folder-card:hover .folder-icon i {
        color: #d4a017 !important;
        /* Warna ikon berubah saat hover */
    }

    .folder-actions {
        display: flex;
        gap: 4px;
        visibility: hidden;
    }

    .folder-card:hover+.folder-actions,
    .folder-actions:hover {
        visibility: visible;
    }

    .folder-actions button {
        border: none;
        padding: 4px;
        font-size: 14px;
        border-radius: 5px;
        transition: background 0.2s ease;
    }

    .folder-actions button:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }
</style>


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTableCompany').DataTable();
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
