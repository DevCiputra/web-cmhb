@extends('landing-page.layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Medical Check Up (MCU)</li>
                </ol>
            </nav>
        </div>

        <div id="list-mcu" class="header-section">
            <div class="container-fluid">
                <h1 class="mb-2">Medical Check Up (MCU)</h1>
                <p class="mb-3">Paket Medical Check Up terlengkap di Ciputra Mitra Hospital.</p>

                <!-- Filter Card Section -->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8 col-lg-6">
                        <div class="card-filter">
                            <div class="filter-card-body">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" id="mcuSearch" placeholder="Cari paket MCU...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MCU Cards Container -->
                <div class="mcu-cards-container">
                    <div class="row" id="mcuCardsContainer">
                        @foreach ($mcus as $mcu)
                            <div class="col-md-3 mb-4 mcu-card-wrapper">
                                <div class="mcu-card">
                                    @php
                                        $mcuImageUrl = $mcu->medias->isNotEmpty()
                                            ? asset('storage/service_photos/mcu/' . $mcu->medias->first()->name)
                                            : asset('images/default-mcu.jpg');

                                        $description = strip_tags($mcu->description);
                                        $description = html_entity_decode($description);
                                        $description = preg_replace('/\s+/', ' ', $description);
                                        $descriptionWords = explode(' ', $description);
                                        $limitedDescription = implode(' ', array_slice($descriptionWords, 0, 6));
                                        $limitedDescription .= count($descriptionWords) > 6 ? '...' : '';
                                    @endphp

                                    <img class="mcu-card-img-top" src="{{ $mcuImageUrl }}" alt="{{ $mcu->title }}">
                                    <div class="mcu-card-body">
                                        <h5 class="title">{{ $mcu->title }}</h5>
                                        <b class="price">Rp. {{ number_format($mcu->price, 0, ',', '.') }}</b>
                                        <p class="description">{{ $limitedDescription }}</p>
                                        <a href="{{ route('mcu.detail.landing', $mcu->id) }}" class="btn btn-selengkapnya">
                                            Selengkapnya
                                            <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right" class="chevron-icon">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- No Results Message -->
                    <div id="noResultsMessage" class="col-12 text-center d-none">
                        <p class="mt-4">No Results Found</p>
                    </div>

                    <!-- Pagination Section -->
                    <div class="pagination-container d-flex justify-content-end mt-2">
                        <nav aria-label="mcu pagination">
                            <ul class="pagination">
                                <li class="page-item {{ $mcus->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $mcus->onFirstPage() ? '#' : $mcus->previousPageUrl() }}" tabindex="-1">Previous</a>
                                </li>

                                @foreach(range(1, $mcus->lastPage()) as $i)
                                    <li class="page-item {{ $i == $mcus->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $i == $mcus->currentPage() ? '#' : $mcus->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ $mcus->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $mcus->hasMorePages() ? $mcus->nextPageUrl() : '#' }}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Section -->
        <div id="emergency" class="emergency-fab">
            <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
                <a href="#" class="btn btn-success btn-lg mb-2 rounded-circle" aria-label="Emergency Call">
                    <i class="fas fa-ambulance"></i>
                </a>
                <a href="#" class="btn btn-outline-success btn-lg rounded-circle mb-2" aria-label="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
            <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()" aria-label="Toggle Emergency Buttons">
                <i class="fa-solid fa-phone"></i>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('mcuSearch');
            const mcuCardsContainer = document.getElementById('mcuCardsContainer');
            const mcuCards = Array.from(mcuCardsContainer.getElementsByClassName('mcu-card-wrapper'));
            const noResultsMessage = document.getElementById('noResultsMessage');

            searchInput.addEventListener('input', function() {
                const searchText = searchInput.value.toLowerCase().trim();
                let foundAny = false;

                mcuCards.forEach(function(cardWrapper) {
                    const cardTitle = cardWrapper.querySelector('.title').textContent.toLowerCase();
                    if (cardTitle.includes(searchText)) {
                        cardWrapper.style.display = ''; // Show the matching card
                        foundAny = true;
                    } else {
                        cardWrapper.style.display = 'none'; // Hide the non-matching card
                    }
                });

                noResultsMessage.classList.toggle('d-none', foundAny); // Show/hide no results message
            });
        });

        function toggleEmergencyButtons() {
            const buttons = document.getElementById("emergency-buttons");
            buttons.classList.toggle("expand");
            buttons.style.maxHeight = buttons.style.maxHeight === "0px" || buttons.style.maxHeight === "" ? "200px" : "0px";
        }
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/mcu.css') }}">
@endpush
