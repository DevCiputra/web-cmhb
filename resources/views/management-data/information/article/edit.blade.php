@extends('management-data.layouts.app')

@section('title', ' Edit Article')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Edit Artikel</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information.article.index') }}">Artikel</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Artikel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-form" style="padding: 2rem;">
                <form>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control" id="article_title" placeholder="Masukkan Judul Artikel">
                    </div>

                    
                    <div class="mb-3">
                        <label for="article_categories" class="form-label">Kategori Artikel</label>
                        <input type="text" class="form-control" id="article_categories" placeholder="Masukkan Kategori Artikel">
                    </div>

                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Isi Artikel</label>
                        <textarea class="form-control" id="article_description" rows="4" placeholder="Masukkan Isi Artikel"></textarea>
                    </div>

    
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Artikel</label>
                        <input type="file" class="form-control" id="article_image" accept="image/*"
                            placeholder="Upload Foto Artikel">
                    </div>

                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger me-2"
                            style="background-color: #DC3545; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Hapus
                        </button>
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

<script>
    $(document).ready(function() {
        $('#article_description').summernote({
            height: 400, // Set the height of the editor
            placeholder: 'Masukkan Deskripsi MCU',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

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
