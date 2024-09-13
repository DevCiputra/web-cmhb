@include('manajemen_data.layouts.dashboard')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Edit Promo</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_promosi ">Promo</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Promo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 2rem;">
                <form>
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="promo_title" class="form-label">Judul Promo</label>
                        <input type="text" class="form-control" id="promo_title" placeholder="Masukkan Judul Promo">
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="promo_categories" class="form-label">Kategori Promo</label>
                        <input type="text" class="form-control" id="promo_categories" placeholder="Masukkan Kategori Promo">
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="promo_description" class="form-label">Deskripsi Promo</label>
                        <textarea class="form-control" id="promo_description" rows="4" placeholder="Masukkan Deskripsi Promo"></textarea>
                    </div>

                    <!-- Foto Promo -->
                    <div class="mb-3">
                        <label for="promo_image" class="form-label">Foto Promo</label>
                        <input type="file" class="form-control" id="promo_image" accept="image/*"
                            placeholder="Upload Foto Promo">
                    </div>

                    <!-- Save Button -->
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

<script>
    $(document).ready(function() {
        $('#promo_description').summernote({
            height: 400, // Set the height of the editor
            placeholder: 'Masukkan Deskripsi Promo',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
