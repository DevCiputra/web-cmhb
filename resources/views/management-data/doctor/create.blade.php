@extends('management-data.layouts.app')

@section('title', 'Tambah Data Dokter')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Tambah Data Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/doctor-data">Dokter</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Tambah Data Dokter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 2rem;">
                <form action="{{ route('doctor.data.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Dokter</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Dokter" required value="{{ old('name') }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="specialization_name" class="form-label">Spesialis</label>
                        <input type="text" class="form-control" id="specialization_name" name="specialization_name" placeholder="Masukkan Spesialis" required value="{{ old('specialization_name') }}">
                        @error('specialization_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="education" class="form-label">Latar Belakang Pendidikan</label>
                        <textarea class="form-control" id="education" name="education" rows="4" placeholder="Masukkan Latar Belakang Pendidikan">{{ $doctor->education->name ?? '' }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label for="doctor_polyclinic_id" class="form-label">Poliklinik</label>
                        <select class="form-select" id="doctor_polyclinic_id" name="doctor_polyclinic_id" required>
                            <option value="">Pilih Poliklinik</option>
                            @foreach($polyclinics as $polyclinic)
                            <option value="{{ $polyclinic->id }}">{{ $polyclinic->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_polyclinic_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="education" class="form-label">Latar Belakang Pendidikan</label>
                        <textarea class="form-control" id="education" name="education" rows="4" placeholder="Masukkan Latar Belakang Pendidikan" required>{{ old('education') }}</textarea>
                        @error('education')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Hari dan Jam Praktek -->
                    <div class="mb-3">
                        <label for="doctor_schedule" class="form-label">Jadwal Praktek</label>
                        <div id="schedule-container">
                            <div class="schedule-row mb-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="day" class="form-label">Hari</label>
                                        <select name="doctor_schedule[days][]" class="form-select" required>
                                            <option value="">Pilih Hari</option>
                                            <option value="Monday">Senin</option>
                                            <option value="Tuesday">Selasa</option>
                                            <option value="Wednesday">Rabu</option>
                                            <option value="Thursday">Kamis</option>
                                            <option value="Friday">Jumat</option>
                                            <option value="Saturday">Sabtu</option>
                                            <option value="Sunday">Minggu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="start_time" class="form-label">Jam Mulai</label>
                                        <input type="time" class="form-control" name="doctor_schedule[start_time][]" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_time" class="form-label">Jam Selesai</label>
                                        <input type="time" class="form-control" name="doctor_schedule[end_time][]" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-schedule" class="btn btn-primary">Tambah Jadwal</button>
                    </div>

                    <!--
                    <div class="mb-3">
                        <label for="operation_rate" class="form-label">Angka Keberhasilan Operasi</label>
                        <input type="text" class="form-control" id="operation_rate" name="operation_rate" placeholder="Masukkan Angka Keberhasilan Operasi" required value="{{ old('operation_rate') }}">
                        @error('operation_rate')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> -->

                    <div class="mb-3">
                        <label for="doctor_photos" class="form-label">Foto Dokter</label>
                        <input type="file" class="form-control" id="doctor_photos" name="doctor_photos" accept="image/*" required>
                        @error('doctor_photos')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="doctor_medias" class="form-label">Curriculum Vitae</label>
                        <input type="file" class="form-control" id="doctor_medias" name="doctor_medias" accept=".pdf,.doc,.docx" required>
                        @error('doctor_medias')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
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
        let scheduleCount = 1; // Counter untuk jadwal

        $('#add-schedule').on('click', function() {
            // Buat elemen baru untuk baris jadwal
            const newScheduleRow = `
                <div class="schedule-row mb-2">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="day" class="form-label">Hari</label>
                            <select name="doctor_schedule[days][]" class="form-select" required>
                                <option value="">Pilih Hari</option>
                                <option value="Monday">Senin</option>
                                <option value="Tuesday">Selasa</option>
                                <option value="Wednesday">Rabu</option>
                                <option value="Thursday">Kamis</option>
                                <option value="Friday">Jumat</option>
                                <option value="Saturday">Sabtu</option>
                                <option value="Sunday">Minggu</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="start_time" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" name="doctor_schedule[start_time][]" required>
                        </div>
                        <div class="col-md-4">
                            <label for="end_time" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" name="doctor_schedule[end_time][]" required>
                        </div>
                    </div>
                </div>`;
            // Tambahkan baris baru ke container
            $('#schedule-container').append(newScheduleRow);
            scheduleCount++;
        });
    });
</script>

@endpush