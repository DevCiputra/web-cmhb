@extends('management-data.layouts.app')

@section('content')
<div class="dashboard-app">
    <header class="dashboard-toolbar">
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class="dashboard-content">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">
                        {{ $folder->name }}
                    </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard-page') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('file-sharing.index') }}">File Sharing</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('mcu.company.show', $company->name) }}">
                                    {{ $company->name }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" style="color: #023770">
                                {{ $folder->name }}
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
                    Berikut adalah daftar file MCU untuk peserta <strong>{{ $folder->name }}</strong>.
                </p>

                <div class="list-group mb-3">
                    @forelse($files as $file)
                    <a href="{{ route('mcu.download', $file->id) }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-file-pdf text-danger me-2"></i>
                            {{ $file->file_name }}
                        </span>
                        <i class="fas fa-download"></i>
                    </a>
                    @empty
                    <div class="list-group-item text-muted">
                        Belum ada file.
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection