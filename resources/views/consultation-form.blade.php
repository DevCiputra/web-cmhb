@extends('landing-page.layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px;">

    <!-- Breadcrumb Section -->
        <div class="container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="/online-consultation">Konsultasi Online</a></li>
                    <li class="breadcrumb-item"><a href="/doctor">Profile Dokter</a></li>
                    <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Reservasi Konsultasi Online</li>
                </ol>
            </nav>
        </div>
    
    
        <div id="form-reservatrion" class="header-section">
            <div class="container-fluid">
                <h1 class="h3">Reservasi Konsultasi Online</h1>
            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipiscing elit semper dalar elementum tempus hac tellus libero accumsan.</p>
    
        <div class="card-form">
            <div class="card-body">
                <form>
                    @csrf
                    {{-- Nama Dokter --}}
                    <div class="form-group mb-4">
                        <label for="doctorName" class="form-label">Nama Dokter</label>
                        <input type="text" class="form-control" id="doctorName" name="doctor_name" placeholder="Nama Dokter" required style="height: 48px;">
                    </div>
    
                    {{-- Spesialis --}}
                    <div class="form-group mb-4">
                        <label for="specialist" class="form-label">Spesialis</label>
                        <input type="text" class="form-control" id="specialist" name="specialist" placeholder="Spesialis" required style="height: 48px;">
                    </div>
    
                    {{-- Poliklinik --}}
                    <div class="form-group mb-4">
                        <label for="polyclinic" class="form-label">Poliklinik</label>
                        <input type="text" class="form-control" id="polyclinic" name="polyclinic" placeholder="Poliklinik" required style="height: 48px;">
                    </div>
    
                    {{-- Pilih Waktu Konsultasi --}}
                    <div class="form-group mb-4">
                        <label for="consultationTime" class="form-label">Pilih Waktu Konsultasi</label>
                        <div class="row">
                            {{-- Hari-hari --}}
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="day[]" value="Senin" id="monday">
                                    <label class="form-check-label" for="monday">
                                        Senin (Tutup)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="day[]" value="Selasa" id="tuesday">
                                    <label class="form-check-label" for="tuesday">
                                        Selasa (Tutup)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="day[]" value="Rabu" id="wednesday">
                                    <label class="form-check-label" for="wednesday">
                                        Rabu (Tutup)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="day[]" value="Kamis" id="thursday">
                                    <label class="form-check-label" for="thursday">
                                        Kamis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="day[]" value="Jumat" id="friday" checked>
                                    <label class="form-check-label" for="friday">
                                        Jumat
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="day[]" value="Sabtu" id="saturday">
                                    <label class="form-check-label" for="saturday">
                                        Sabtu (Tutup)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    {{-- Nama Pasien --}}
                    <div class="form-group mb-4">
                        <label for="patientName" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" id="patientName" name="patient_name" placeholder="Nama Pasien" required style="height: 48px;">
                    </div>
    
                    {{-- No HP --}}
                    <div class="form-group mb-4">
                        <label for="phoneNumber" class="form-label">No. HP</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phone_number" placeholder="No. HP" required style="height: 48px;">
                    </div>
    
                    {{-- Email --}}
                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required style="height: 48px;">
                    </div>
    
                    {{-- Biaya Konsultasi --}}
                    <div class="form-group mb-4">
                        <label for="consultationFee" class="form-label">Biaya Konsultasi</label>
                        <p class="consultation-fee">Rp. 500.000,00</p>
                    </div>
    
                    
    
                    {{-- Button Submit --}}
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary px-5" style="height: 48px; background-color: #007858; border-color: #007858; border-radius: 12px;">Reservasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const timeInputs = this.closest('.form-check-label').querySelectorAll('input[type="time"]');
                timeInputs.forEach(input => {
                    input.disabled = !this.checked;
                });
            });
        });
    </script>
@endpush

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush
