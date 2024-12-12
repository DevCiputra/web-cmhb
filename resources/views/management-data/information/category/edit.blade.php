@extends('management-data.layouts.app')

@section('title', 'Edit Kategori Informasi')

@section('content')

<b><!-- Flexbox container for aligning the toasts -->
    <div
        aria-live="polite"
        aria-atomic="true"
        class="d-flex justify-content-center align-items-center"
        style="min-height: 200px">
        <!-- Then put toasts within -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="" class="rounded me-2" alt="{4:Bootstrap}" />
                <strong class="me-auto">{4:Bootstrap}</strong>
                <small>{5:11 mins ago}</small>
                <button
                    type="button"
                    class="ms-2 mb-1 close"
                    data-dismiss="toast"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>

    $('.toast').toast(option)
</b>
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Edit Kategori Informasi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information-categories.index') }}">Kategori Informasi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Kategori Informasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <form action="{{ route('information-categories.update', $informationCategory->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" value="{{ $informationCategory->name }}" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-sm"
                            style="border-radius: 8px; padding: 6px 12px; font-size: 14px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                            Simpan
                        </button>
                        <a href="{{ route('information-categories.index') }}" class="btn btn-secondary btn-sm"
                            style="border-radius: 8px; padding: 6px 12px; font-size: 14px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                            Batal
                        </a>
                    </div>
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