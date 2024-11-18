@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
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

    <div id="form-reservation" class="header-section">
        <div class="container-fluid">
            <h1 class="h3">Reservasi Konsultasi Online</h1>
            <p class="text-muted">Isi form berikut untuk melanjutkan proses reservasi konsultasi online dengan dokter pilihan Anda.</p>

            <div class="card-form">
                <div class="card-body">
                    <form id="reservation-form" action="{{ route('consultation.store') }}" method="POST">
                        @csrf
                        <!-- Nama Dokter -->
                        <div class="form-group mb-4">
                            <label for="doctorName" class="form-label">Nama Dokter</label>
                            <input type="text" class="form-control" id="doctorName" value="{{ $doctor->name }}" readonly style="height: 48px;">
                        </div>

                        <!-- Hidden Input Doctor ID -->
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                        <!-- Spesialis -->
                        <div class="form-group mb-4">
                            <label for="specialist" class="form-label">Spesialis</label>
                            <input type="text" class="form-control" id="specialist" value="{{ $doctor->specialization_name }}" readonly style="height: 48px;">
                        </div>

                        <!-- Poliklinik -->
                        <div class="form-group mb-4">
                            <label for="polyclinic" class="form-label">Poliklinik</label>
                            <input type="text" class="form-control" id="polyclinic" value="{{ $doctor->polyclinic->name ?? 'Umum' }}" readonly style="height: 48px;">
                        </div>

                        <!-- Nama Pasien -->
                        <div class="form-group mb-4">
                            <label for="patientName" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="patientName" name="patient_name" value="{{ $user->patient->name }}" readonly style="height: 48px;">
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="form-group mb-4">
                            <label for="phoneNumber" class="form-label">No. HP</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phone_number" value="{{ $user->whatsapp }}" required style="height: 48px;">
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required style="height: 48px;">
                        </div>

                        <!-- Pilih Tanggal Konsultasi -->
                        <div class="form-group mb-4">
                            <label for="consultationDay" class="form-label">Pilih Tanggal Konsultasi</label>
                            <input type="date" name="preferred_consultation_date" class="form-control" required>
                        </div>

                        <!-- Biaya Konsultasi -->
                        <div class="form-group mb-4">
                            <label for="consultationFee" class="form-label">Biaya Konsultasi</label>
                            <p class="consultation-fee">Rp. {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</p>
                        </div>

                        <div class="form-group text-end d-flex justify-content-between align-items-center flex-wrap">
                            <!-- Link to Terms and Conditions -->
                            <a href="{{ route('terms-and-conditions') }}"
                                class="btn btn-outline-secondary px-3 mb-2 mb-md-0 mx-2 btn-sm btn-md-lg"
                                style="border-radius: 12px; flex: 1; text-align: center;">
                                <i class="bi bi-file-earmark-text"></i> Disclaimer
                            </a>

                            <!-- Button Reservasi -->
                            <button type="submit"
                                class="btn btn-primary px-5 mb-2 mb-md-0 mx-2 btn-sm btn-md-lg"
                                style="height: 48px; background-color: #007858; border-color: #007858; border-radius: 12px; flex: 1; text-align: center;">
                                Reservasi
                            </button>
                        </div>

                    </form>

                    <!-- Disclaimer Alert -->
                    <div class="alert alert-info mt-4" role="alert" style="border-radius: 12px;">
                        <h4 class="alert-heading">Pemberitahuan Penting</h4>
                        <p>Pastikan bahwa informasi yang Anda masukkan sudah benar. Setelah Anda melakukan reservasi, tim kami akan menghubungi Anda untuk konfirmasi waktu konsultasi. Biaya konsultasi tidak dapat dikembalikan setelah reservasi berhasil diproses.</p>
                        <hr>
                        <p class="mb-0">Dengan melanjutkan, Anda setuju dengan ketentuan ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>
<script>
    document.getElementById('reservation-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const confirmation = confirm('Apakah Anda yakin ingin melanjutkan dengan reservasi ini?');
        if (confirmation) {
            alert("Harap tunggu Admin kami akan menghubungi Anda untuk konfirmasi waktu konsultasi online.");
            setTimeout(() => {
                window.location.href = "{{ route('account-index') }}"; // Redirect to Riwayat Pesanan
            }, 2000); // Delay before redirecting
            this.submit(); // Melanjutkan proses pengiriman form
        }
    });
</script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush