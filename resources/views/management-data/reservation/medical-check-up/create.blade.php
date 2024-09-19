@extends('management-data.layouts.app')

@section('title', 'Tambah Data Paket MCU')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Tambah Paket MCU</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reservation.mcu.index') }}">Medical Check Up</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Tambah Paket MCU</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 2rem;">
                <form action="{{ route('reservation.mcu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="page" value="{{ $services->currentPage() }}">
                    <!-- Nama MCU -->
                    <div class="mb-3">
                        <label for="namaMCU" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="namaMCU" name="title" value="{{ old('title') }}" placeholder="Masukkan Nama MCU">
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Harga MCU -->
                    <div class="mb-3">
                        <label for="hargaMCU" class="form-label">Harga Paket</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="hargaMCU" name="price" value="{{ old('price') }}" placeholder="Masukkan Harga Paket">
                        @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Deskripsi MCU -->
                    <div class="mb-3">
                        <label for="deskripsiMCU" class="form-label">Deskripsi MCU</label>
                        <input id="deskripsiMCU" type="hidden" name="description" value="{{ old('description') }}">
                        <trix-editor input="deskripsiMCU" placeholder="Masukkan Deskripsi MCU"></trix-editor>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Informasi Penting MCU -->
                    <div class="mb-3">
                        <label for="infoPentingMCU" class="form-label">Informasi Penting MCU</label>
                        <input id="infoPentingMCU" type="hidden" name="special_information" value="{{ old('special_information') }}">
                        <trix-editor input="infoPentingMCU" placeholder="Masukkan Informasi Penting MCU"></trix-editor>
                        @error('special_information')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Foto Paket -->
                    <div class="mb-3">
                        <label for="fotoMCU" class="form-label">Upload Media MCU</label>
                        <input type="file" class="form-control @error('media') is-invalid @enderror" id="fotoMCU" name="media" accept="image/*">
                        @error('media')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <!-- Preview Gambar -->
                        <div id="imagePreview" class="mt-2">
                            <!-- Preview gambar akan ditampilkan di sini -->
                        </div>
                    </div>

                    <!-- URL Reservasi -->
                    <div class="mb-3">
                        <label for="urlReservasi" class="form-label">URL Reservasi</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="urlReservasi" name="address" value="{{ old('address') }}" placeholder="Masukkan URL Reservasi">
                        @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Save Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success"
                            style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Simpan
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

        // JavaScript untuk Preview Gambar
        $('#fotoMCU').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').html(`
                        <img src="${e.target.result}" alt="Preview Media" style="max-width: 150px; height: auto;">
                        <small>${file.name}</small>
                    `);
                };
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').html('');
            }
        });
    });
</script>
@endpush

@push('styles')
<!-- Tidak perlu menambahkan CDN Trix lagi karena sudah ada di file app -->
@endpush