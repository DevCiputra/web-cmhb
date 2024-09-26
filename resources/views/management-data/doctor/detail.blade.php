@extends('management-data.layouts.app')

@section('title', 'Detail Dokter')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Profile Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/doctor-data">Dokter</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Dokter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 6rem;">
                <!-- Doctor Profile Section -->
                <div class="doctor-detail">
                    <h1 class="doctor-name">{{ $doctor->name }}</h1>
                    <h3 class="doctor-specialist">{{ $doctor->specialization_name }}</h3>

                    <!-- Foto Dokter, dari photos -->
                    <div class="doctor-photo">
                        <img src="{{ asset('storage/doctor/photos/' . $doctor->id . '/' . ($doctor->photos->first()->name ?? 'dokter_placeholder.jpg')) }}" alt="Doctor Photo">
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
                        @foreach ($doctor->schedules as $schedule)
                        <li class="schedule-item">{{ $schedule->day_of_week }}: {{ $schedule->start_time }} – {{ $schedule->end_time }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- CV Section, ambil dari medias -->
                <div class="doctor-cv">
                    <h4>Curriculum Vitae (CV)</h4>
                    @if($doctor->medias->isNotEmpty())
                    <a href="{{ asset('storage/doctor/medias/' . $doctor->id . '/' . $doctor->medias->first()->name) }}" class="btn btn-primary" target="_blank">Lihat CV</a>
                    @else
                    <p>Tidak ada CV tersedia.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('css/dokter_profile.css') }}" rel="stylesheet">
@endpush

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