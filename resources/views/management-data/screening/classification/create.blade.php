@extends('management-data.layouts.app')

@section('title', 'Tambah Klasifikasi Skrining')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Tambah Klasifikasi Skrining</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Tambah Klasifikasi Skrining</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card">
            <div>
                <form action="{{ route('screening-classifications.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="category_name" class="form-label">Kategori:</label>
                        <select class="form-control" id="category_name" name="category_name" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category_name') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="classification_name" class="form-label">Nama Klasifikasi:</label>
                        <input type="text" class="form-control" id="classification_name" name="classification_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="min_score" class="form-label">Skor Minimum:</label>
                        <input type="number" class="form-control" id="min_score" name="min_score" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_score" class="form-label">Skor Maksimum:</label>
                        <input type="number" class="form-control" id="max_score" name="max_score" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
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