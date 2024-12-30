@extends('landing-page.layouts.app')

@section('content')
    <!-- Main Container -->
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container breadcrumb-container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" style="color: #023770;">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="" style="color: #023770;">Informasi</a></li>
                    <li class="breadcrumb-item active" style="color: #023770;">{{ $article->title }}</li>
                </ol>
            </nav>
        </div>

        <div class="info-detail-article"
            style="margin-top: 40px; font-family: 'Arial', sans-serif; line-height: 1.8; padding:20px ">
            <div class="info-header">
                <h1 class="info-title-article"
                    style="font-size: 2.5rem; font-weight: bold; color: #023770; text-align: center; margin-bottom: 20px;">
                    {{ $article->title }}</h1> <!-- Menampilkan judul artikel -->
                <div class="info-meta-article" style="display: flex; justify-content: space-between; margin-top: 10px;">
                    <span class="publish-date" style="font-size: 1.2rem; color: #023770; font-weight: 500;">
                        Tanggal Publish:
                        {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d F Y') : 'Belum Dipublikasikan' }}
                    </span>

                    <span class="category-article" style="font-size: 1.2rem; color: #023770; font-weight: 500;">
                        Kategori:
                        {{ $article->flag ?? 'Tidak Ada Kategori' }}
                    </span>
                </div>
            </div>

            <div class="info-content-article"
                style="font-size: 1.2rem; color: #555; margin-top: 30px; line-height: 1.8; padding: 0 15px;  margin-bottom: 80px;">
                @if ($article->media->isNotEmpty())
                    @foreach ($article->media as $media)
                        <img src="{{ $media->file_url }}" alt="Article Image" class="info-image"
                            style="display: block; max-width: 100%; margin: 0 auto 30px; border-radius: 8px;">
                        <!-- Menampilkan semua gambar yang terkait -->
                    @endforeach
                @else
                    <img src="{{ asset('images/userplaceholder.jpg') }}" alt="Default Image" class="info-image"
                        style="display: block; max-width: 100%; margin: 0 auto 30px; border-radius: 8px;">
                    <!-- Gambar default jika tidak ada -->
                @endif
                <p class="info-content-article"
                    style="font-size: 1.2rem; line-height: 1.8; color: #555; margin-bottom: 20px; text-align: justify; text-justify: inter-word;">
                    {{ $article->description }}</p> <!-- Menampilkan deskripsi artikel -->
                <p class="info-content-article" style="font-size: 1.2rem; line-height: 1.8; color: #555;">
                    {{ $article->special_information }}</p> <!-- Menampilkan deskripsi artikel -->
            </div>
        </div>
    </div>

    <!-- Recommended Articles Section -->
    <div class="recommended-articles" style="margin-top: 50px; font-family: 'Arial', sans-serif;">
        <h2 style="font-size: 2rem; font-weight: bold; color: #023770; margin-bottom: 30px; text-align: center;">Rekomendasi
            Artikel</h2>
        <div class="row" style="margin: 40px">
            @foreach ($recommendedArticles as $recommended)
                <div class="col-md-4 mb-4">
                    <div class="card"
                        style="border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
                        <img src="{{ $recommended->media->isNotEmpty() ? $recommended->media->first()->file_url : asset('images/userplaceholder.jpg') }}"
                            class="card-img-top" alt="{{ $recommended->title }}"
                            style="border-top-left-radius: 10px; border-top-right-radius: 10px; max-height: 200px; object-fit: cover;">
                        <div class="card-body" style="padding: 20px;">
                            <h5 class="card-title"
                                style="font-size: 1.2rem; font-weight: bold; color: #023770; margin-bottom: 10px;">
                                {{ $recommended->title }}</h5>
                            <p class="card-text"
                                style="font-size: 1rem; color: #555; margin-bottom: 15px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                {{ Str::limit($recommended->description, 100, '...') }}
                            </p>
                            <a href="{{ route('article.detail.landing', ['id' => $recommended->id]) }}" class="btn btn-primary"
                                style="background-color: #023770; border-color: #023770; border-radius: 10px;">Baca
                                Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Emergency Section -->
    <div id="emergency" class="emergency-fab" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
        <div id="emergency-buttons" class="emergency-buttons"
            style="display: none; max-height: 0; overflow: hidden; transition: max-height 0.3s ease-in-out;">
            <a href="#" class="btn btn-success btn-lg mb-2 rounded-circle"
                style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 50%; background-color: #28a745; color: white;">
                <i class="fas fa-ambulance" style="font-size: 24px;"></i>
            </a>
            <a href="#" class="btn btn-outline-success btn-lg rounded-circle mb-2"
                style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 50%; border: 2px solid #28a745; color: #28a745;">
                <i class="fab fa-whatsapp" style="font-size: 24px;"></i>
            </a>
        </div>
        <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()"
            style="background-color: #ff5b5b; color: white; border-radius: 50%; padding: 15px; font-size: 24px;">
            <i class="fa-solid fa-phone" style="font-size: 24px;"></i>
        </a>
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
