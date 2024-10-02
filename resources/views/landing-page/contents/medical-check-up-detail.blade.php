@extends('landing-page.layouts.app')


@section('content')
    <!-- Main Container -->
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container breadcrumb-container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="">Reservasi</a> </li>
                    <li class="breadcrumb-item"><a href="/medical-check-up">Medical Check Up</a> </li>
                    <li class="breadcrumb-item active" style="color: #023770">Paket MCU</li>
                </ol>
            </nav>
        </div>
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto;">
            <div class="card-form" style="padding: 6rem;">
                <div class="mcu-package" style="text-align: center;">
                    <h1 class="title" style="font-size: 2rem; font-weight: bold; color: #023770;">{{ $mcuService->title }}</h1>
                    <h3 class="price" style="font-size: 1.5rem; color: #007858;">Rp. {{ number_format($mcuService->price, 0, ',', '.') }}</h3>
                    <div class="mcu-photo" style="margin-top: 2rem;">
                        @if ($mcuService->medias->isNotEmpty())
                        @php
                        $media = $mcuService->medias->first();
                        @endphp
                        <img src="{{ Storage::url('service_photos/mcu/' . $media->name) }}" alt="{{ $mcuService->title }}" style="max-width: 100%; height: auto; max-height: 400px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        @else
                        <img src="{{ asset('images/default.jpg') }}" alt="Default Image" style="max-width: 100%; height: auto; max-height: 400px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        @endif
                    </div>
                </div>

                <!-- MCU Description Section -->
                <div class="mcu-description" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; color: #023770;">Rincian Paket</h4>
                    <p style="font-size: 1rem; line-height: 1.5; color: #444444;">{!! $mcuService->description !!}</p>
                </div>

                <!-- MCU Information Section -->
                <div class="mcu-info" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; color: #023770;">Informasi Penting</h4>
                    <ul style="list-style-type: disc; padding-left: 1.5rem;">
                        <li class="info-item" style="font-size: 1rem; color: #444444;">{!! $mcuService->special_information !!}</li>
                    </ul>
                </div>

                <div class="text-center" style="margin-top: 40px;">
                    <a href="{{ $mcuService->address }}" target="_blank" class="btn btn-reservation" style="background-color: #007858; color: white; border-color: #007858; border-radius: 18px; padding: 0.5rem 1rem; text-decoration: none;">
                        Reservasi Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- Emergency Section -->
        <!-- Emergency FAB -->
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
            <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()">
                <i class="fa-solid fa-phone"></i>
            </a>
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
        <link rel="stylesheet" href="{{ asset('css/mcu_detail.css') }}">
    @endpush