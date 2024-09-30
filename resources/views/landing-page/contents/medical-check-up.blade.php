@extends('landing-page.layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
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
                    <div class="col-md-8 col-lg-6">
                        <div class="card-filter mb-4">
                            <div class="filter-card-body">
                                <div class="row">
                                    <!-- Search Bar -->
                                    <div class="col">
                                        <input type="text" class="form-control" id="mcuSearch"
                                            placeholder="Cari paket MCU...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- MCU Cards Container -->
                <div class="mcu-cards-container">
                    <div class="row">
                        @foreach ($mcus as $mcu)
                            <div class="col-md-3 mb-4">
                                <div class="mcu-card">
                                    @php
                                        // Check if the MCU has media and get the first image or use a default image
                                        $mcuImageUrl = $mcu->medias->isNotEmpty()
                                            ? asset('storage/service_photos/mcu/' . $mcu->medias->first()->name)
                                            : asset('images/default-mcu.jpg'); // Default image if no MCU image exists

                                        // Limit the description to 10 words and decode HTML entities
                                        $description = strip_tags($mcu->description); // Remove HTML tags
                                        $description = html_entity_decode($description); // Decode HTML entities
                                        $description = preg_replace('/\s+/', ' ', $description); // Replace multiple spaces with a single space

                                        // Optionally replace unwanted patterns (e.g., "DokterPemeriksaan" to "Dokter Pemeriksaan")
                                        $description = preg_replace('/([a-z])([A-Z])/', '$1 $2', $description); // Add space before uppercase letters

                                        $descriptionWords = explode(' ', $description);
                                        $limitedDescription = implode(' ', array_slice($descriptionWords, 0, 6)); // Get the first 10 words
                                        $limitedDescription .= count($descriptionWords) > 6 ? '...' : ''; // Add '...' if there are more than 10 words
                                    @endphp

                                    <img class="mcu-card-img-top" src="{{ $mcuImageUrl }}" alt="{{ $mcu->title }}">
                                    <div class="mcu-card-body">
                                        <h5 class="title">{{ $mcu->title }}</h5>
                                        <b class="price">Rp. {{ number_format($mcu->price, 0, ',', '.') }}</b>
                                        <p class="description">{{ $limitedDescription }}</p>
                                        <!-- Display the limited description -->
                                        <a href="{{ route('mcu.detail.landing', $mcu->id) }}" class="btn btn-selengkapnya">
                                            Selengkapnya
                                            <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                                class="chevron-icon">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('mcuSearch');
    const mcuCards = document.querySelectorAll('.mcu-card');

    searchInput.addEventListener('input', function () {
        const searchText = searchInput.value.toLowerCase();

        // Loop through each card and hide those that don't match the search text
        mcuCards.forEach(function (card) {
            const cardTitle = card.querySelector('.title').textContent.toLowerCase();

            // Check if the card's title includes the search text
            if (cardTitle.includes(searchText)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

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
