@extends('management-data.layouts.app')

@section('title', 'Medical Check Up')

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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Medical Check Up</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Medical Check Up</li>
                        </ol>
                    </nav>
                </div>

                <!-- Right Side: Controls -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Search Box -->
                    <input type="text" class="form-control" placeholder="Cari data" style="max-width: 200px;">

                    <!-- Add Button -->
                    <a href="{{ route('reservation.mcu.create') }}" style="text-decoration: none;">
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
            @foreach($services as $service)
            <div class="col-md-3 mb-4">
                <div class="card">
                    @php
                    // Pastikan $service->media tidak null dan memiliki data
                    $media = !empty($service->medias) ? $service->medias->first() : null;
                    @endphp

                    @if($media)
                    <img class="card-img-top" src="{{ Storage::url('service_photos/' . $media->name) }}" alt="Service Image">
                    @else
                    <img class="card-img-top" src="{{ asset('images/default.jpg') }}" alt="Default Image">
                    @endif

                    <div class="card-body">
                        <h5 class="title">{{ $service->title }}</h5>
                        <div class="icon-group">
                            <a href="{{ route('reservation.mcu.edit', $service->id) }}" class="btn btn-edit">
                                <img src="{{ asset('icons/pencil-square.svg') }}" alt="Pencil Square" class="pencil-icon">
                            </a>
                        </div>
                        <b class="price">Rp. {{ number_format($service->price, 0, ',', '.') }}</b>
                        <p class="description">{{ $service->description }}</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
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