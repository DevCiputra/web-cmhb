@extends('management-data.layouts.app')

@section('title', 'Detail Article')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Detail Artikel</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Informasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information.article.index') }}">Artikel</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Artikel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="container info-detail" style="margin-top: 40px;">
                <div class="info-header">
                    <h1 class="info-title">{{ $article->title }}</h1> <!-- Menampilkan judul artikel -->
                    <div class="info-meta">
                        <span class="publish-date">
                            Tanggal Publish:
                            {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d F Y') : 'Belum Dipublikasikan' }}
                        </span>

                        <span class="category">
                            Kategori:
                            {{ $article->flag ?? 'Tidak Ada Kategori' }}
                        </span>


                    </div>
                </div>

                <div class="info-content">
                    @if($article->media->isNotEmpty())
                    @foreach($article->media as $media)
                    <img src="{{ $media->file_url }}" alt="Article Image" class="info-image" style="max-width: 100%; margin-bottom: 20px;"> <!-- Menampilkan semua gambar yang terkait -->
                    @endforeach
                    @else
                    <img src="{{ asset('images/userplaceholder.jpg') }}" alt="Default Image" class="info-image" style="max-width: 100%; margin-bottom: 20px;"> <!-- Gambar default jika tidak ada -->
                    @endif
                    <p class="info-content">{{ strip_tags($article->description) }}</p> <!-- Menampilkan deskripsi artikel tanpa HTML -->
                    <p class="info-content">{{ $article->special_information }}</p> <!-- Menampilkan deskripsi artikel -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#article_description').summernote({
            height: 400, // Set the height of the editor
            placeholder: 'Masukkan Deskripsi Artikel',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    // Fungsi untuk menampilkan preview gambar
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image_preview');
            output.style.display = 'block'; // Tampilkan gambar preview
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    const mobileScreen = window.matchMedia("(max-width: 990px )");
    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this).closest(".dashboard-nav-dropdown")
                .toggleClass("show")
                .find(".dashboard-nav-dropdown")
                .removeClass("show");
            $(this).parent()
                .siblings()
                .removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (mobileScreen.matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });
</script>
@endpush

@push('styles')
<link href="{{ asset('css/informasi_detail.css') }}" rel="stylesheet">
@endpush