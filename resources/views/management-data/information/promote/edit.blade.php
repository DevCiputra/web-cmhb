@extends('management-data.layouts.app')

@section('title', 'Edit Promotion')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Edit Promo</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information.promote.index') }}">Promo</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Promo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-form" style="padding: 2rem;">
                <form action="{{ route('information.promote.update', $promotion->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Judul Promo -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Promo</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            id="title" value="{{ old('title', $promotion->title) }}" placeholder="Masukkan Judul Promo">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="flag" class="form-label">Kategori Promosi</label>
                        <select name="flag" id="flag" class="form-select @error('flag') is-invalid @enderror" required>
                            <option value="" disabled {{ old('flag', $promotion->flag) == '' ? 'selected' : '' }}>Pilih Kategori</option>
                            <option value="Diskon" {{ old('flag', $promotion->flag) == 'Diskon' ? 'selected' : '' }}>Diskon</option>
                            <option value="MCU" {{ old('flag', $promotion->flag) == 'MCU' ? 'selected' : '' }}>MCU</option>

                        </select>
                        @error('flag')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Foto Promo -->
                    <div class="mb-3">
                        <label for="media" class="form-label">Poster Promo</label>
                        <input type="file" class="form-control @error('media') is-invalid @enderror" name="media" id="media" accept="image/*">
                        @error('media')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Gambar Sebelumnya -->
                        <div class="mt-2">
                            <small>Media Sebelumnya:</small><br>
                            @if($promotion->media && $promotion->media->first())
                            <img id="image_preview_old"
                                src="{{ asset('storage/promotions/' . $promotion->media->first()->file_name) }}"
                                alt="Promo Image"
                                class="img-fluid"
                                width="150"
                                style="cursor: pointer; border-radius: 8px;">
                            @else
                            <p class="text-muted">Tidak ada gambar.</p>
                            @endif
                        </div>

                        <!-- Preview Gambar Baru -->
                        <div class="mt-3">
                            <small>Media Baru:</small><br>
                            <img id="image_preview_new" src="#" alt="Preview Gambar Baru"
                                class="img-fluid"
                                style="display: none; max-width: 150px; border: 1px solid #ddd; border-radius: 8px; cursor: pointer;">
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="image-modal" class="image-modal">
                        <span class="image-modal-close">&times;</span>
                        <img class="image-modal-content" id="modal-image">
                    </div>


                    <!-- Save Button -->
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('information.promote.index') }}" class="btn btn-secondary me-2"
                            style="border-radius: 10px; padding: 8px 12px;">Kembali</a>
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

<!-- Pemuatan untuk Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#promo_description').summernote({
            height: 400, // Set the height of the editor
            placeholder: 'Masukkan Deskripsi Promo',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

<script>
    const mediaInput = document.getElementById('media');
    const previewImageNew = document.getElementById('image_preview_new');
    const previewImageOld = document.getElementById('image_preview_old');
    const modal = document.getElementById('image-modal');
    const modalImage = document.getElementById('modal-image');
    const closeModal = document.querySelector('.image-modal-close');

    // Preview the new uploaded image
    mediaInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImageNew.src = e.target.result;
                previewImageNew.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Open modal when clicking on the preview image (new)
    previewImageNew.addEventListener('click', function() {
        if (this.src) {
            modal.style.display = 'block';
            modalImage.src = this.src;
        }
    });

    // Open modal when clicking on the old image preview
    if (previewImageOld) {
        previewImageOld.addEventListener('click', function() {
            if (this.src) {
                modal.style.display = 'block';
                modalImage.src = this.src;
            }
        });
    }

    // Close modal when clicking the close button
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside of the image
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>

@endpush

@push('styles')
<style>
    /* Modal Styling */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .image-modal-content {
        margin: auto;
        display: block;
        max-width: 80%;
        max-height: 80%;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    }

    .image-modal-close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #fff;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .image-modal-close:hover,
    .image-modal-close:focus {
        color: #bbb;
        text-decoration: none;
    }
</style>
@endpush