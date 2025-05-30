@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">

    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/account">Profile</a></li>
                <li class="breadcrumb-item"><a href="/account">Riwayat Pemesanan</a></li>
                <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Konfirmasi Pembayaran</li>
            </ol>
        </nav>
    </div>

    <div class="header-section">
        <div class="container-fluid">
            <h1 class="h3">Konfirmasi Pembayaran</h1>
            <p class="text-muted">Harap periksa kembali detail konsultasi Anda sebelum mengonfirmasi pembayaran.</p>
        </div>
    </div>

    <div class="card-form">
        <div class="card-body">
            <form id="reservation-form" action="{{ route('consultation.payment', $reservation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <!-- Kode Pemesanan -->
                <div class="form-group mb-4">
                    <label for="orderCode" class="form-label">Kode Pemesanan</label>
                    <p class="form-text">{{ $reservation->code }}</p>
                </div>

                <!-- Nama Pasien -->
                <div class="form-group mb-4">
                    <label for="patientName" class="form-label">Nama Pasien</label>
                    <p class="form-text">{{ $reservation->patient->name }}</p>
                </div>

                <!-- No HP -->
                <div class="form-group mb-4">
                    <label for="phoneNumber" class="form-label">No. HP (WhatsApp)</label>
                    <p class="form-text">{{ $reservation->patient->user->whatsapp }}</p>
                </div>

                <!-- Email -->
                <div class="form-group mb-4">
                    <label for="email" class="form-label">Email</label>
                    <p class="form-text">{{ $reservation->patient->user->email }}</p>
                </div>

                <!-- Nama Dokter -->
                <div class="form-group mb-4">
                    <label for="doctorName" class="form-label">Nama Dokter</label>
                    <p class="form-text">{{ $reservation->doctorConsultationReservation->doctor->name }}</p>
                </div>

                <!-- Spesialis -->
                <div class="form-group mb-4">
                    <label for="specialist" class="form-label">Spesialis</label>
                    <p class="form-text">{{ $reservation->doctorConsultationReservation->doctor->specialization_name }}</p>
                </div>

                <!-- Poliklinik -->
                <div class="form-group mb-4">
                    <label for="polyclinic" class="form-label">Poliklinik</label>
                    <p class="form-text">{{ $reservation->doctorConsultationReservation->doctor->polyclinic->name }}</p>
                </div>

                <!-- Hari Konsultasi -->
                <div class="form-group mb-4">
                    <label for="consultationDay" class="form-label">Hari Konsultasi</label>
                    <p class="form-text">{{ \Carbon\Carbon::parse($reservation->doctorConsultationReservation->preferred_consultation_date)->translatedFormat('l, d F Y') }}</p>
                </div>

                @if ($reservation->doctorConsultationReservation->payment_proof)
                <!-- Bukti Pembayaran Sudah Diunggah -->
                <div class="form-group mb-4">
                    <label for="uploadImage" class="form-label">Bukti Pembayaran</label>
                    <p>
                        <a href="{{ asset('storage/' . $reservation->doctorConsultation->payment_proof) }}" class="link-primary" target="_blank">Lihat Bukti Pembayaran</a>
                    </p>
                </div>
                @else
                <!-- Pilih Bank -->
                <div class="form-group mb-4">
                    <label for="payment_method" class="form-label">Pilih Bank Transfer</label>
                    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required style="height: 48px;">
                        <option selected>Pilih Bank</option>
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                    </select>
                    @error('payment_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Rekening Bank (Hidden by default) -->
                <div class="form-group mb-4" id="rekening-info" style="display: none;">
                    <label for="bankAccount" class="form-label">Rekening Bank</label>
                    <p class="form-text">
                        <span id="bankAccount" class="highlight-text"></span>
                    </p>
                </div>

                <!-- Upload Image -->
                <div class="form-group mb-4">
                    <label for="uploadImage" class="form-label">Unggah Bukti Pembayaran</label>
                    <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" id="uploadImage" name="payment_proof" required>
                    @error('payment_proof')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endif

                <!-- Button Confirm -->
                @if (!$reservation->doctorConsultationReservation->payment_proof)
                <div class="form-group text-end">
                    <button type="submit" class="btn btn-primary px-5"
                        style="height: 48px; background-color: #007858; border-color: #007858; border-radius: 12px;">Konfirmasi</button>
                </div>
                @endif
            </form>

        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var bankSelect = document.getElementById('payment_method'); // Corrected variable name
        var rekeningInfo = document.getElementById('rekening-info');
        var rekeningText = document.getElementById('bankAccount');
        var form = document.getElementById('reservation-form'); // Select the form for submission handling

        bankSelect.addEventListener('change', function() {
            var selectedBank = this.value;

            // Display corresponding bank account information based on the selected bank
            if (selectedBank === 'BCA') {
                rekeningText.textContent = '5020887887 - a.n PT. CIPUTRA MITRA MEDIKA';
                rekeningInfo.style.display = 'block';
            } else if (selectedBank === 'Mandiri') {
                rekeningText.textContent = '0310022077799 - a.n PT. CIPUTRA MITRA MEDIKA';
                rekeningInfo.style.display = 'block';
            } else {
                rekeningInfo.style.display = 'none'; // Hide if no valid selection
            }
        });

        // Add confirmation on form submission
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            var confirmation = confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran? Pastikan semua informasi sudah benar');

            if (confirmation) {
                alert("Pesanan anda akan segera dicek. Mohon tunggu approval");
                setTimeout(() => {
                    window.location.href = "{{ route('account-index') }}"; // Redirect to Riwayat Pesanan
                }, 2000); // Delay before redirecting
                this.submit(); // Melanjutkan proses pengiriman form
            }
        });
    });
</script>

@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush