@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item" style="color: #023770">Cari Dokter</li>
            </ol>
        </nav>
    </div>

    <div id="list-doctor" class="header-section">
        <div class="container-fluid">
            <h1 style="margin-bottom: 5px;">Cari Dokter</h1>
            <p style="margin-bottom: 15px;">Temukan Dokter Profesional di Ciputra Mitra Hospital.</p>

            <!-- Filter Card Section -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-filter mb-4">
                        <div class="filter-card-body">
                            <div class="row">
                                <!-- Search Bar -->
                                <div class="col-md-4 mb-2">
                                    <input type="text" class="form-control" placeholder="Cari dokter...">
                                </div>
                                <!-- Filter Dropdown for Polyclinic -->
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected>Pilih Poliklinik</option>
                                        <!-- Filter options -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected>Pilih Spesialis</option>
                                        <!-- Filter options -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor Cards Container -->
            <div class="doctor-cards-container">
                <div class="row">
                    @foreach ($doctors as $doctor)
                    <div class="col-md-3 mb-4">
                        <div class="doctor-card">
                            @php
                            $photoUrl = $doctor->photos->isNotEmpty()
                            ? asset('storage/doctor/photos/' . $doctor->id . '/' . $doctor->photos->first()->name)
                            : asset('images/default-doctor.jpg'); // Default image jika tidak ada foto
                            @endphp

                            <img class="doctor-card-img-top" src="{{ $photoUrl }}" alt="Doctor Image">
                            <div class="doctor-card-body">
                                <p class="polyclinic">{{ $doctor->polyclinic->name ?? 'N/A' }}</p>
                                <h5 class="name">{{ $doctor->name }}</h5>
                                <p class="specialist">{{ $doctor->specialization_name }}</p>
                                <a href="{{ route('doctor.show.landing', $doctor->id) }}">
                                    Lihat Profil
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right" class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Emergency Section -->
    <div id="emergency" class="emergency-fab">
        <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
            <a href="#" class="btn btn-success btn-lg mb-2 rounded-circle">
                <i class="fas fa-ambulance"></i>
            </a>
            <a href="#" class="btn btn-outline-success btn-lg rounded-circle mb-2">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
        <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()">
            <i class="fa-solid fa-phone"></i>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>
<script>
    function toggleEmergencyButtons() {
        const buttons = document.getElementById("emergency-buttons");
        buttons.classList.toggle("expand");

        if (buttons.style.maxHeight === "0px" || buttons.style.maxHeight === "") {
            buttons.style.maxHeight = "200px"; // Expand the sub-menu (adjust height as needed)
        } else {
            buttons.style.maxHeight = "0px"; // Collapse the sub-menu
        }
    }
</script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dokter.css') }}">
@endpush