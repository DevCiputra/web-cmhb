@extends('management-data.layouts.app')

@section('title', 'Dokter')

@section('content')
<div class="dashboard-app">
    <header class="dashboard-toolbar">
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>

    <div class="dashboard-content">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Dokter</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('doctor.data.index') }}" method="GET" class="d-flex align-items-center">
                        <input type="text" class="form-control" name="query" placeholder="Cari Dokter" style="max-width: 200px;" value="{{ request('query') }}">
                        <button type="submit" class="btn btn-primary ms-2">Cari</button>
                    </form>
                    <select class="form-select" id="specializationFilter">
                        <option selected>Pilih Spesialis</option>
                        @foreach ($specializations as $specialization)
                        <option value="{{ $specialization }}">{{ $specialization }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('doctor.data.create') }}" style="text-decoration: none;">
                        <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px; border: none;">
                            <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                            Tambah
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="row cards-container">
            @foreach ($doctors as $doctor)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top"
                        src="{{ asset('storage/doctor/photos/' . $doctor->id . '/' . ($doctor->photos->first()->name ?? 'dokter_placeholder.jpg')) }}"
                        alt="{{ $doctor->name }}">

                    <div class="card-body">
                        <div class="header-container d-flex justify-content-between">
                            <h5 class="title">{{ $doctor->name }}</h5>
                            <div class="icon-group">
                                <a href="{{ route('doctor.data.edit', $doctor->id) }}" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit" class="pencil-icon">
                                </a>
                                <a href="{{ route('doctor.data.show', $doctor->id) }}" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="View" class="eye-icon">
                                </a>
                                <form action="{{ route('doctor.data.destroy', $doctor->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="Delete" class="trash-icon">
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="specialist">{{ $doctor->specialization_name }}</p>
                        <p class="polyclinic">Poliklinik: {{ $doctor->polyclinic->name ?? 'N/A' }}</p>
                        <p class="education">Pendidikan: {{ $doctor->education->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
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