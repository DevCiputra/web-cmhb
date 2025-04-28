@extends('management-data.layouts.app')

@section('content')
<div class="dashboard-app">
    <header class="dashboard-toolbar">
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class="dashboard-content">
        <div class="card-header">
            <div class="d-flex flex-column">
                <h4 class="fw-normal" style="color:#1C3A6B;">File Sharing</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('file-sharing.index') }}">File Sharing</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#023770">{{ $folder->name }}</li>
                    </ol>
                </nav>
                {{-- tombol khusus MCU hanya untuk folder HBD --}}
                @if($folder->name === 'HBD')
                <div class="mt-2">
                    <a href="{{ route('mcu.index') }}"
                        class="btn btn-sm btn-success">
                        <i class="fas fa-file-medical-alt me-1"></i> MCU File Sharing
                    </a>
                </div>
                @endif
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card" style="box-shadow:4px 4px 24px rgba(0,0,0,0.04);border:none;border-radius:12px;min-height:95vh;">
            <div class="card-form">
                <h4 class="card-title mb-3" style="color:#1C3A6B;"><b>Sub‑Folder of “{{ $folder->name }}”</b></h4>
                <p class="card-text mb-4">Berikut adalah daftar sub‑folder dalam folder ini.</p>

                <div class="row row-cols-2 row-cols-md-4 g-3">
                    @if($subFolders->isEmpty())
                    <div class="col">
                        <p class="text-muted">Tidak ada sub‑folder.</p>
                    </div>
                    @else
                    @foreach($subFolders as $sf)
                    <div class="col position-relative">
                        <a href="{{ route('file-sharing.folder.show', $sf->name) }}"
                            class="folder-card text-decoration-none text-center position-relative"
                            style="background-color:#f5f2dc;">
                            <div class="folder-icon">
                                <i class="fas fa-folder fa-3x text-warning"></i>
                            </div>
                            <p class="folder-name mt-2">{{ $sf->name }}</p>
                        </a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush