@extends('management-data.layouts.app')

@section('title', 'Edit Article')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Edit Artikel</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information.article.index') }}">Artikel</a>
                            </li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Artikel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-form" style="padding: 2rem;">
                <form action="{{ route('information.article.update', $article->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="article_title" name="title"
                            value="{{ old('title', $article->title) }}" placeholder="Masukkan Judul Artikel">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="flag" class="form-label">Kategori Artikel</label>
                        <select name="flag" id="kategoriArtikel" class="form-select @error('flag') is-invalid @enderror" required>
                            <option value="" disabled {{ old('flag', $article->flag) == '' ? 'selected' : '' }}>Pilih Kategori</option>
                            <option value="Artikel Kesehatan" {{ old('flag', $article->flag) == 'Artikel Kesehatan' ? 'selected' : '' }}>Artikel Kesehatan</option>
                            <option value="Tips Kesehatan" {{ old('flag', $article->flag) == 'Tips Kesehatan' ? 'selected' : '' }}>Tips Kesehatan</option>
                            <option value="Event" {{ old('flag', $article->flag) == 'Event' ? 'selected' : '' }}>Event</option>
                        </select>
                        @error('flag')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Isi Artikel</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="article_description" name="description" rows="4"
                            placeholder="Masukkan Isi Artikel">{{ old('description', $article->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="special_information" class="form-label">Informasi Khusus</label>
                        <input type="text" class="form-control @error('special_information') is-invalid @enderror" id="special_information" name="special_information"
                            value="{{ old('special_information', $article->special_information) }}" placeholder="Masukkan Informasi Khusus">
                        @error('special_information')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Artikel</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="article_image" name="image" accept="image/*" onchange="previewNewImage(event)">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Preview Gambar Asli -->
                        <div class="mt-3">
                            <label>Gambar Asli:</label>
                            @if($article->media && $article->media->first())
                            <img id="original_image_preview"
                                src="{{ asset('storage/articles/' . $article->media->first()->file_name) }}"
                                alt="Original Article Image"
                                class="img-fluid"
                                width="150"
                                style="cursor: pointer;">
                            @else
                            <p class="text-muted">Tidak ada gambar.</p>
                            @endif
                        </div>

                        <!-- Preview Gambar Baru -->
                        <div class="mt-3">
                            <label>Gambar Baru:</label>
                            <img id="new_image_preview"
                                src="#"
                                alt="New Article Image"
                                class="img-fluid"
                                width="150"
                                style="display: none; cursor: pointer;">
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


                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success"
                            style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Simpan
                        </button>
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

<script>
    // Fungsi untuk menampilkan preview gambar baru
    function previewNewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const newImage = document.getElementById('new_image_preview');
            const modalImage = document.getElementById('modal_image');
            newImage.style.display = 'block'; // Tampilkan gambar baru
            newImage.src = reader.result;
            modalImage.src = reader.result; // Atur gambar modal
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Event klik untuk membuka modal zoom dari gambar asli
    const originalImagePreview = document.getElementById('original_image_preview');
    if (originalImagePreview) {
        originalImagePreview.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            const modalImage = document.getElementById('modal_image');
            modalImage.src = originalImagePreview.src;
            modal.show();
        });
    }

    // Event klik untuk membuka modal zoom dari gambar baru
    const newImagePreview = document.getElementById('new_image_preview');
    newImagePreview.addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        const modalImage = document.getElementById('modal_image');
        modalImage.src = newImagePreview.src;
        modal.show();
    });
</script>
@endpush