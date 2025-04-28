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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Instansi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('file-sharing.index') }}">File Sharing</a></li>
                            <li class="breadcrumb-item active" style="color: #023770">Data Instansi</li>
                        </ol>
                    </nav>
                </div>
                <div class="mb-3">
                    {{-- Tombol kembali ke sub-folder HBD --}}
                    <a href="{{ route('file-sharing.folder.show','HBD') }}"
                        class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Folder HBD
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card"
            style="box-shadow:4px 4px 24px rgba(0,0,0,0.04); border:none; border-radius:12px; min-height:95vh;">
            <div class="card-form p-4">
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <label for="filterTanggal" class="me-2">Filter Tanggal:</label>
                        <input type="date" id="filterTanggal" class="form-control form-control-sm">
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="searchFolder" class="me-2">Cari Folder:</label>
                        <input type="text" id="searchFolder" class="form-control form-control-sm" placeholder="Cari instansi...">
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <h4 class="card-title" style="color: #1C3A6B"><b>Data Instansi</b></h4>
                    <div class="ms-auto">
                        <!-- Download CSV Template -->
                        <a href="{{ route('mcu.template') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-download"></i> Download Template CSV
                        </a>
                        <!-- Tambah Instansi -->
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addInstansiModal">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </button>
                    </div>
                </div>

                <p class="card-text mb-4">Berikut merupakan daftar instansi yang terdaftar pada MCU.</p>

                <div class="row row-cols-2 row-cols-md-4 g-3">
                    @forelse($companies as $company)
                    <div class="col position-relative">
                        <a href="{{ route('mcu.company.show', $company->name) }}"
                            class="folder-card text-decoration-none text-center position-relative"
                            style="background-color: #f5f2dc">
                            <div class="folder-icon">
                                <i class="fas fa-folder fa-3x text-warning"></i>
                            </div>
                            <div class="mt-2">
                                <p class="folder-name mb-1">{{ $company->name }}</p>
                                <p class="text-muted small mb-0">{{ $company->package_name }}</p>
                            </div>
                        </a>
                        <div class="dropdown position-absolute top-0 end-0 p-1">
                            <button class="btn btn-sm btn-light text-secondary dropdown-toggle"
                                type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <button class="dropdown-item edit-folder"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editInstansiModal"
                                        data-id="{{ $company->id }}"
                                        data-name="{{ $company->name }}"
                                        data-resp="{{ $company->responsible_person }}"
                                        data-package="{{ $company->package_name }}">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </button>
                                </li>
                                <li>

                                </li>
                            </ul>
                        </div>
                    </div>
                    @empty
                    <div class="col">
                        <p class="text-muted">Belum ada instansi.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Instansi Modal --}}
<div class="modal fade" id="addInstansiModal" tabindex="-1" aria-labelledby="addInstansiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2 shadow-sm">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addInstansiModalLabel">Tambah Instansi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('mcu.company.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_instansi" class="form-label fw-bold">Nama Instansi</label>
                        <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" required>
                    </div>
                    <div class="mb-3">
                        <label for="penanggung_jawab" class="form-label fw-bold">Penanggung Jawab</label>
                        <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" required>
                    </div>
                    <div class="mb-3">
                        <label for="package_name" class="form-label fw-bold">Nama Paket MCU</label>
                        <input type="text" class="form-control" id="package_name" name="package_name" placeholder="Masukkan nama paket MCU" required>
                    </div>
                    <div class="mb-3">
                        <label for="file_instansi" class="form-label fw-bold">Upload File (CSV / XLS)</label>
                        <input type="file" class="form-control" id="file_instansi" name="file_instansi" accept=".csv,.xls,.xlsx" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Instansi Modal --}}
<div class="modal fade" id="editInstansiModal" tabindex="-1" aria-labelledby="editInstansiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2 shadow-sm">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editInstansiModalLabel">Edit Instansi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nama_instansi" class="form-label fw-bold">Nama Instansi</label>
                        <input type="text" class="form-control" id="edit_nama_instansi" name="nama_instansi" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_penanggung_jawab" class="form-label fw-bold">Penanggung Jawab</label>
                        <input type="text" class="form-control" id="edit_penanggung_jawab" name="penanggung_jawab" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_package_name" class="form-label fw-bold">Nama Paket MCU</label>
                        <input type="text" class="form-control" id="edit_package_name" name="package_name" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // DataTable (jika dibutuhkan)
    $(function() {
        $('#dataTableCompany').DataTable();
    });

    // Isi form Edit dengan data‐ attributes
    $(document).on('click', '.edit-folder', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let resp = $(this).data('resp');
        let package = $(this).data('package');
        $('#edit_id').val(id);
        $('#edit_nama_instansi').val(name);
        $('#edit_penanggung_jawab').val(resp);
        $('#edit_package_name').val(package);
        // set form action by slug name
        $('#editForm').attr('action', '/file-sharing/HBD/mcu-file-sharing/' + encodeURIComponent(name));
    });
</script>
@endpush