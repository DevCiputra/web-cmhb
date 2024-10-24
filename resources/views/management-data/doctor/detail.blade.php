@extends('management-data.layouts.app')

@section('title', 'Detail Dokter')

@section('content')
    <div class='dashboard-app'>
        <header class='dashboard-toolbar'>
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        </header>
        <div class='dashboard-content'>
            <div class="card-header mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 fw-normal" style="color: #023770; font-weight: bold;">Profil Dokter</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard-page') }}"
                                        style="text-decoration: none; color: #1C3A6B;">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/doctor-data" style="text-decoration: none; color: #1C3A6B;">Dokter</a>
                                </li>
                                <li class="breadcrumb-item" style="color: #023770;">Profil Dokter</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card"
                style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto;">
                <div class="card-form" style="padding: 4rem;">
                    <!-- Doctor Profile Section -->
                    <div class="doctor-detail" style="text-align: center; margin-bottom: 2rem;">
                        <h1 class="doctor-name" style="font-size: 2rem; font-weight: bold; color: #023770;">
                            {{ $doctor->name }}</h1>
                        <h3 class="doctor-specialist" style="font-size: 1.5rem; color: #023770;">
                            {{ $doctor->specialization_name }}</h3>

                        <!-- Foto Dokter, dari photos -->
                        <div class="doctor-photo" style="margin-top: 2rem;">
                            <img src="{{ asset('storage/doctor/photos/' . $doctor->id . '/' . ($doctor->photos->first()->name ?? 'dokter_placeholder.jpg')) }}"
                                alt="Doctor Photo"
                                style="width: 200px; height: auto; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        </div>
                    </div>

                    <!-- Doctor Consultation Fee Section -->
                    <div class="doctor-fee" style="margin-top: 2rem;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Consultation
                            Fee</h4>
                        <p style="font-size: 1.25rem; color: #444444;">
                            Rp{{ number_format($doctor->consultation_fee, 0, ',', '.') }},-
                        </p>
                    </div>

                    <!-- Doctor Education Section -->
                    <div class="doctor-education" style="margin-top: 2rem;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Riwayat
                            Pendidikan Dokter</h4>
                        <ul style="list-style-type: disc; padding-left: 1.5rem;">
                            <li class="education-item" style="font-size: 1rem; color: #444444;">
                                {{ $doctor->education->name }}</li>
                        </ul>
                    </div>

                    <!-- Doctor Schedule Section -->
                    <div class="doctor-schedule" style="margin-top: 2rem;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Jadwal
                            Praktek</h4>
                        <ul style="list-style-type: disc; padding-left: 1.5rem;">
                            @foreach ($doctor->schedules as $schedule)
                                @php
                                    // Menggunakan array untuk mendapatkan nama hari dalam bahasa Indonesia
                                    $dayInIndonesian = array_search($schedule->day_of_week, $daysInIndonesian);
                                @endphp
                                <li class="schedule-item" style="font-size: 1rem; color: #444444;">
                                    {{ $dayInIndonesian }}: {{ $schedule->start_time }} – {{ $schedule->end_time }}
                                </li>
                            @endforeach
                        </ul>
                    </div>


                    <!-- CV Section, ambil dari medias -->
                    <div class="doctor-cv" style="margin-top: 2rem;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Curriculum
                            Vitae (CV)</h4>
                        @if ($doctor->medias->isNotEmpty())
                            <a href="{{ asset('storage/doctor/medias/' . $doctor->id . '/' . $doctor->medias->first()->name) }}"
                                class="btn btn-primary" target="_blank"
                                style="background-color: #007BFF; color: #FFFFFF; border-radius: 8px; padding: 0.5rem 1rem; text-decoration: none;">Lihat
                                CV</a>
                        @else
                            <p style="font-size: 1rem; color: #444444;">Tidak ada CV tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".menu-toggle").click(function() {
                if (window.matchMedia("(max-width: 990px)").matches) {
                    $(".dashboard-nav").toggleClass("mobile-show");
                } else {
                    $(".dashboard").toggleClass("dashboard-compact");
                }
            });
        });
    </script>
@endpush
