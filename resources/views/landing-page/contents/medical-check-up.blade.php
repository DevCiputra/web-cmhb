@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                <li class="breadcrumb-item" style="color: #023770">Medical Check Up (MCU)</li>
            </ol>
        </nav>
    </div>

    <div id="list-mcu" class="header-section">
        <div class="container-fluid">
            <h1 style="margin-bottom: 5px;">Medical Check Up (MCU)</h1>
            <p style="margin-bottom: 15px;">Paket Medical Check Up terlengkap di Ciputra Mitra Hospital.</p>

            <!-- Filter Card Section -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-6">
                    <div class="card-filter mb-4">
                        <div class="filter-card-body">
                            <div class="row">
                                <!-- Search Bar -->
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Cari paket MCU...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MCU Cards Container -->
            <div class="mcu-cards-container">
                <div class="row">
                    <!-- Card 1 -->
                    <div class="col-md-3 mb-4">
                        <div class="mcu-card">
                            <img class="mcu-card-img-top" src="{{ asset('images/mcu1.jpg') }}" alt="mcu Image">
                            <div class="mcu-card-body">
                                <h5 class="title">Nama Paket MCU</h5>
                                <b class="price">Rp. 500.000</b>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/mcu_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-3 mb-4">
                        <div class="mcu-card">
                            <img class="mcu-card-img-top" src="{{ asset('images/mcu2.jpg') }}" alt="mcu Image">
                            <div class="mcu-card-body">
                                <h5 class="title">Nama Paket MCU</h5>
                                <b class="price">Rp. 500.000</b>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/mcu_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-3 mb-4">
                        <div class="mcu-card">
                            <img class="mcu-card-img-top" src="{{ asset('images/mcu3.jpg') }}" alt="mcu Image">
                            <div class="mcu-card-body">
                                <h5 class="title">Nama Paket MCU</h5>
                                <b class="price">Rp. 500.000</b>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/mcu_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-md-3 mb-4">
                        <div class="mcu-card">
                            <img class="mcu-card-img-top" src="{{ asset('images/mcu4.jpg') }}" alt="mcu Image">
                            <div class="mcu-card-body">
                                <h5 class="title">Nama Paket MCU</h5>
                                <b class="price">Rp. 500.000</b>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/mcu_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 1 -->
                    <div class="col-md-3 mb-4">
                        <div class="mcu-card">
                            <img class="mcu-card-img-top" src="{{ asset('images/mcu1.jpg') }}" alt="mcu Image">
                            <div class="mcu-card-body">
                                <h5 class="title">Nama Paket MCU</h5>
                                <b class="price">Rp. 500.000</b>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/mcu_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-3 mb-4">
                        <div class="mcu-card">
                            <img class="mcu-card-img-top" src="{{ asset('images/mcu2.jpg') }}" alt="mcu Image">
                            <div class="mcu-card-body">
                                <h5 class="title">Nama Paket MCU</h5>
                                <b class="price">Rp. 500.000</b>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/mcu_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-3 mb-4">
                        <div class="mcu-card">
                            <img class="mcu-card-img-top" src="{{ asset('images/mcu3.jpg') }}" alt="mcu Image">
                            <div class="mcu-card-body">
                                <h5 class="title">Nama Paket MCU</h5>
                                <b class="price">Rp. 500.000</b>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/mcu_detail" class="btn btn-selengkapnya">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-md-3 mb-4">
                        <div class="mcu-card">
                            <img class="mcu-card-img-top" src="{{ asset('images/mcu4.jpg') }}" alt="mcu Image">
                            <div class="mcu-card-body">
                                <h5 class="title">Nama Paket MCU</h5>
                                <b class="price">Rp. 500.000</b>
                                <p class="description">Some quick example text to build on the card.</p>
                                <a href="/mcu_detail" class="btn btn-selengkapnya">
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
                    <nav aria-label="mcu pagination">
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
<link rel="stylesheet" href="{{ asset('css/mcu.css') }}">
@endpush
