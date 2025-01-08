@extends('landing-page.layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item" style="color: #023770">Artikel</li>
                </ol>
            </nav>
        </div>

        <div id="information" class="header-section">
            <div class="container-fluid">
                <h1 style="margin-bottom: 5px;">What's New</h1>
                <p style="margin-bottom: 15px;">Berita dan artikel terbaru seputar kesehatan.</p>

                <!-- Filter Card Section -->
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card-filter mb-4">
                            <div class="filter-card-body">
                                <form method="GET" action="{{ url()->current() }}">
                                    <div class="row">
                                        <!-- Search Bar -->
                                        <div class="col-md-8 mb-2">
                                            <input id="search-bar" type="text" name="keyword" class="form-control"
                                                placeholder="Cari Artikel..." value="{{ request('keyword') }}">
                                        </div>
                                        <!-- Filter Dropdown -->
                                        <div class="col-md-4">
                                            <select name="flag" id="flag" class="form-select"
                                                onchange="this.form.submit()">
                                                <option value="" {{ request('flag') == '' ? 'selected' : '' }}>Semua
                                                    Kategori</option>
                                                <option value="Artikel Kesehatan"
                                                    {{ request('flag') == 'Artikel Kesehatan' ? 'selected' : '' }}>Artikel
                                                    Kesehatan</option>
                                                <option value="Tips Kesehatan"
                                                    {{ request('flag') == 'Tips Kesehatan' ? 'selected' : '' }}>Tips
                                                    Kesehatan</option>
                                                <option value="Event" {{ request('flag') == 'Event' ? 'selected' : '' }}>
                                                    Event</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Info Cards Container -->
                    <div class="info-cards-container">
                        <div class="row justify-content-start" id="articles-container">
                            @foreach ($articles as $article)
                                <div class="col-md-3 mb-4 card-item" data-title="{{ strtolower($article->title) }}"
                                    data-description="{{ strtolower($article->description) }}">
                                    <div class="info-card">
                                        <div class="badge-container"></div>
                                        @if ($article->media->isNotEmpty())
                                            <img src="{{ $article->media->first()->file_url }}" class="card-img-top"
                                                alt="{{ $article->title }}">
                                        @else
                                            <img src="{{ asset('images/default-article.jpg') }}" class="card-img-top"
                                                alt="Default Article">
                                        @endif
                                        <div class="info-card-body">
                                            <h5 class="title">{{ $article->title }}</h5>
                                            <p class="card-text"
                                                style="line-height: 1.6; word-wrap: break-word; text-align: justify;">
                                                {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($article->description)), 80) }}
                                            </p>
                                            <a href="{{ route('article.detail.landing', ['id' => $article->id]) }}"
                                                class="btn btn-selengkapnya">
                                                Selengkapnya
                                                <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                                    class="chevron-icon">
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination Section -->
                    <div class="pagination-container d-flex justify-content-end mt-2">
                        {{ $articles->appends(['keyword' => request('keyword'), 'flag' => request('flag')])->links() }}
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
                        <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle"
                            onclick="toggleEmergencyButtons()">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/informasi.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#search-bar").on("input", function() {
                let searchTerm = $(this).val().toLowerCase();
                $(".card-item").each(function() {
                    let title = $(this).data("title");
                    let description = $(this).data("description");

                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

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
