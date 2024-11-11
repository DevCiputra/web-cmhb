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
            <!-- info Cards Container -->
            <div class="info-cards-container">
                <div class="row">
                    <!-- Card 1 -->
                    <div class="col-md-3 mb-4">
                        <div class="info-card">
                            <div class="badge-container">
                                <span class="badge">Kategori</span>
                            </div>
                            <img class="info-card-img-top" src="{{ asset('images/info1.png') }}" alt="info Image">
                            <div class="info-card-body">
                                <h5 class="title">Title</h5>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/informasi_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-3 mb-4">
                        <div class="info-card">
                            <div class="badge-container">
                                <span class="badge">Artikel</span>
                            </div>
                            <img class="info-card-img-top" src="{{ asset('images/info2.png') }}" alt="info Image">
                            <div class="info-card-body">
                                <h5 class="title">Title</h5>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/informasi_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-3 mb-4">
                        <div class="info-card">
                            <div class="badge-container">
                                <span class="badge">Health Tips</span>
                            </div>
                            <img class="info-card-img-top" src="{{ asset('images/info3.png') }}" alt="info Image">
                            <div class="info-card-body">
                                <h5 class="title">Title</h5>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/informasi_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-md-3 mb-4">
                        <div class="info-card">
                            <div class="badge-container">
                                <span class="badge">Event</span>
                            </div>
                            <img class="info-card-img-top" src="{{ asset('images/info4.png') }}" alt="info Image">
                            <div class="info-card-body">
                                <h5 class="title">Title</h5>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/informasi_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination Section -->
                <div class="pagination-container d-flex justify-content-end">
                    <nav aria-label="info pagination">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1<span class="sr-only"></span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
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
