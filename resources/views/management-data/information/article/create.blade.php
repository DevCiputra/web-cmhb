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
                        <input type="text" class="form-control" id="article_title" name="title" placeholder="Masukkan Judul Artikel" required>
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
                        <input type="text" class="form-control" id="special_information" name="special_information" placeholder="Masukkan Informasi Khusus (Opsional)">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Isi Artikel</label>
                        <textarea class="form-control" id="article_description" name="description" rows="4" placeholder="Masukkan Isi Artikel" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Artikel</label>
                        <input type="file" class="form-control" id="article_image" name="image" accept="image/*">
                        <div class="mt-3">
                            <img id="image_preview" src="#" alt="Preview Foto Artikel" class="img-fluid" style="display: none; max-width: 150px; cursor: pointer;">
                        </div>
                    </div>

                    <!-- Modal untuk Zoom Gambar -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <img id="modal_image" src="#" alt="Zoom Foto Artikel" class="img-fluid">
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
                            <option value="1">Publikasikan</option>
                        </select>
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
</script>

<script>
    document.getElementById('article_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('image_preview');
        const modalImage = document.getElementById('modal_image');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                modalImage.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Tambahkan event click pada preview untuk membuka modal
    document.getElementById('image_preview').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    });
</script>
@endpush