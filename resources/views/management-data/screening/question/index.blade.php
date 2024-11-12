@extends('management-data.layouts.app')

@section('title', 'Soal Skrining')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Soal Skrining</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Soal Skrining</li>
                        </ol>
                    </nav>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('screening-depretion.index') }}" method="GET">
                        <div class="d-flex align-items-center">
                            <select name="category_id" class="form-control me-2" style="width: 500px;">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 10px 12px; border: none;">Filter</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="d-flex mb-3">
                    <h5 class="card-title-screening" style="color: #1C3A6B"><b>Daftar Soal Skrining </b></h5>
                    <div class="ms-auto">
                        <a href="{{ route('screening-depretion.create') }}" style="text-decoration: none;">
                            <button class="btn btn-md btn-success" style="border-radius: 10px;">
                                <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                Tambah Soal
                            </button>
                        </a>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <p class="card-text">Berikut merupakan daftar soal skrinin. dalam bentuk card yang interaktif.</p>
                </div>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach($questions as $question)
                    <div class="col">
                        <div class="card h-100" style="border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <h5 class="card-title-screening" style="color: #1C3A6B;">{{ $question->question_text }}</h5>
                                <p class="card-text">
                                    <span class="text-muted">Kategori: {{ $question->category->name }}</span>
                                    @if($question->options->isEmpty())
                                    <span class="text-muted">Opsi belum dibuat</span>
                                    @else
                                <ul>
                                    @foreach($question->options as $option)
                                    <li>{{ $option->option_text }} - Bobot: {{ $option->weight }}</li>
                                    @endforeach
                                </ul>
                                @endif
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('screening-depretion.edit', $question->id) }}" class="btn btn-sm btn-secondary custom-btn">
                                    Edit Pertanyaan
                                </a>
                                <form action="{{ route('screening-depretion.destroy', $question->id) }}" method="POST" onsubmit="return confirmDeletion(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm custom-btn btn-danger">
                                        Hapus
                                    </button>
                                </form>
                                <a href="{{ route('screening-depretion.screening-options.index', $question->id) }}" class="btn btn-sm btn-info custom-btn">
                                    Kelola Opsi
                                </a>
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