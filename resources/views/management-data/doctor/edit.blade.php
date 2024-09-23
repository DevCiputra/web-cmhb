@extends('management-data.layouts.app')

@section('title', 'Edit Data Dokter')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Edit Data Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_dokter">Dokter</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Data Dokter</li>
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
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Dokter</label>
                        <input type="text" class="form-control" id="name" placeholder="Masukkan Nama Dokter">
                    </div>

                    <div class="mb-3">
                        <label for="specialist" class="form-label">Spesialis</label>
                        <input type="text" class="form-control" id="specialist" placeholder="Masukkan Spesialis">
                    </div>

                    <div class="mb-3">
                        <label for="education" class="form-label">Latar Belakang Pendidikan</label>
                        <textarea class="form-control" id="education" rows="4" placeholder="Masukkan Latar Belakang Pendidikan"></textarea>
                    </div>

                    <!-- Jadwal Praktek -->
                    <div class="mb-3">
                        <label for="doctor_schedule" class="form-label">Jadwal Praktek</label>
                        <div id="doctor_schedule">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="senin">
                                <label class="form-check-label" for="senin">
                                    Senin
                                </label>
                                <div class="d-flex">
                                    <input type="time" class="form-control me-2" id="senin_start">
                                    <input type="time" class="form-control" id="senin_end">
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="selasa">
                                <label class="form-check-label" for="selasa">
                                    Selasa
                                </label>
                                <div class="d-flex">
                                    <input type="time" class="form-control me-2" id="selasa_start">
                                    <input type="time" class="form-control" id="selasa_end">
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="rabu">
                                <label class="form-check-label" for="rabu">
                                    Rabu
                                </label>
                                <div class="d-flex">
                                    <input type="time" class="form-control me-2" id="rabu_start">
                                    <input type="time" class="form-control" id="rabu_end">
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="kamis">
                                <label class="form-check-label" for="kamis">
                                    Kamis
                                </label>
                                <div class="d-flex">
                                    <input type="time" class="form-control me-2" id="kamis_start">
                                    <input type="time" class="form-control" id="kamis_end">
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="jumat">
                                <label class="form-check-label" for="jumat">
                                    Jum'at
                                </label>
                                <div class="d-flex">
                                    <input type="time" class="form-control me-2" id="jumat_start">
                                    <input type="time" class="form-control" id="jumat_end">
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="sabtu">
                                <label class="form-check-label" for="sabtu">
                                    Sabtu
                                </label>
                                <div class="d-flex">
                                    <input type="time" class="form-control me-2" id="sabtu_start">
                                    <input type="time" class="form-control" id="sabtu_end">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="operation_rate" class="form-label">Angka Keberhasilan Operasi</label>
                        <input type="text" class="form-control" id="operation_rate" placeholder="Masukkan Angka Keberhasilan Operasi">
                    </div>

                    <div class="mb-3">
                        <label for="doctor_photos" class="form-label">Foto Dokter</label>
                        <input type="file" class="form-control" id="doctor_photos" accept="image/*" placeholder="Upload Foto Dokter">
                    </div>

                    <div class="mb-3">
                        <label for="doctor_medias" class="form-label">Curriculum Vitae</label>
                        <input type="file" class="form-control" id="doctor_medias" accept="image/*, video/*" placeholder="Upload Curriculum Vitae">
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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

<script>
    $(document).ready(function() {
        $('#education').summernote({
            height: 400, // Set the height of the editor
            placeholder: 'Masukkan Latar Belakang Pendidikan',
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
@endpush
