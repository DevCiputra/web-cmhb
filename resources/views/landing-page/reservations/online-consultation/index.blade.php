@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item" style="color: #023770">Konsultasi Online</li>
            </ol>
        </nav>
    </div>

    <div id="list-doctor" class="header-section">
        <div class="container-fluid">
            <h1 style="margin-bottom: 5px;">Konsultasi Online</h1>
            <p style="margin-bottom: 15px;">Temukan Dokter Profesional untuk Konsultasi Online di Ciputra Mitra Hospital.</p>

            <!-- Filter Card Section -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-6">
                    <div class="card-filter mb-4">
                        <div class="filter-card-body">
                            <div class="row">
                                <!-- Search Bar -->
                                <div class="col-md-4 mb-2">
                                    <input type="text" class="form-control" placeholder="Cari dokter...">
                                </div>
                                <!-- Filter Dropdown -->
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected>Pilih Poliklinik</option>
                                        <!-- Loop Poliklinik dari Dokter -->
                                        @foreach($doctors->pluck('polyclinic.name')->unique() as $polyclinic)
                                        <option>{{ $polyclinic }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected>Pilih Spesialis</option>
                                        <!-- Loop Spesialis dari Dokter -->
                                        @foreach($doctors->pluck('specialist')->unique() as $specialist)
                                        <option>{{ $specialist }}</option>
                                        @endforeach
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
                    <!-- Loop Data Dokter dari Controller -->
                    @foreach($doctors as $doctor)
                    <div class="col-md-3 mb-4">
                        <div class="doctor-card">
                            <!-- Gambar Dokter -->
                            @if($doctor->photos->isNotEmpty())
                            <img src="{{ asset('storage/doctor/photos/' . $doctor->id . '/' . $doctor->photos->first()->name) }}" alt="{{ $doctor->name }}" class="img-fluid">
                            @else
                            <img src="{{ asset('images/default-doctor.png') }}" alt="Default Doctor" class="img-fluid">
                            @endif

                            <div class="doctor-card-body">
                                <p class="polyclinic">{{ $doctor->polyclinic->name }}</p>
                                <h5 class="name">{{ $doctor->name }}</h5>
                                <p class="specialist">{{ $doctor->specialization_name }}</p>
                                <a href="{{ route('doctor.show.landing', $doctor->id) }}" class="btn btn-profil">
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
</div>
@endsection