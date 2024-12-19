@extends('landing-page.layouts.app')

@section('content')

<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item" style="color: #023770">Informasi</li>
            </ol>
        </nav>
    </div>

    <div id="information" class="header-section">
        <div class="container-fluid">
            <h1 style="margin-bottom: 5px;">What's New</h1>
            <p style="margin-bottom: 15px;">Berita dan informasi terbaru seputar Ciputra Mitra Hospital.</p>
            <!-- Filter Card Section -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-6">
                    <div class="card-filter mb-4">
                        <div class="filter-card-body">
                            <div class="row">
                                <!-- Search Bar -->
                                <div class="col-md-8 mb-2">
                                    <input type="text" class="form-control" placeholder="Cari dokter...">
                                </div>
                                <!-- Filter Dropdown -->
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected>Kategori Informasi</option>
                                        <option value="1">Artikel Kesehetan</option>
                                        <option value="2">Health Tips</option>
                                        <option value="3">Event</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Info Cards Container -->
            <div class="info-cards-container">
                <div class="row">
                    @foreach($articles as $article)
                    <div class="col-md-3 mb-4">
                        <div class="info-card">
                            <div class="badge-container">

                            </div>
                            @if ($article->media->isNotEmpty())
                            <img src="{{ $article->media->first()->file_url }}" class="card-img-top" alt="{{ $article->title }}">
                            @else
                            <img src="{{ asset('images/default-article.jpg') }}" class="card-img-top" alt="Default Article">
                            @endif
                            <div class="info-card-body">
                                <h5 class="title">{{ $article->title }}</h5>
                                <p class="description">{{ Str::limit($article->description, 100, '...') }}</p>
                                <a href="/informasi_detail/{{ $article->id }}" class="btn btn-selengkapnya">
                                    Selengkapnya
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
    <!-- Emergency FAB -->
    <div id="emergency" class="emergency-fab">
        <!-- Sub-menu FAB buttons that will collapse/expand -->
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
<link rel="stylesheet" href="{{ asset('css/informasi.css') }}">
@endpush