@extends('management-data.layouts.app')

@section('title', 'Tambah Data Dokter')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Tambah Data Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
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
            <div class="card-form" style="padding: 2rem;">
                <form action="{{ route('doctor.data.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Dokter</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Dokter</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Masukkan Nama Dokter" required value="{{ old('name') }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="specialization_name" class="form-label">Spesialis</label>
                        <input type="text" class="form-control" id="specialization_name" name="specialization_name"
                            placeholder="Masukkan Spesialis" required value="{{ old('specialization_name') }}">
                        @error('specialization_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="doctor_polyclinic_id" class="form-label">Poliklinik</label>
                        <select class="form-select" id="doctor_polyclinic_id" name="doctor_polyclinic_id" required>
                            <option value="">Pilih Poliklinik</option>
                            @foreach ($polyclinics as $polyclinic)
                            <option value="{{ $polyclinic->id }}">{{ $polyclinic->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_polyclinic_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="education" class="form-label">Latar Belakang Pendidikan</label>
                        <textarea class="form-control" id="education" name="education" rows="4"
                            placeholder="Masukkan Latar Belakang Pendidikan" required>{{ old('education') }}</textarea>
                        @error('education')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Link Accuity</label>
                        <input type="url" class="form-control" id="address" name="address"
                            placeholder="Masukkan Link Accuity Dokter" required value="{{ old('address') }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jadwal Praktek sebagai teks bebas menggunakan Trix Editor -->
                    <div class="mb-3">
                        <label for="doctor_schedule" class="form-label">Jadwal Praktek</label>
                        <input id="doctor_schedule" type="hidden" name="doctor_schedule" value="{{ old('doctor_schedule') }}">
                        <trix-editor input="doctor_schedule" placeholder="Masukkan jadwal praktek dokter secara bebas (contoh: Senin - Jumat, 09:00 - 17:00)"></trix-editor>
                        @error('doctor_schedule')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="doctor_photos" class="form-label">Foto Dokter</label>
                        <input type="file" class="form-control" id="doctor_photos" name="doctor_photos"
                            accept="image/*">
                        @error('doctor_photos')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="doctor_medias" class="form-label">Curriculum Vitae (Opsional)</label>
                        <input type="file" class="form-control" id="doctor_medias" name="doctor_medias"
                            accept=".pdf,.doc,.docx">
                        @error('doctor_medias')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Consultation Fee -->
                    <div class="mb-3">
                        <label for="consultation_fee" class="form-label">Biaya Konsultasi (IDR)</label>
                        <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" placeholder="Masukkan Biaya Konsultasi" required value="{{ old('consultation_fee') }}">
                        @error('consultation_fee')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- <div class="mb-3">
                        <label for="email" class="form-label">Email Dokter</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Dokter untuk keperluan Konsultasi Online" required value="{{ old('email') }}">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> -->

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_open_consultation" name="is_open_consultation" value="1">
                        <label class="form-check-label" for="is_open_consultation">Buka Konsultasi</label>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_open_reservation" name="is_open_reservation" value="1">
                        <label class="form-check-label" for="is_open_reservation">Buka Reservasi</label>
                    </div>


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
    document.getElementById('add-schedule').addEventListener('click', function() {
        const scheduleContainer = document.getElementById('schedule-container');
        const newScheduleRow = document.createElement('div');
        newScheduleRow.classList.add('schedule-row', 'mb-2');
        newScheduleRow.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label for="day" class="form-label">Hari</label>
                    <div class="input-group">
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
                        <button type="button" class="btn btn-danger remove-schedule">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
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
        `;
        scheduleContainer.appendChild(newScheduleRow);
    });

    document.getElementById('schedule-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-schedule')) {
            const scheduleRow = e.target.closest('.schedule-row');
            if (scheduleRow) {
                scheduleRow.remove();
            }
        }
    });
</script>
@endpush
