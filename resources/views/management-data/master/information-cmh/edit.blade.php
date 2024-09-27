@extends('management-data.layouts.app')

@section('title', 'Edit Data Informasi')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Edit Informasi RS</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Master Data</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information.data.index') }}">Informasi RS</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Informasi RS</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-form" style="padding: 2rem;">
                <form action="{{ route('information.data.update', $information->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $information->name }}" placeholder="Masukkan Nama">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $information->address }}" placeholder="Masukkan Alamat">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $information->phone }}" placeholder="Masukkan Nomor Telepon">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $information->email }}" placeholder="Masukkan Email">
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Upload Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*" placeholder="Upload Foto Logo">
                        @if($information->logo)
                        <img src="{{ asset('storage/' . $information->logo) }}" width="100" height="100" alt="Logo">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="vision" class="form-label">Vision</label>
                        <input type="text" class="form-control" id="vision" name="vision" value="{{ $information->vision }}" placeholder="Masukkan Visi">
                    </div>
                    <div class="mb-3">
                        <label for="mission" class="form-label">Mission</label>
                        <input type="text" class="form-control" id="mission" name="mission" value="{{ $information->mission }}" placeholder="Masukkan Misi">
                    </div>
                    <div class="mb-3">
                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ $information->emergency_contact }}" placeholder="Masukkan Kontak Darurat">
                    </div>
                    <div class="mb-3">
                        <label for="customer_service_contact" class="form-label">Customer Service Contact</label>
                        <input type="text" class="form-control" id="customer_service_contact" name="customer_service_contact" value="{{ $information->customer_service_contact }}" placeholder="Masukkan Kontak Layanan Pelanggan">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

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