@extends('management-data.layouts.app')

@section('title', 'Edit Data Role')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Edit Role</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('role.data.index') }}">Role</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Role</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form" style="padding: 2rem;">
                <form action="{{ route('role.data.update', $role->id) }}" method="POST" onsubmit="return confirmSubmit();">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Role</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" placeholder="Masukkan Nama Role" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('role.data.index') }}" class="btn btn-secondary me-2" style="border-radius: 10px; padding: 8px 12px;">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
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
    });

    function confirmSubmit() {
        return confirm('Apakah Anda yakin ingin menyimpan perubahan ini?');
    }
</script>
@endpush