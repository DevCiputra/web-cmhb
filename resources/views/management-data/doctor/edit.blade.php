@extends('management-data.layouts.app')

@section('title', 'Edit Data Dokter')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Edit Data Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/doctor-data">Dokter</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Data Dokter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-form" style="padding: 2rem;">
                <form method="POST" action="{{ route('doctor.data.update', $doctor->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                     <!-- User Selection -->
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih User</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $doctor->user_id) == $user->id ? 'selected' : '' }}>
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
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $doctor->name) }}" placeholder="Masukkan Nama Dokter" required>
                    </div>

                    <div class="mb-3">
                        <label for="specialization_name" class="form-label">Spesialis</label>
                        <input type="text" class="form-control" id="specialization_name" name="specialization_name" value="{{ old('specialization_name', $doctor->specialization_name) }}" placeholder="Masukkan Spesialis" required>
                    </div>

                    <div class="mb-3">
                        <label for="education" class="form-label">Latar Belakang Pendidikan</label>
                        <textarea class="form-control" id="education" name="education" rows="4" placeholder="Masukkan Latar Belakang Pendidikan">{{ $doctor->education->name ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Link Accuity</label>
                        <input type="url" class="form-control" id="address" name="address" value="{{ old('address', $doctor->address) }}" placeholder="Masukkan Link Accuity Dokter" required>
                    </div>

                    <div class="mb-3">
                        <label for="doctor_polyclinic_id" class="form-label">Poliklinik</label>
                        <select class="form-select" id="doctor_polyclinic_id" name="doctor_polyclinic_id" required>
                            <option value="">Pilih Poliklinik</option>
                            @foreach ($polyclinics as $polyclinic)
                            <option value="{{ $polyclinic->id }}" {{ $doctor->doctor_polyclinic_id == $polyclinic->id ? 'selected' : '' }}>{{ $polyclinic->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jadwal Praktek sebagai teks bebas menggunakan Trix Editor untuk view edit -->
                    <div class="mb-3">
                        <label for="doctor_schedule" class="form-label">Jadwal Praktek</label>
                        <input id="doctor_schedule" type="hidden" name="doctor_schedule" value="{{ old('doctor_schedule', $schedule ?? '') }}">
                        <trix-editor input="doctor_schedule" placeholder="Masukkan jadwal praktek dokter secara bebas (contoh: Senin - Jumat, 09:00 - 17:00)"></trix-editor>
                        @error('doctor_schedule')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="doctor_photos" class="form-label">Foto Dokter</label>
                        @if($doctor->photos->isNotEmpty())
                        <img src="{{ asset('storage/doctor/photos/' . $doctor->id . '/' . $doctor->photos->first()->name) }}" alt="Foto Dokter" class="img-thumbnail mb-2" style="max-width: 150px;">
                        @endif
                        <input type="file" class="form-control" id="doctor_photos" name="doctor_photos" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="doctor_medias" class="form-label">CV Dokter</label>
                        @if($doctor->medias->isNotEmpty())
                        <a href="{{ asset('storage/doctor/medias/' . $doctor->id . '/' . $doctor->medias->first()->name) }}" target="_blank" class="btn btn-link">Lihat CV</a>
                        @endif
                        <input type="file" class="form-control" id="doctor_medias" name="doctor_medias" accept=".pdf,.doc,.docx">
                    </div>

                    <!-- Input Consultation Fee -->
                    <div class="mb-3">
                        <label for="consultation_fee" class="form-label">Biaya Konsultasi (IDR)</label>
                        <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" placeholder="Masukkan Biaya Konsultasi" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" required>
                    </div>

                    <!-- Input email -->
                    <!-- <div class="mb-3">
                        <label for="email" class="form-label">Email Dokter</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Email Dokter untuk keperluan konsultasi online" value="{{ old('email', $doctor->email) }}" required>
                    </div> -->

                    <!-- Input for new fields -->
                    <!-- <div class="mb-3">
                        <label for="is_published" class="form-label">Status Publikasi</label>
                        <select class="form-select" id="is_published" name="is_published" required>
                            <option value="1" {{ $doctor->is_published == '1' ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ $doctor->is_published == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div> -->

                    <div class="mb-3">
                        <label for="is_open_consultation" class="form-label">Status Konsultasi</label>
                        <select class="form-select" id="is_open_consultation" name="is_open_consultation" required>
                            <option value="1" {{ $doctor->is_open_consultation == '1' ? 'selected' : '' }}>Buka Konsultasi</option>
                            <option value="0" {{ $doctor->is_open_consultation == '0' ? 'selected' : '' }}>Tutup Konsultasi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="is_open_reservation" class="form-label">Status Reservasi</label>
                        <select class="form-select" id="is_open_reservation" name="is_open_reservation" required>
                            <option value="1" {{ $doctor->is_open_reservation == '1' ? 'selected' : '' }}>Buka Reservasi</option>
                            <option value="0" {{ $doctor->is_open_reservation == '0' ? 'selected' : '' }}>Tutup Reservasi</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('doctor.data.index') }}" class="btn btn-secondary d-inline-block">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary d-inline-block">Simpan Data Dokter</button>
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

@endpush

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
