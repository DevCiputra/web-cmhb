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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Detail Paket MCU</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reservation.mcu.index') }}">Medical Check Up</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Paket MCU</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto;">
            <div class="card-body" style="padding: 6rem;">
                <div class="mcu-package">
                    <h1 class="title">{{ $service->title }}</h1>
                    <h3 class="price">Rp. {{ number_format($service->price, 0, ',', '.') }}</h3>
                    <div class="mcu-photo">
                        @if ($service->medias->isNotEmpty())
                        @php
                        $media = $service->medias->first();
                        @endphp
                        <img src="{{ Storage::url('service_photos/mcu/' . $media->name) }}" alt="{{ $service->title }}"
                            style="max-width: 100%; height: auto; max-height: 400px; object-fit: cover;">
                        @else
                        <img src="{{ asset('images/default.jpg') }}" alt="Default Image"
                            style="max-width: 100%; height: auto; max-height: 400px; object-fit: cover;">
                        @endif
                    </div>
                </div>

                <!-- mcu Description Section -->
                <div class="mcu-description">
                    <h4>Rincian Paket</h4>
                    <p> {!! $service->description !!}</p>
                </div>

                <!-- mcu Information Section -->
                <div class="mcu-info">
                    <h4>Informasi Penting</h4>
                    <ul>
                        <li class="info-item">{!! $service->special_information !!}</li>
                    </ul>
                </div>

                <div class="text-center" style="margin-top: 40px;">
                    <a href="{{ $service->address }}" target="_blank" class="btn btn-reservation"
                        style="background-color: #007858; color: white; border-color: #007858; border-radius: 18px; margin-bottom: 10px;">
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

@push('styles')
<link href="{{ asset('css/mcu_detail.css') }}" rel="stylesheet">
@endpush