@extends('management-data.layouts.app')

@section('title', 'Klasifikasi Skrining')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Klasifikasi Skrining</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Klasifikasi Skrining</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div>
                <div class="d-flex mb-3">
                    <h5 class="card-title" style="color: #1C3A6B"><b>Daftar Klasifikasi Skrining</b></h5>
                    <div class="ms-auto">
                        <form method="GET" action="{{ route('screening-classifications.index') }}">
                            <select class="form-control" name="category_filter" onchange="this.form.submit()">
                                <option value="">Filter berdasarkan Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category_filter') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('screening-classifications.create') }}" style="text-decoration: none;">
                            <button class="btn btn-md btn-success" style="border-radius: 10px;">
                                <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                Tambah Klasifikasi
                            </button>
                        </a>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <p class="card-text">Berikut merupakan daftar klasifikasi skrining yang tersedia.</p>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Klasifikasi</th>
                            <th>Skor Minimum</th>
                            <th>Skor Maksimum</th>
                            <th>Kategori</th> <!-- Kolom kategori -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classifications as $classification)
                        <tr>
                            <td>{{ $classification->classification_name }}</td>
                            <td>{{ $classification->min_score }}</td>
                            <td>{{ $classification->max_score }}</td>
                            <td>{{ $classification->category_name }}</td> <!-- Menampilkan kategori -->
                            <td>
                                <a href="{{ route('screening-classifications.edit', $classification->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('screening-classifications.destroy', $classification->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klasifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeletion(event) {
        event.preventDefault(); // Prevent form submission
        const confirmed = confirm("Apakah Anda yakin ingin menghapus soal ini?");
        if (confirmed) {
            event.target.submit(); // Submit form if confirmed
        }
    }
</script>

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