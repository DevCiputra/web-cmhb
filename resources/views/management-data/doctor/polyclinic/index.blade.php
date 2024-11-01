@extends('management-data.layouts.app')

@section('title', 'Daftar Poliklinik Dokter')

@section('content')
<div class="dashboard-app">
    <header class="dashboard-toolbar">
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>

    <div class="dashboard-content">
        <div class="card-header mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Daftar Poliklinik</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Daftar Poliklinik</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('doctor.polyclinic.create') }}" class="btn btn-md"
                    style="background-color: #007858; color: #fff; border-radius: 10px; text-decoration: none;">
                    Tambah Poliklinik
                </a>
            </div>
        </div>

        <div class="row">
            @foreach($polyclinics as $polyclinic)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $polyclinic->name }}</h5>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('doctor.polyclinic.edit', $polyclinic->id) }}" class="btn btn-edit">
                                <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit" class="pencil-icon">
                            </a>
                            <form action="{{ route('doctor.polyclinic.delete', $polyclinic->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus poliklinik ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
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