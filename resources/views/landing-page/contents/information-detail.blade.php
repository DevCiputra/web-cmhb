@extends('landing-page.layouts.app')

@section('content')
    <!-- Main Container -->
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container breadcrumb-container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="">Informasi</a></li>
                    <li class="breadcrumb-item active" style="color: #023770">{{ $article->title }}</li>
                </ol>
            </nav>
        </div>

        <!-- Info Detail Section -->
        <div class="container info-detail" style="margin-top: 40px;">
            <div class="info-header">
                <h1 class="info-title">{{ $article->title }}</h1>
                <div class="info-meta">
                    <span class="category">{{ $article->category->name ?? 'Kategori Artikel' }}</span>
                    <span class="publish-date">Tanggal Publish: {{ $article->created_at->format('d F Y') }}</span>
                </div>
            </div>
            
            <div class="info-content" style="margin-bottom: 40px;">
                @if ($article->media->isNotEmpty())
                    <img src="{{ $article->media->first()->file_url }}" alt="{{ $article->title }}" class="info-image">
                @else
                    <img src="{{ asset('images/default-article.jpg') }}" alt="Default Article" class="info-image">
                @endif

                <p class="info-content">{!! nl2br(e($article->description)) !!}</p>
            </div>
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
            <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()">
                <i class="fa-solid fa-phone"></i>
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/informasi-detail.css') }}">
@endpush

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
