@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item" style="color: #023770">Cari Dokter</li>
            </ol>
        </nav>
    </div>

    <div id="list-doctor" class="header-section">
        <div class="container-fluid">
            <h1 style="margin-bottom: 5px;">Cari Dokter</h1>
            <p style="margin-bottom: 15px;">Temukan Dokter Profesional di Ciputra Mitra Hospital.</p>

            <!-- Filter Card Section -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-filter mb-4">
                        <div class="filter-card-body">
                            <div class="row">
                                <!-- Search Bar -->
                                <div class="col-md-4 mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="doctorSearch"
                                            placeholder="Cari dokter..." aria-label="Cari dokter">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Filter Dropdown for Polyclinic -->
                                <div class="col-md-4 mb-2">
                                    <select class="form-select" id="polyclinicSelect">
                                        <option value="">Pilih Poliklinik</option>
                                        @foreach ($polyclinics as $polyclinic)
                                        <option value="{{ $polyclinic->id }}">{{ $polyclinic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter Dropdown for Specialization -->
                                <div class="col-md-4 mb-2">
                                    <select class="form-select" id="specializationSelect">
                                        <option value="">Pilih Spesialis</option>
                                        @foreach ($specializations as $specialization)
                                        <option value="{{ $specialization }}">{{ $specialization }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Doctor Cards Container -->
            <div class="doctor-cards-container">
                <div class="row" id="doctorCardsContainer">
                    @foreach ($doctors as $doctor)
                    <div class="col-md-3 mb-4 doctor-card-wrapper">
                        <div class="doctor-card">
                            @php
                            $photoUrl = $doctor->photos->isNotEmpty()
                            ? asset($doctor->photos->first()->name)
                            : asset('images/userplaceholder.png'); // Default image jika tidak ada foto
                            @endphp

                            <img class="doctor-card-img-top" src="{{ $photoUrl }}" alt="Doctor Image">
<div class="doctor-card-body">
    <p class="polyclinic">{{ $doctor->polyclinic->name ?? 'N/A' }}</p>
    <a href="{{ route('doctor.show.landing', $doctor->id) }}" class="name-link">
        <h5 class="name">{{ $doctor->name }}</h5>
    </a>
    <p class="specialist">{{ $doctor->specialization_name }}</p>
    {{-- <a href="{{ route('doctor.show.landing', $doctor->id) }}" class="profile-link">
        Lihat Profil
        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right" class="chevron-icon">
    </a> --}}
</div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


            <!-- Pagination Section
                <div class="pagination-container d-flex justify-content-end mt-2">
                    <nav aria-label="doctor pagination">
                        <ul class="pagination">
                            <li class="page-item {{ $doctors->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $doctors->onFirstPage() ? '#' : $doctors->previousPageUrl() }}"
                                    tabindex="-1">Previous</a>
                            </li>

                            @foreach (range(1, $doctors->lastPage()) as $i)
                            <li class="page-item {{ $i == $doctors->currentPage() ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $i == $doctors->currentPage() ? '#' : $doctors->url($i) }}">{{ $i }}</a>
                            </li>
                            @endforeach

                            <li class="page-item {{ $doctors->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link"
                                    href="{{ $doctors->hasMorePages() ? $doctors->nextPageUrl() : '#' }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div> -->
        </div>
    </div>
</div>

                    <!-- Pagination Section -->
                    <div class="pagination-container d-flex justify-content-end mt-2">
                        {{ $doctors->links() }}
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('doctorSearch');
        const polyclinicSelect = document.getElementById('polyclinicSelect');
        const specializationSelect = document.getElementById('specializationSelect');
        const doctorCardsContainer = document.getElementById('doctorCardsContainer');
        const originalDoctorCards = Array.from(doctorCardsContainer.getElementsByClassName(
            'doctor-card-wrapper')); // Referensi asli kartu dokter

        searchInput.addEventListener('input', filterDoctors);
        polyclinicSelect.addEventListener('change', filterDoctors);
        specializationSelect.addEventListener('change', filterDoctors);

        function filterDoctors() {
            // Ambil nilai dari input search, dropdown poliklinik, dan spesialisasi
            const searchText = searchInput.value.toLowerCase().trim();
            const selectedPolyclinic = polyclinicSelect.value;
            const selectedSpecialization = specializationSelect.value;

            // Bersihkan kontainer kartu sebelum menambahkan kartu yang sesuai
            doctorCardsContainer.innerHTML = '';

            // Filter kartu berdasarkan input dan dropdown
            const filteredCards = originalDoctorCards.filter(function(cardWrapper) {
                const cardName = cardWrapper.querySelector('.name').textContent.toLowerCase();
                const cardPolyclinic = cardWrapper.querySelector('.polyclinic').textContent.trim();
                const cardSpecialization = cardWrapper.querySelector('.specialist').textContent.trim();

                const matchesSearch = cardName.includes(searchText);
                const matchesPolyclinic = selectedPolyclinic ? cardPolyclinic === polyclinicSelect
                    .options[polyclinicSelect.selectedIndex].text : true;
                const matchesSpecialization = selectedSpecialization ? cardSpecialization ===
                    selectedSpecialization : true;

                // Kartu cocok jika memenuhi ketiga filter ini
                return matchesSearch && matchesPolyclinic && matchesSpecialization;
            });

            // Jika ada kartu yang sesuai dengan filter, tampilkan kartu tersebut
            if (filteredCards.length > 0) {
                filteredCards.forEach(card => doctorCardsContainer.appendChild(card));
            } else {
                // Jika tidak ada kartu yang sesuai, tampilkan pesan 'No Results Found'
                const noResultsMessage = document.createElement('div');
                noResultsMessage.className = 'col-12 text-center';
                noResultsMessage.innerHTML = '<p class="mt-4">No Results Found</p>';
                doctorCardsContainer.appendChild(noResultsMessage);
            }
        }
    });



    // EMERGENCY
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
<link rel="stylesheet" href="{{ asset('css/dokter.css') }}">
@endpush
