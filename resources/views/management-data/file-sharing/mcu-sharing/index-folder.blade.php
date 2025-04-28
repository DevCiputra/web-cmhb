@extends('management-data.layouts.app')

@section('content')
<div class="dashboard-app">
    <header class="dashboard-toolbar">
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class="dashboard-content">
        <div class="card-header mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-normal" style="color: #1C3A6B;">{{ $company->name }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('file-sharing.index') }}">File Sharing</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('mcu.index') }}">Data Instansi</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: #023770">
                                Folder Peserta
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card" style="box-shadow:4px 4px 24px rgba(0,0,0,0.04); border:none; border-radius:12px;">
            <div class="card-form p-3">
                <p class="card-text mb-3">
                    Berikut adalah daftar **folder peserta** MCU untuk instansi <strong>{{ $company->name }}</strong>.
                </p>

                <div class="list-group mb-3">
                    @php
                    // Hanya ambil folder_type = 'Patient'
                    $patientFolders = $company->folders->where('folder_type','Patient');
                    @endphp

                    @forelse($patientFolders as $folder)
                    <div class="list-group-item folder-item d-flex align-items-center justify-content-between">
                        <a
                            href="{{ route('mcu.view_folder', [
          'company' => $company->name,
          'patient' => $folder->name
      ]) }}"
                            class="folder-link flex-grow-1">
                            <i class="fas fa-folder text-warning me-2"></i>
                            {{ $folder->name }}
                        </a>
                        <div class="btn-group btn-group-sm">
                            <!-- Edit peserta (jika perlu) -->
                            <button class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#editMcuFolderModal"
                                data-folder-id="{{ $folder->id }}"
                                data-folder-name="{{ $folder->name }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Delete -->

                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-muted">
                        Belum ada folder peserta.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Isi form edit ketika tombol diklik
    document.querySelectorAll('[data-bs-target="#editMcuFolderModal"]').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.folderId;
            let name = this.dataset.folderName;
            document.getElementById('edit_folder_id').value = id;
            document.getElementById('edit_folder_name').value = name;
            document.getElementById('editMcuFolderForm').action = `/mcu/folder/${id}`;
        });
    });
</script>
@endpush

@endsection