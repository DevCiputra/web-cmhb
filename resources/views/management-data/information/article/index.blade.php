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
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Artikel</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Informasi</a></li>
                            <li class="breadcrumb-item active" style="color: #023770">Artikel</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="text" class="form-control" placeholder="Cari data" style="max-width: 200px;">
                    <a href="{{ route('information.article.create') }}" style="text-decoration: none;">
                        <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                            <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                            Tambah
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="row cards-container">
            @forelse ($articles as $article)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top-article"
                        src="{{ $article->media->isNotEmpty() ? asset('storage/articles/' . $article->media->first()->file_name) : asset('images/default.png') }}"
                        alt="Artikel Image">

                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">{{ $article->title }}</h5>
                            <div class="icon-group">
                                <a href="{{ route('information.article.edit', $article->id) }}" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit" class="pencil-icon">
                                </a>
                                <a href="{{ route('information.article.detail', $article->id) }}" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="View" class="eye-icon">
                                </a>
                                <form action="{{ route('information.article.delete', $article->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-delete btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="Delete" class="trash-icon">
                                    </button>
                                </form>
                            </div>

                        </div>
                        <p class="description">{{ Str::limit($article->description, 100, '...') }}</p>
                        <div class="btn-group">
                            @if($article->is_published == '1')
                            <!-- Tombol Draft -->
                            <form action="{{ route('information.article.draft', $article->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin mendraft artikel ini?')">
                                    Draft
                                </button>
                            </form>
                            @else
                            <!-- Tombol Publish -->
                            <form action="{{ route('information.article.publish', $article->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin mempublish artikel ini?')">
                                    Publish
                                </button>
                            </form>
                            @endif
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
</style>
@endpush