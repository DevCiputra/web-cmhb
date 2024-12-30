@extends('management-data.layouts.app')

@section('title', 'Daftar Kategori Informasi')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Kategori Informasi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Kategori Informasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="d-flex mb-3">
                    <h5 class="card-title-screening" style="color: #1C3A6B"><b>Daftar Kategori Informasi</b></h5>
                    <div class="ms-auto">
                        <a href="{{ route('information-categories.create') }}" style="text-decoration: none;">
                            <button class="btn btn-md btn-success" style="border-radius: 10px;">
                                <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                Tambah Kategori
                            </button>
                        </a>
                    </div>
                </div>
                <p class="card-text">Berikut merupakan daftar Kategori Informasi.</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if($category->information()->exists())
                                <span class="badge bg-danger">Digunakan</span>
                                @else
                                <span class="badge bg-success">Tidak Digunakan</span>
                                @endif
                            </td>
                            <td>
                                @if(!$category->information()->exists())
                                <a href="{{ route('information-categories.edit', $category->id) }}"
                                    class="btn btn-warning btn-sm"
                                    style="border-radius: 8px; padding: 6px 12px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; height: 38px; margin-right: 8px;">
                                    Edit
                                </a>
                                <form action="{{ route('information-categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        style="border-radius: 8px; padding: 6px 12px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; height: 38px;"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        Hapus
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-secondary btn-sm" disabled
                                    style="border-radius: 8px; padding: 6px 12px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; height: 38px; margin-right: 8px;">
                                    Tidak Dapat Diedit
                                </button>
                                <button class="btn btn-secondary btn-sm" disabled
                                    style="border-radius: 8px; padding: 6px 12px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; height: 38px;">
                                    Tidak Dapat Dihapus
                                </button>
                                @endif
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
        const confirmed = confirm("Apakah Anda yakin ingin menghapus kategori ini?");
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