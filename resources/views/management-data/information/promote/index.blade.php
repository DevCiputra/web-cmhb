@extends('management-data.layouts.app')

@section('title', 'Promotion')

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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Promo</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Informasi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Promo</li>
                        </ol>
                    </nav>
                </div>

                <!-- Right Side: Controls -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Search Box -->
                    <input type="text" class="form-control" placeholder="Cari promo" style="max-width: 200px;">

                    <!-- Dropdown Category -->
                    <select class="form-select">
                        <option selected>Pilih Kategori</option>
                        <option value="1">Diskon</option>
                        <option value="2">Penawaran Khusus</option>
                    </select>

                    <!-- Add Button -->
                    <a href="{{ route('information.promote.create') }}" style="text-decoration: none;">
                        <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                            <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                            Tambah
                        </button>
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <!-- Cards Container -->
        <div class="row cards-container">
            @foreach($promotions as $promotion)
            <div class="col-md-3 mb-4">
                <div class="card" style="border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    @php
                        $media = $promotion->medias->first(); // Ambil media pertama terkait promosi
                    @endphp
                    <img class="card-img-top"
                         src="{{ $media ? Storage::url($media->file_url) : asset('images/default.jpg') }}"
                         alt="Promotion Image"
                         style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $promotion->title }}</h5>
                        <p class="card-text">{{ Str::limit($promotion->description, 100, '...') }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('information.promote.edit', $promotion->id) }}" class="btn btn-sm btn-success custom-btn">Edit</a>
                        <form action="{{ route('information.promote.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promosi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger custom-btn">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $promotions->links() }}
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
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