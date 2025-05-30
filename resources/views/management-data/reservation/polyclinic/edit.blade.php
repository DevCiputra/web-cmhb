@include('manajemen_data.layouts.dashboard')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Edit Pendaftaran Poliklinik</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_poli">Pendaftaran Poliklinik</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Pendaftaran Poliklinik</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-form" style="padding: 2rem;">
                <form>
                    <!-- Nama Poliklinik -->
                    <div class="mb-3">
                        <label for="namaPoliklinik" class="form-label">Nama Poliklinik</label>
                        <input type="text" class="form-control" id="namaPoliklinik" placeholder="Masukkan Nama Poliklinik">
                    </div>

                    <!-- Deskripsi Poliklinik -->
                    <div class="mb-3">
                        <label for="deskripsiPoliklinik" class="form-label">Deskripsi Poliklinik</label>
                        <textarea class="form-control" id="deskripsiPoliklinik" rows="4" placeholder="Masukkan Deskripsi Poliklinik"></textarea>
                    </div>

                    <!-- URL Reservasi -->
                    <div class="mb-3">
                        <label for="urlReservasi" class="form-label">URL Reservasi</label>
                        <input type="text" class="form-control" id="urlReservasi" placeholder="Masukkan URL Reservasi">
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
        $('#deskripsiPoliklinik').summernote({
            height: 800, // Set the height of the editor
            placeholder: 'Masukkan Deskripsi Poliklinik',
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

