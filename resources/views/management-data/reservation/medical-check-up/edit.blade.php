@extends('management-data.layouts.app')

@section('title', 'Edit Data Paket MCU')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Edit Paket MCU</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reservation.mcu.index') }}">Medical Check Up</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Paket MCU</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 2rem;">
                <form action="{{ route('reservation.mcu.edit', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama MCU -->
                    <div class="mb-3">
                        <label for="namaMCU" class="form-label">Nama Paket</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="namaMCU" placeholder="Masukkan Nama MCU" value="{{ old('name', $mcu->name) }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Harga MCU -->
                    <div class="mb-3">
                        <label for="hargaMCU" class="form-label">Harga Paket</label>
                        <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="hargaMCU" placeholder="Masukkan Harga Paket" value="{{ old('price', $mcu->price) }}">
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi MCU -->
                    <div class="mb-3">
                        <label for="deskripsiMCU" class="form-label">Deskripsi MCU</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="deskripsiMCU" rows="4" placeholder="Masukkan Deskripsi MCU">{{ old('description', $mcu->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto Paket -->
                    <div class="mb-3">
                        <label for="fotoMCU" class="form-label">Upload Media MCU</label>
                        <input type="file" name="media" class="form-control @error('media') is-invalid @enderror" id="fotoMCU" accept="image/*">
                        @if($mcu->media)
                        <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $mcu->media) }}" target="_blank">{{ $mcu->media }}</a></small>
                        @endif
                        @error('media')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- URL Reservasi -->
                    <div class="mb-3">
                        <label for="urlReservasi" class="form-label">URL Reservasi</label>
                        <input type="text" name="reservation_url" class="form-control @error('reservation_url') is-invalid @enderror" id="urlReservasi" placeholder="Masukkan URL Reservasi" value="{{ old('reservation_url', $mcu->reservation_url) }}">
                        @error('reservation_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Save Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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