@extends('management-data.layouts.app')

@section('title', 'Informasi CMH')

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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Informasi RS</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/master-info-cmh">Master Data</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Informasi RS</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex mb-3">
                    <div class="ms-auto">
                        <a href="{{ route('information.data.create') }}" style="text-decoration: none;">
                            <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                                <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                Tambah
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Display -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="row">
                    @foreach($hospitalInformations as $information)
                    <div class="col-md-3 mb-4"> <!-- Ubah col-md-4 menjadi col-md-3 untuk menambah ukuran kartu -->
                        <div class="card" style="box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; height: 100%;"> <!-- Menambahkan height: 100% untuk menjaga konsistensi tinggi -->
                            @if($information->logo)
                            <img src="{{ asset('storage/' . $information->logo) }}" class="card-img-top" alt="{{ $information->name }}" style="height: 250px; object-fit: cover;"> <!-- Menambah tinggi gambar -->
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title-info">{{ $information->name }}</h5>
                                <div class="d-flex mt-2 ">
                                    <a href="{{ route('information.data.edit', $information->id) }}" class="btn btn-sm btn-success custom-btn me-2">Edit</a>
                                    <form action="{{ route('information.data.destroy', $information->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger custom-btn">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
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