@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                <li class="breadcrumb-item" style="color: #023770">Home Service</li>
            </ol>
        </nav>
    </div>

    <div id="list-home-service" class="header-section">
        <div class="container-fluid">
            <h1 style="margin-bottom: 5px;">Paket Home Service</h1>
            <p style="margin-bottom: 15px;">Pilih paket home service yang tersedia di Ciputra Mitra Hospital</p>
        </div>

        <!-- Filter Card Section -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-6">
                <div class="card-filter mb-4">
                    <div class="filter-card-body">
                        <div class="row">
                            <!-- Search Bar -->
                            <div class="col">
                                <input type="text" id="searchHomeService" class="form-control"
                                    placeholder="Cari Paket Home Service...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accordion Section -->
        <div class="accordion" id="accordionHomeService">
            <!-- Home Service 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Paket Home Service Umum
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionHomeService">
                    <div class="accordion-body">
                        <p>Pelayanan home service umum untuk pemeriksaan kesehatan dan konsultasi di rumah.</p>
                        <a href="#" class="btn btn-primary">Reservasi</a>
                    </div>
                </div>
            </div>

            <!-- Home Service 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Paket Home Service Gigi
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionHomeService">
                    <div class="accordion-body">
                        <p>Pelayanan home service untuk perawatan kesehatan gigi di rumah, termasuk konsultasi.</p>
                        <a href="#" class="btn btn-primary">Reservasi</a>
                    </div>
                </div>
            </div>

            <!-- Home Service 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Paket Home Service Anak
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionHomeService">
                    <div class="accordion-body">
                        <p>Paket home service khusus untuk anak, termasuk imunisasi dan pemeriksaan kesehatan.</p>
                        <a href="#" class="btn btn-primary">Reservasi</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination Section -->
        <div class="pagination-container d-flex justify-content-end">
            <nav aria-label="home service pagination">
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
<link rel="stylesheet" href="{{ asset('css/homeservice.css') }}">
@endpush
