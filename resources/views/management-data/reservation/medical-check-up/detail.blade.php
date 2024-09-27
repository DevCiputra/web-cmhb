@extends('management-data.layouts.app')

@section('title', 'Detail Medical Check Up')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight: bold;">Detail Paket MCU</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}" style="text-decoration: none; color: #1C3A6B;">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#" style="text-decoration: none; color: #1C3A6B;">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reservation.mcu.index') }}" style="text-decoration: none; color: #1C3A6B;">Medical Check Up</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Paket MCU</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto;">
            <div class="card-form" style="padding: 6rem;">
                <div class="mcu-package" style="text-align: center;">
                    <h1 class="title" style="font-size: 2rem; font-weight: bold; color: #023770;">{{ $service->title }}</h1>
                    <h3 class="price" style="font-size: 1.5rem; color: #007858;">Rp. {{ number_format($service->price, 0, ',', '.') }}</h3>
                    <div class="mcu-photo" style="margin-top: 2rem;">
                        @if ($service->medias->isNotEmpty())
                        @php
                        $media = $service->medias->first();
                        @endphp
                        <img src="{{ Storage::url('service_photos/mcu/' . $media->name) }}" alt="{{ $service->title }}" style="max-width: 100%; height: auto; max-height: 400px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        @else
                        <img src="{{ asset('images/default.jpg') }}" alt="Default Image" style="max-width: 100%; height: auto; max-height: 400px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        @endif
                    </div>
                </div>

                <!-- MCU Description Section -->
                <div class="mcu-description" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; color: #023770;">Rincian Paket</h4>
                    <p style="font-size: 1rem; line-height: 1.5; color: #444444;">{!! $service->description !!}</p>
                </div>

                <!-- MCU Information Section -->
                <div class="mcu-info" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; color: #023770;">Informasi Penting</h4>
                    <ul style="list-style-type: disc; padding-left: 1.5rem;">
                        <li class="info-item" style="font-size: 1rem; color: #444444;">{!! $service->special_information !!}</li>
                    </ul>
                </div>

                <div class="text-center" style="margin-top: 40px;">
                    <a href="{{ $service->address }}" target="_blank" class="btn btn-reservation" style="background-color: #007858; color: white; border-color: #007858; border-radius: 18px; padding: 0.5rem 1rem; text-decoration: none;">
                        Reservasi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const mobileScreen = window.matchMedia("(max-width: 990px)");

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
