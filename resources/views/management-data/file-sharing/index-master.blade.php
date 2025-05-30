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
                        <li class="breadcrumb-item active" style="color:#023770">File Sharing</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card" style="box-shadow:4px 4px 24px rgba(0,0,0,0.04);border:none;border-radius:12px;min-height:95vh;">
            <div class="card-form">
                <h4 class="card-title mb-3" style="color:#1C3A6B;"><b>Folder Master</b></h4>
                <p class="card-text mb-4">Berikut merupakan daftar folder File Sharing.</p>

                <div class="row row-cols-2 row-cols-md-4 g-3">
                    @if($rootFolders->isEmpty())
                    <div class="col">
                        <p>Tidak ada folder yang tersedia.</p>
                    </div>
                    @else
                    @foreach($rootFolders as $f)
                    <div class="col position-relative">
                        <a href="{{ route('file-sharing.folder.show', $f->name) }}"
                            class="folder-card text-decoration-none text-center position-relative"
                            style="background-color:#f5f2dc;">
                            <div class="folder-icon">
                                <i class="fas fa-folder fa-3x text-warning"></i>
                            </div>
                            <p class="folder-name mt-2">{{ $f->name }}</p>
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