@extends('management-data.layouts.app')

@section('title', 'Create Article')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:bold">Tambah Artikel</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information.article.index') }}">Article</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Tambah Artikel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-form" style="padding: 2rem;">
                <form method="POST" action="{{ route('information.article.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="article_title" name="title" placeholder="Masukkan Judul Artikel" value="{{ old('title') }}" required>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="flag" class="form-label">Kategori Artikel</label>
                        <select name="flag" id="flag" class="form-select @error('flag') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Artikel Kesehatan" {{ old('flag') == 'Artikel Kesehatan' ? 'selected' : '' }}>Artikel Kesehatan</option>
                            <option value="Tips Kesehatan" {{ old('flag') == 'Tips Kesehatan' ? 'selected' : '' }}>Tips Kesehatan</option>
                            <option value="Event" {{ old('flag') == 'Event' ? 'selected' : '' }}>Event</option>
                        </select>
                        @error('flag')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="special_information" class="form-label">Informasi Khusus</label>
                        <input type="text" class="form-control @error('special_information') is-invalid @enderror" id="special_information" name="special_information" placeholder="Masukkan Informasi Khusus (Opsional)" value="{{ old('special_information') }}">
                        @error('special_information')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Isi Artikel</label>
                        <input id="description_hidden" type="hidden" name="description" value="{{ old('description') }}">
                        <trix-editor input="description_hidden" id="article_description"></trix-editor>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Artikel</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="article_image" name="image" accept="image/*" onchange="previewNewImage(event)">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Preview Gambar Baru -->
                        <div class="mt-3">
                            <label>Gambar Baru:</label>
                            <img id="new_image_preview"
                                src="#"
                                alt="New Article Image"
                                class="img-fluid"
                                width="150"
                                style="display: none; cursor: pointer;"
                                onclick="showImageInModal(this)">
                        </div>
                    </div>

                    <!-- Modal untuk Zoom Gambar -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <img id="modal_image" src="#" alt="Zoom Gambar" class="img-fluid">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="is_published" class="form-label">Publikasikan Artikel</label>
                        <select class="form-control" id="is_published" name="is_published">
                            <option value="0" selected>Draft</option>
                            <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>Publikasikan</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>

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
            placeholder: 'Masukkan Isi Artikel',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

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

    const titleElement = document.getElementById("card-title");
    const maxLength = 50;

    if (titleElement.textContent.length > maxLength) {
        titleElement.textContent = titleElement.textContent.slice(0, maxLength) + "...";
    }

    function previewNewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('new_image_preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    function showImageInModal(imgElement) {
        const modalImage = document.getElementById('modal_image');
        modalImage.src = imgElement.src;

        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }
</script>


@endpush

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

<style>
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush