@extends('management-data.layouts.app')

@section('title', 'Tambah Opsi Skrining untuk Soal: ' . $question->question_text)

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Tambah Opsi Skrining</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('screening-depretion.index') }}">Daftar Soal Skrining</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('screening-depretion.screening-options.index', $question->id) }}">Daftar Opsi Soal</a></li>
                            <li class="breadcrumb-item active" style="color: #023770">Tambah Opsi</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('screening-depretion.screening-options.index', $question->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <!-- <div class="card-body"> -->
            <h5 class="mb-4 fw-normal" style="color: #1C3A6B;">Tambah Opsi untuk Soal: {{ $question->question_text }}</h5>

            <form action="{{ route('screening-depretion.screening-options.store', $question->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="option_text" class="form-label">Opsi</label>
                    <input type="text" name="option_text" class="form-control" required placeholder="Masukkan opsi...">
                </div>

                <div class="mb-3">
                    <label for="weight" class="form-label">Bobot</label>
                    <input type="number" name="weight" class="form-control" required placeholder="Masukkan bobot...">
                </div>

                <button type="submit" class="btn btn-success w-100">Simpan</button>
            </form>
            <!-- </div> -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeletion(event) {
        event.preventDefault();
        const confirmed = confirm("Apakah Anda yakin ingin menghapus opsi ini?");
        if (confirmed) {
            event.target.submit();
        }
    }
</script>

<script>
    const mobileScreen = window.matchMedia("(max-width: 990px)");
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