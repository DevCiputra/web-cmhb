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
                @php
                $photoUrl = $doctor->photos->isNotEmpty()
                ? $doctor->photos[0]->name
                : asset('images/userplaceholder.png');
                @endphp
                <img src="{{ $photoUrl }}" alt="{{ $doctor->name ?? 'Default Doctor' }}" class="img-fluid">
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
        <div class="doctor-schedule" style="margin-top: 2rem;">
            <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Jadwal Praktek</h4>
            <div style="font-size: 1rem; color: #444444;">
                @if($doctor->schedules->isNotEmpty())
                @foreach($doctor->schedules as $schedule)
                <!-- Menampilkan jadwal sesuai dengan format JSON atau teks dari kolom schedule -->
                <p>{!! $schedule->schedule !!}</p>
                @endforeach
                @else
                <p>Jadwal praktek tidak tersedia.</p>
                @endif
            </div>
        </div>


        <!-- Bagian Media (CV) Dokter -->
        @if($doctor->medias->isNotEmpty())
        <div class="doctor-media mt-5">
            <h3>Dokumen Pendukung</h3>
            <ul>
                @foreach($doctor->medias as $media)
                <li>
                    <a href="{{ asset('storage/doctor/medias/' . $doctor->id . '/' . $media->name) }}" target="_blank">
                        {{ $media->name }} ({{ strtoupper($media->mime_type) }})
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="doctor-action-buttons">
            @if($doctor->is_open_reservation == 1)
            <a href="{{ $doctor->address }}" target="_blank" class="btn btn-reservasi">Reservasi</a>
            @endif

            @if($doctor->is_open_consultation == 1)
            <a href="{{ route('consultation.form', ['doctor_id' => $doctor->id]) }}" class="btn btn-konsultasi">Konsultasi Online</a>
            @endif
        </div>
    </div>

    <!-- Emergency Section -->
    <div id="emergency" class="emergency-fab">
        <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
            <a href="tel:+625116743911" class="btn btn-success btn-lg mb-2 rounded-circle">
                <i class="fas fa-ambulance"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=6278033212250&text=Saya%20tertarik%20layanan%20di%20Ciputra%20Hospital%20saya%20ingin%20informasi%20mengenai...."
                class="btn btn-outline-success btn-lg rounded-circle mb-2" target="_blank">
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
<link rel="stylesheet" href="{{ asset('css/dokter_profile.css') }}">
@endpush