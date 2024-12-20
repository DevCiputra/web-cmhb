@extends('landing-page.layouts.app')

@section('content')

<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item" style="color: #023770">Promo</li>
            </ol>
        </nav>
    </div>

    <div id="header-promosi" class="header-section">
        <div class="container-fluid">
            <h1 style="margin-bottom: 5px;">Promo</h1>
            <p style="margin-bottom: 55px;">Temukan paket promo yang tersedia di Ciputra Mitra Hospital</p>
        </div>

        <!-- Promotions Card Section -->
        <div class="row">
            @foreach($promotions as $promotion)
            <div class="col-md-4 promotion-item">
                <div class="promotion-content ">
                    <!-- Gunakan gambar terkait jika ada media, fallback ke placeholder -->
                    @if ($promotion->media->isNotEmpty())
                    <img src="{{ $promotion->media->first()->file_url }}" alt="{{ $promotion->title }}" class="img-fluid"
                        data-bs-toggle="modal" data-bs-target="#imagePreviewModal" 
                        onclick="setImagePreview('{{ $promotion->media->first()->file_url }}', '{{ $promotion->title }}')">
                    @else
                    <img src="{{ asset('images/default-promo.jpg') }}" alt="Default Promo" class="img-fluid"
                        data-bs-toggle="modal" data-bs-target="#imagePreviewModal" 
                        onclick="setImagePreview('{{ asset('images/default-promo.jpg') }}', 'Default Promo')">
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination Section -->
        <div class="pagination-container d-flex justify-content-end mt-2">
            {{ $promotions->links() }}
        </div>
    </div>

    <!-- Emergency Section -->
    <div id="emergency" class="emergency-fab">
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

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imagePreview" src="" class="img-fluid" alt="Preview">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>

<script>
    function setImagePreview(imageUrl, title) {
        document.getElementById('imagePreview').src = imageUrl;
        document.getElementById('imagePreviewModalLabel').innerText = title;
    }

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
<link rel="stylesheet" href="{{ asset('css/promosi.css') }}">
@endpush
