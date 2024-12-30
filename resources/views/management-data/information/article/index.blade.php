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
                        <!-- Filter Dropdown -->
                        <form method="GET" action="{{ route('information.article.index') }}" class="mb-0">
                            <div class="input-group">
                                <select name="flag" id="flag" class="form-select" onchange="this.form.submit()">
                                    <option value="" {{ request('flag') == '' ? 'selected' : '' }}>Semua Kategori
                                    </option>
                                    <option value="Artikel Kesehatan"
                                        {{ request('flag') == 'Artikel Kesehatan' ? 'selected' : '' }}>Artikel Kesehatan
                                    </option>
                                    <option value="Tips Kesehatan"
                                        {{ request('flag') == 'Tips Kesehatan' ? 'selected' : '' }}>Tips Kesehatan</option>
                                    <option value="Event" {{ request('flag') == 'Event' ? 'selected' : '' }}>Event</option>
                                </select>
                            </div>
                        </form>

                        <!-- Search Bar -->
                        <input id="search-bar" type="text" class="form-control" placeholder="Cari data"
                            style="max-width: 200px;">

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
                    <div class="col-md-3 mb-4 card-item"
                        title card-title="{{ strtolower($article->title) }}"
                        data-description="{{ strtolower($article->description) }}">
                        <div class="card">
                            <img class="card-img-top-article"
                                src="{{ $article->media->isNotEmpty() ? asset('storage/articles/' . $article->media->first()->file_name) : asset('images/default.png') }}"
                                alt="Artikel Image">
                            <div class="card-body">
                                <div class="header-container">
                                    <h5 class="title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
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
            $("#search-bar").on("input", function() {
                let searchTerm = $(this).val().toLowerCase(); // Ambil nilai input dan ubah ke huruf kecil
                $(".card-item").each(function() {
                    let title = $(this).data("title"); // Ambil data judul
                    let description = $(this).data("description"); // Ambil data deskripsi

                    // Tampilkan kartu jika judul atau deskripsi cocok dengan pencarian
                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        const titleElement = document.getElementById("card-title");
        const maxLength = 50;

        if (titleElement.textContent.length > maxLength) {
            titleElement.textContent = titleElement.textContent.slice(0, maxLength) + "...";
        }
    </script>
@endpush

@push('styles')
    <style>
        .btn-delete {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .trash-icon {
            width: 16px;
            height: 16px;
            filter: invert(100%);
        }

        /* Media query untuk layar dengan lebar maksimum 1200px */
/* Media query untuk layar dengan lebar maksimum 1200px */
@media (max-width: 1200px) {
    .card-item {
        flex: 0 0 48%; /* Setiap kartu menggunakan 48% dari lebar container */
        max-width: 48%;
        margin-bottom: 20px;
    }
}

/* Media query untuk layar dengan lebar maksimum 768px */
@media (max-width: 768px) {
    .card-item {
        flex: 0 0 100%; /* Setiap kartu menggunakan 100% dari lebar container */
        max-width: 100%;
        margin-bottom: 15px;
    }

    .card {
        margin: 0 auto; /* Untuk memusatkan kartu jika diperlukan */
    }

    .card-img-top-article {
        height: auto; /* Pastikan gambar tetap proporsional */
    }
}

/* Media query untuk layar dengan lebar maksimum 576px */
@media (max-width: 576px) {
    .card-item {
        padding: 10px; /* Tambahkan padding untuk tampilan lebih rapi */
    }

    .card-body {
        padding: 10px; /* Sesuaikan padding di dalam kartu */
    }

    .btn {
        font-size: 14px; /* Sesuaikan ukuran font tombol */
        padding: 6px 10px; /* Kurangi padding tombol agar sesuai */
    }
}


    </style>
@endpush
