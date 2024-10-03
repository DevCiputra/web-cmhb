@extends('landing-page.layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                    <li class="breadcrumb-item" style="color: #023770">Pendaftaran Poliklinik</li>
                </ol>
            </nav>
        </div>

        <div id="list-poli" class="header-section">
            <div class="container-fluid">
                <h1 style="margin-bottom: 5px;">Pendaftaran Poliklinik</h1>
                <p style="margin-bottom: 15px;">Daftar Poliklinik yang tersedia di Ciputra Mitra Hospital</p>
            </div>

            <!-- Filter Card Section -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-8 col-lg-6">
                    <div class="card-filter">
                        <div class="filter-card-body">
                            <form action="{{ route('polyclinic') }}" method="GET" class="d-flex">
                                <input type="text" name="query" class="form-control" placeholder="Cari Poliklinik..."
                                    style="max-width: 500px;" value="{{ request('query') }}">
                                <button type="submit" class="btn btn-md ms-2"
                                    style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                                    Cari
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accordion Section -->
            <div class="accordion" id="accordionPoliklinik">
                @forelse ($polyclinics as $polyclinic)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false"
                                aria-controls="collapse{{ $loop->index }}">
                                {{ $polyclinic->name }}
                            </button>
                        </h2>
                        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordionPoliklinik">
                            <div class="accordion-body">
                                <p>Reservasi pelayanan kesehatan di poliklinik {{ $polyclinic->name }}</p>
                                <a href="#" class="btn btn-primary">Reservasi</a>
                                <a href="/dokter" class="btn btn-outline-primary">Lihat Dokter</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning" role="alert">
                        Tidak ada poliklinik yang ditemukan.
                    </div>
                @endforelse
            </div>

            <!-- Pagination Section -->
            <div class="pagination-container d-flex justify-content-end mt-4">
                <nav aria-label="polyclinic pagination">
                    <ul class="pagination">
                        <li class="page-item {{ $polyclinics->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $polyclinics->onFirstPage() ? '#' : $polyclinics->previousPageUrl() }}"
                                tabindex="-1">Previous</a>
                        </li>

                        @foreach (range(1, $polyclinics->lastPage()) as $i)
                            <li class="page-item {{ $i == $polyclinics->currentPage() ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $i == $polyclinics->currentPage() ? '#' : $polyclinics->url($i) }}">{{ $i }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ $polyclinics->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link"
                                href="{{ $polyclinics->hasMorePages() ? $polyclinics->nextPageUrl() : '#' }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Emergency Section -->
            <div id="emergency" class="emergency-fab">
                <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
                    <a href="#" class="btn btn-success btn-lg mb-2 rounded-circle">
                        <i class="fas fa-ambulance"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success btn-lg rounded-circle mb-2">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
                <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle">
                    <i class="fa-solid fa-phone"></i>
                </a>
            </div>
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
    <link rel="stylesheet" href="{{ asset('css/poliklinik.css') }}">
@endpush
