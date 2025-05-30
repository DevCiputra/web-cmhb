@extends('management-data.layouts.app')

@section('title', 'Daftar Kategori Pertanyaan')

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
                    <h5 class="card-title-screening" style="color: #1C3A6B"><b>Daftar Kategori Pertanyaan</b></h5>
                    <div class="ms-auto">
                        <a href="{{ route('question-categories.create') }}"  style="text-decoration: none;">
                            <button class="btn btn-md btn-success" style="border-radius: 10px;">
                                <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                Tambah Kategori
                            </button>
                        </a>
                    </div>
                </div>
                <p class="card-text">Berikut merupakan daftar Kategori Pertanyaan Screening.</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ route('question-categories.edit', $category->id) }}" 
                                       class="btn btn-warning btn-sm" 
                                       style="border-radius: 8px; padding: 6px 12px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; height: 38px; margin-right: 8px;">
                                        Edit
                                    </a>
                                    <form action="{{ route('question-categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm" 
                                                style="border-radius: 8px; padding: 6px 12px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; height: 38px;" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>   
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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