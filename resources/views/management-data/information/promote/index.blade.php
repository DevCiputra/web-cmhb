@extends('management-data.layouts.app')

@section('title', 'Polyclinic')

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
                    <a href="/tambah_promosi" style="text-decoration: none;">
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
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/promo1.jpg') }}" alt="Promo Image">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">Promo Title 1</h5>
                            <div class="icon-group">
                                <a href="/edit_promosi" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit Promo"
                                        class="pencil-icon">
                                </a>
                                <a href="/view_promosi" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="View Promo" class="eye-icon">
                                </a>
                            </div>
                        </div>
                        <p class="description">Promo description goes here.</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/promo2.jpg') }}" alt="Promo Image">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">Promo Title 2</h5>
                            <div class="icon-group">
                                <a href="/edit_promosi" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit Promo"
                                        class="pencil-icon">
                                </a>
                                <a href="/view_promosi" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="View Promo" class="eye-icon">
                                </a>
                            </div>
                        </div>
                        <p class="description">Promo description goes here.</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/promo3.jpg') }}" alt="Promo Image">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">Promo Title 3</h5>
                            <div class="icon-group">
                                <a href="/edit_promosi" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit Promo"
                                        class="pencil-icon">
                                </a>
                                <a href="/view_promosi" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="View Promo" class="eye-icon">
                                </a>
                            </div>
                        </div>
                        <p class="description">Promo description goes here.</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/promo1.jpg') }}" alt="Promo Image">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">Promo Title 4</h5>
                            <div class="icon-group">
                                <a href="/edit_promosi" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Edit Promo"
                                        class="pencil-icon">
                                </a>
                                <a href="/view_promosi" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="View Promo" class="eye-icon">
                                </a>
                            </div>
                        </div>
                        <p class="description">Promo description goes here.</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
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