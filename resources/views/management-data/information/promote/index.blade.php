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
                            <li class="breadcrumb-item"><a href="#">Informasi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Promo</li>
                        </ol>
                    </nav>
                </div>

                <!-- Right Side: Controls -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Search Box -->
                    <input id="search-promo" type="text" class="form-control" placeholder="Cari promo" style="max-width: 200px;">

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

        <!-- Cards Container -->
        <div class="row cards-container">
            @forelse($promotions as $promotion)
            <div class="col-md-3 mb-4 promo-card" data-title="{{ $promotion->title }}" data-description="{{ $promotion->description }}">
                <div class="card" style="border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <img class="card-img-top"
                        src="{{ $promotion->media->first() ? $promotion->media->first()->file_url : asset('images/default-image.jpg') }}"
                        alt="Promotion Image"
                        style="width: 100%; height: 450px; object-fit: cover;">
                    <div class="card-body" style="height: 100px; object-fit: cover;">
                        <h5 class="card-title">{{ $promotion->title }}</h5>
                        <p class="card-text">
                            {{ $promotion->description ?? 'Tidak ada deskripsi' }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('information.promote.edit', $promotion->id) }}" class="btn btn-sm btn-success custom-btn">
                            Edit
                        </a>
                        <form action="{{ route('information.promote.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promo ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger custom-btn">
                                Delete
                            </button>
                        </form>
                        @if(!$promotion->is_published)
                        <!-- Tombol untuk Publish -->
                        <form action="{{ route('information.promote.publish', $promotion->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mempublikasikan promo ini?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-secondary custom-btn">
                                Publish
                            </button>
                        </form>
                        @else
                        <!-- Tombol untuk Draft -->
                        <form action="{{ route('information.promote.draft', $promotion->id) }}" method="POST" onsubmit="return confirm('Yakin ingin memindahkan promo ke Draft?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-warning custom-btn">
                                Draft
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada data promosi yang tersedia.</p>
            </div>
            @endforelse
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

    $(document).ready(function() {
        $('#search-promo').on('input', function() {
            const query = $(this).val().toLowerCase();
            $('.promo-card').each(function() {
                const title = $(this).data('title').toLowerCase();
                const description = $(this).data('description') ? $(this).data('description').toLowerCase() : '';
                
                // Periksa apakah query cocok dengan judul atau deskripsi
                if (title.includes(query) || description.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endpush