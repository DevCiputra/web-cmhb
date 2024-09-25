@extends('management-data.layouts.app')

@section('title', 'Dokter')

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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Dokter</li>
                        </ol>
                    </nav>
                </div>

                <!-- Right Side: Controls -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Search Box -->
                    <input type="text" class="form-control" placeholder="Cari Dokter" style="max-width: 200px;">

                    <!-- Dropdown Category -->
                    <select class="form-select">
                        <option selected>Pilih Spesialis</option>
                        <!-- Loop untuk setiap spesialisasi dokter -->
                        @foreach ($specializations as $specialization)
                        <option value="{{ $specialization }}">{{ $specialization }}</option>
                        @endforeach
                    </select>

                    <!-- Add Button -->
                    <a href="{{ route('doctor.create') }}" style="text-decoration: none;">
                        <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                            <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                            Tambah
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Cards Container -->
        <div class="row cards-container">
            @foreach ($doctors as $doctor)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/dokter_placeholder.jpg') }}" alt="{{ $doctor->name }}">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">{{ $doctor->name }}</h5>
                            <div class="icon-group">
                                <a href="{{ route('doctor.edit', $doctor->id) }}" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit" class="pencil-icon">
                                </a>
                                <a href="{{ route('doctor.show', $doctor->id) }}" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="View" class="eye-icon">
                                </a>
                                <form action="{{ route('doctor.destroy', $doctor->id) }}" method="POST" style="display:inline-block;">
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
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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