@extends('landing-page.layouts.app')

@section('content')

<!-- Main Container -->
<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container breadcrumb-container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/doctor">Cari Dokter</a></li>
                <li class="breadcrumb-item active" style="color: #023770">Profile Dokter</li>
            </ol>
        </nav>
    </div>

    <div class="container doctor-profile" style="margin-top: 40px;">
        <!-- Doctor Profile Section -->
        <div class="doctor-detail">
            <h1 class="doctor-name">{{ $doctor->name }}</h1>
            <h3 class="doctor-specialist">{{ $doctor->specialization_name }}</h3>
            <div class="doctor-photo">
                @if($doctor->photos->isNotEmpty())
                <img src="{{ asset('storage/doctor/photos/' . $doctor->id . '/' . $doctor->photos->first()->name) }}" alt="{{ $doctor->name }}" class="img-fluid">
                @else
                <img src="{{ asset('images/default-doctor.png') }}" alt="Default Doctor" class="img-fluid">
                @endif
            </div>
        </div>

        <!-- Doctor Education Section -->
        <div class="doctor-education">
            <h4>Riwayat Pendidikan</h4>
            <ul>

                <li class="education-item">{{ $doctor->education->name }}</li>

            </ul>
        </div>

        <!-- Doctor Schedule Section -->
        <div class="doctor-schedule">
            <h4>Jadwal Praktek</h4>
            <ul>
                @if($doctor->schedules->isNotEmpty())
                @foreach($doctor->schedules as $schedule)
                <li class="schedule-item">
                    <!-- Menampilkan day_of_week, start_time, dan end_time -->
                    {{ $schedule->day_of_week }}: {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                </li>
                @endforeach
                @else
                <li>Jadwal praktek tidak tersedia.</li>
                @endif
            </ul>
        </div>



        <!-- Bagian Media (CV) Dokter -->
        <div class="doctor-media mt-5">
            <h3>Dokumen Pendukung</h3>
            @if($doctor->medias->isNotEmpty())
            <ul>
                @foreach($doctor->medias as $media)
                <li>
                    <a href="{{ asset('storage/doctor/medias/' . $doctor->id . '/' . $media->name) }}" target="_blank">
                        {{ $media->name }} ({{ strtoupper($media->mime_type) }})
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p>Tidak ada dokumen pendukung.</p>
            @endif
        </div>

        <div class="doctor-action-buttons">
            <a href="{{ route('reservation.mcu.create') }}" class="btn btn-reservasi">Reservasi</a>
            <a href="/consultation-form" class="btn btn-konsultasi">Konsultasi Online</a>
        </div>
    </div>

    <!-- Emergency Section -->
    <div id="emergency" class="emergency-fab">
        <!-- Sub-menu FAB buttons that will collapse/expand -->
        <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
            <a href="#" class="btn btn-success btn-lg mb-2 rounded-circle">
                <i class="fas fa-ambulance"></i>
            </a>
            <a href="#" class="btn btn-outline-success btn-lg rounded-circle mb-2">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
        <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle"
            onclick="toggleEmergencyButtons()">
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
<link rel="stylesheet" href="{{ asset('css/dokter_profile.css') }}">
@endpush