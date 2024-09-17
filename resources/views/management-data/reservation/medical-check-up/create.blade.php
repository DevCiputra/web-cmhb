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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Tambah Paket MCU</h4>
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

                {{-- Tampilkan Pesan Error Jika Ada --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('reservation.mcu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                        <textarea class="form-control @error('description') is-invalid @enderror" id="deskripsiMCU" name="description" rows="4" placeholder="Masukkan Deskripsi MCU">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Foto Paket -->
                    <div class="mb-3">
                        <label for="fotoMCU" class="form-label">Upload Media MCU</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="fotoMCU" name="photo" accept="image/*">
                        @error('photo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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

@endsection