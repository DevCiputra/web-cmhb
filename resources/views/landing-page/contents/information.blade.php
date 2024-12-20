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
                    <div class="col-md-8 col-md-6">
                        <div class="card-filter mb-4">
                            <div class="filter-card-body">
                                <form action="{{ route('article') }}" method="GET" class="d-flex">
                                    <input type="text" name="keyword" class="form-control" placeholder="Cari artikel..."  value="{{ request()->input('keyword') }}">
                                    <button type="submit" class="btn btn-md" style="background-color: #a8c0cf; color: #fff; border-radius: 10px; padding: 8px 12px;">
                                        Cari
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Info Cards Container -->
                    <div class="info-cards-container">
                        <div class="row justify-content-start" id="articles-container">
                            @foreach ($articles as $article)
                                <div class="col-md-3 mb-4">
                                    <div class="info-card">
                                        <div class="badge-container"></div>
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

                    <!-- Pagination Section -->
                    <div class="pagination-container d-flex justify-content-end mt-2">
                        {{ $articles->links() }}
                    </div>
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
        <link rel="stylesheet" href="{{ asset('css/informasi.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/navbar.js') }}"></script>
