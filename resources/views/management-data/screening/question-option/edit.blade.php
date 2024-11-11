@extends('management-data.layouts.app')

@section('title', 'Edit Opsi Skrining untuk Soal: ' . $question->question_text)

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Edit Opsi Skrining</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('screening-depretion.index') }}">Daftar Soal Skrining</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('screening-depretion.screening-options.index', $question->id) }}">Daftar Opsi Soal</a></li>
                            <li class="breadcrumb-item active" style="color: #023770">Edit Opsi</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('screening-depretion.screening-options.index', $question->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div style="background-color: #F9F9F9; border-radius: 10px; padding: 20px;">
                <h5 class="mb-4 fw-normal" style="color: #1C3A6B;">Edit Opsi untuk Soal: {{ $question->question_text }}</h5>

                <form action="{{ route('screening-depretion.screening-options.update', ['question' => $question->id, 'option' => $option->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="option_text" class="form-label">Opsi</label>
                        <input type="text" name="option_text" class="form-control" value="{{ $option->option_text }}" required style="border-radius: 8px; border: 1px solid #ddd; padding: 10px;" placeholder="Masukkan opsi...">
                    </div>

                    <div class="mb-3">
                        <label for="weight" class="form-label">Bobot</label>
                        <input type="number" name="weight" class="form-control" value="{{ $option->weight }}" required style="border-radius: 8px; border: 1px solid #ddd; padding: 10px;" placeholder="Masukkan bobot...">
                    </div>

                    <button type="submit" class="btn btn-success w-100" style="border-radius: 8px;">Update</button>
                </form>
            </div>
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