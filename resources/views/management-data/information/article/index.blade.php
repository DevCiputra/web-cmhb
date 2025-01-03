@extends('management-data.layouts.app')

@section('title', 'Article')

@section('content')
    <div class="dashboard-app">
        <header class="dashboard-toolbar">
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        </header>
        <div class="dashboard-content">

            <!-- Flash message display -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <!-- Left Side: Title and Breadcrumb -->
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Artikel</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                                <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                                <li class="breadcrumb-item" style="color: #023770">Artikel</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Right Side: Filter and Add Button -->
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <form method="GET" action="{{ url()->current() }}">
                            <div class="row">
                                <!-- Search Bar -->
                                <div class="col-md-8 mb-2">
                                    <input id="search-bar" type="text" name="keyword" class="form-control"
                                        placeholder="Cari Artikel..." value="{{ request('keyword') }}">
                                </div>
                                <!-- Filter Dropdown -->
                                <div class="col-md-4">
                                    <select name="flag" id="flag" class="form-select" onchange="this.form.submit()">
                                        <option value="" {{ request('flag') == '' ? 'selected' : '' }}>Semua Kategori
                                        </option>
                                        <option value="Artikel Kesehatan"
                                            {{ request('flag') == 'Artikel Kesehatan' ? 'selected' : '' }}>Artikel Kesehatan
                                        </option>
                                        <option value="Tips Kesehatan"
                                            {{ request('flag') == 'Tips Kesehatan' ? 'selected' : '' }}>Tips Kesehatan
                                        </option>
                                        <option value="Event" {{ request('flag') == 'Event' ? 'selected' : '' }}>Event
                                        </option>
                                    </select>

                                    <!-- Dropdown Order By -->
                                    <select name="order_by" id="order_by" class="form-select"
                                        onchange="this.form.submit()">
                                        <option value="newest" {{ request('order_by') == 'newest' ? 'selected' : '' }}>
                                            Terbaru</option>
                                        <option value="oldest" {{ request('order_by') == 'oldest' ? 'selected' : '' }}>
                                            Terlama</option>
                                    </select>
                                </div>
                            </div>
                        </form>





                        <!-- Add Button -->
                        <a href="{{ route('information.article.create') }}" style="text-decoration: none;">
                            <button class="btn btn-md"
                                style="background-color: #007858; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                                <img src="{{ asset('icons/plus.svg') }}" width="16" height="16"
                                    style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                Tambah
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row cards-container">
                @forelse ($articles as $article)
                    <div class="col-md-3 mb-4 card-item" card-title="{{ strtolower($article->title) }}"
                        data-description="{{ strtolower($article->description) }}">
                        <div class="card">
                            <img class="card-img-top-article"
                                src="{{ $article->media->isNotEmpty() ? asset('storage/articles/' . $article->media->first()->file_name) : asset('images/default.png') }}"
                                alt="Artikel Image">
                            <div class="card-body">
                                <div class="header-container">
                                    <h5 class="title"
                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                                        {{ strlen($article->title) > 30 ? substr($article->title, 0, 30) . '...' : $article->title }}
                                    </h5>
                                    <div class="icon-group">
                                        <a href="{{ route('information.article.edit', $article->id) }}"
                                            class="btn btn-edit">
                                            <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit"
                                                class="pencil-icon">
                                        </a>
                                        <a href="{{ route('information.article.detail', $article->id) }}"
                                            class="btn btn-view">
                                            <img src="{{ asset('icons/eye.svg') }}" alt="View" class="eye-icon">
                                        </a>
                                    </div>
                                </div>
                                <p class="text-muted mb-2">
                                    Dibuat: {{ $article->created_at->format('d M Y H:i') }} <br>
                                    Diedit: {{ $article->updated_at->format('d M Y H:i') }} <br>
                                    Status:
                                    @if ($article->is_published)
                                        <span class="text-success">Dipublikasikan</span>
                                    @else
                                        <span class="text-danger">Belum Dipublikasikan</span>
                                    @endif
                                </p>
                                <div class="d-flex justify-content-end align-items-center">
                                    @if ($article->is_published == '1')
                                        <!-- Tombol Draft -->
                                        <form action="{{ route('information.article.draft', $article->id) }}"
                                            method="POST" style="display: inline; margin-right: 8px;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-end"
                                                onclick="return confirm('Apakah Anda yakin ingin mendraft artikel ini?')">
                                                Draft
                                            </button>
                                        </form>
                                    @else
                                        <!-- Tombol Publish -->
                                        <form action="{{ route('information.article.publish', $article->id) }}"
                                            method="POST" style="display: inline; margin-right: 8px;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-end"
                                                onclick="return confirm('Apakah Anda yakin ingin mempublish artikel ini?')">
                                                Publish
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('information.article.delete', $article->id) }}" method="POST"
                                        style="display: inline; ">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-end"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Tidak ada artikel yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {!! $articles->links() !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#search-bar").on("input", function() {
                let searchTerm = $(this).val().toLowerCase()
            .trim(); // Ambil input, ubah ke huruf kecil, dan hilangkan spasi berlebih
                $(".card-item").each(function() {
                    let title = $(this).attr("card-title")
                .toLowerCase(); // Ambil atribut 'card-title' dari elemen card

                    if (title.includes(searchTerm)) { // Cek apakah judul mengandung teks pencarian
                        $(this).show(); // Tampilkan card
                    } else {
                        $(this).hide(); // Sembunyikan card
                    }
                });
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
    </script>
@endpush
