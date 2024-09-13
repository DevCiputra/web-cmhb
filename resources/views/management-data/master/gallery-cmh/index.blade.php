@extends('management-data.layouts.app')

@section('title', 'Galeri CMH')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <!-- Left Side: Text -->
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; ">Galeri RS</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Master Data</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Galeri RS</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- DataTable Card -->
        <!-- Data Galeri -->
        <div class="card" style="border: none; border-radius: 12px;">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <h4 class="card-title" style="color: #1C3A6B;"><b>Data Galeri RS</b></h4>
                    <div class="ms-auto">
                        <a href="{{ route('gallery.data.create') }}" style="text-decoration: none;">
                            <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px; border: none;">
                                <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon"> Tambah
                            </button>
                        </a>
                    </div>
                </div>

                <div class="row">
                    @foreach ($galleries as $gallery)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm" style="border-radius: 10px;">
                            @if($gallery->photo)
                            <img src="{{ asset('storage/' . $gallery->photo) }}" class="img-thumbnail gallery-img" alt="gallery image" class="card-img-top" style="border-radius: 10px 10px 0 0; object-fit: cover; height: 200px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-img="{{ asset('storage/' . $gallery->photo) }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $gallery->description }}</h5>
                                <p class="card-text"><small class="text-muted">Diupload pada {{ $gallery->created_at->format('d-m-Y') }}</small></p>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('gallery.data.edit', $gallery->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('gallery.data.destroy', $gallery->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img id="modalImage" src="" alt="Full view" class="img-fluid" style="border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this).closest(".dashboard-nav-dropdown").toggleClass("show").find(".dashboard-nav-dropdown").removeClass("show");
            $(this).parent().siblings().removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (window.matchMedia("(max-width: 990px )").matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });
</script>

<script>
    // Event listener for image click
    $(document).on('click', '.gallery-img', function() {
        var imgSrc = $(this).data('img'); // Get image source from data attribute
        $('#modalImage').attr('src', imgSrc); // Set modal image source
    });
</script>
@endpush