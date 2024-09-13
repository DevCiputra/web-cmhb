@include('manajemen_data.layouts.dashboard')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Tambah Paket MCU</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_mcu ">Medical Check Up</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Tambah Paket MCU</li>
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
                    <!-- Nama MCU -->
                    <div class="mb-3">
                        <label for="namaMCU" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control" id="namaMCU" placeholder="Masukkan Nama MCU">
                    </div>

                    <!-- Harga MCU -->
                    <div class="mb-3">
                        <label for="hargaMCU" class="form-label">Harga Paket</label>
                        <input type="text" class="form-control" id="namaMCU" placeholder="Masukkan Nama MCU">
                    </div>

                    <!-- Deskripsi MCU -->
                    <div class="mb-3">
                        <label for="deskripsiMCU" class="form-label">Deskripsi MCU</label>
                        <textarea class="form-control" id="deskripsiMCU" rows="4" placeholder="Masukkan Deskripsi MCU"></textarea>
                    </div>

                    <!-- Foto Paket -->
                    <div class="mb-3">
                        <label for="fotoMCU" class="form-label">Upload Media MCU</label>
                        <input type="file" class="form-control" id="fotoMCU" accept="image/*"
                            placeholder="Upload Foto MCU">
                    </div>

                    <!-- URL Reservasi -->
                    <div class="mb-3">
                        <label for="urlReservasi" class="form-label">URL Reservasi</label>
                        <input type="text" class="form-control" id="urlReservasi"
                            placeholder="Masukkan URL Reservasi">
                    </div>

                    <!-- Save Button -->
                    <div class="d-flex justify-content-end">
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
        $('#deskripsiMCU').summernote({
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
</script>
