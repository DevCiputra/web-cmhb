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
                            <li class="breadcrumb-item"><a href="/doctor-data">Dokter</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Data Dokter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 2rem;">
                <form method="POST" action="{{ route('doctor.data.update', $doctor->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                        <label for="doctor_polyclinic_id" class="form-label">Poliklinik</label>
                        <select class="form-select" id="doctor_polyclinic_id" name="doctor_polyclinic_id" required>
                            <option value="">Pilih Poliklinik</option>
                            @foreach ($polyclinics as $polyclinic)
                            <option value="{{ $polyclinic->id }}" {{ $doctor->doctor_polyclinic_id == $polyclinic->id ? 'selected' : '' }}>
                                {{ $polyclinic->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="doctor_schedule" class="form-label">Jadwal Praktek</label>
                        <div id="doctor_schedule">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="{{ strtolower($day) }}" name="doctor_schedule[days][]" value="{{ $day }}" {{ in_array($day, $doctor->schedules->pluck('day_of_week')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ strtolower($day) }}">{{ $day }}</label>
                                <div class="d-flex">
                                    <input type="time" class="form-control me-2" id="{{ strtolower($day) }}_start" name="doctor_schedule[start_time][{{ $day }}]" value="{{ $doctor->schedules->where('day_of_week', $day)->first()->start_time ?? '' }}">
                                    <input type="time" class="form-control" id="{{ strtolower($day) }}_end" name="doctor_schedule[end_time][{{ $day }}]" value="{{ $doctor->schedules->where('day_of_week', $day)->first()->end_time ?? '' }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
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

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('doctor.data.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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