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

                    <!-- Foto Promo -->
                    <div class="mb-3">
                        <label for="media" class="form-label">Poster Promo</label>
                        <input type="file" class="form-control @error('media') is-invalid @enderror" name="media" id="media" accept="image/*">
                        @error('media')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <small>Media Sebelumnya:</small><br>
                            @if($promotion->media && $promotion->media->first())
                            <img id="image_preview" src="{{ asset('storage/promotions/' . $promotion->media->first()->file_name) }}" alt="Promo Image" class="img-fluid" width="150" style="display: {{ $promotion->media->first() ? 'block' : 'none' }}">
                            @else
                            <p class="text-muted">Tidak ada gambar.</p>
                            @endif
                        </div>
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
@endpush