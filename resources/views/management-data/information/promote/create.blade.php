@extends('management-data.layouts.app')

@section('title', 'Tambah Promosi')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Tambah Promosi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information.promote.index') }}">Promosi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Tambah Promosi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Pesan Error dari Validasi -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Pesan Error dari Exception -->
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Form Tambah Promosi -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form" style="padding: 2rem;">
                <form action="{{ route('information.promote.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Judul Promosi -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Promosi</label>
                        <input type="text"
                            class="form-control @error('title') is-invalid @enderror"
                            name="title"
                            id="title"
                            placeholder="Masukkan Judul Promosi"
                            value="{{ old('title') }}"
                            required>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="flag" class="form-label">Kategori Promosi</label>
                        <select name="flag" id="flag" class="form-select @error('flag') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Diskon" {{ old('flag') == 'Diskon' ? 'selected' : '' }}>Diskon</option>
                            <option value="MCU" {{ old('flag') == 'MCU' ? 'selected' : '' }}>MCU</option>
                        </select>
                        @error('flag')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Media Promosi -->
                    <div class="mb-3">
                        <label for="media" class="form-label">Media Promosi</label>
                        <input type="file"
                            class="form-control @error('media') is-invalid @enderror"
                            name="media"
                            id="media"
                            accept="image/*"
                            required>
                        <div class="mt-3">
                            <img id="media-preview" src="#" alt="Preview Gambar"
                                style="display: none; max-width: 100px; border: 1px solid #ddd; border-radius: 8px; cursor: pointer;">
                        </div>
                        @error('media')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Modal -->
                    <div id="image-modal" class="image-modal">
                        <span class="image-modal-close">&times;</span>
                        <img class="image-modal-content" id="modal-image">
                    </div>



                    <!-- Tombol Simpan -->
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
<script>
    const mobileScreen = window.matchMedia("(max-width: 990px )");
    $(document).ready(function() {
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
    const mediaInput = document.getElementById('media');
    const previewImage = document.getElementById('media-preview');
    const modal = document.getElementById('image-modal');
    const modalImage = document.getElementById('modal-image');
    const closeModal = document.querySelector('.image-modal-close');

    // Preview the uploaded image
    mediaInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Open modal when clicking on the preview image
    previewImage.addEventListener('click', function() {
        modal.style.display = 'block';
        modalImage.src = this.src;
    });

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
        /* Hidden by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
        /* Black with opacity */
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