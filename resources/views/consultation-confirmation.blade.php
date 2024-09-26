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
                <form>
                    @csrf

                    <!-- Order Code -->
                    <div class="form-group mb-4">
                        <label for="orderCode" class="form-label">Kode Pemesanan</label>
                        <p class="form-text">Kode Pemesanan</p>
                    </div>

                    <!-- Nama Pasien -->
                    <div class="form-group mb-4">
                        <label for="patientName" class="form-label">Nama Pasien</label>
                        <p class="form-text">Jhon Doe</p>
                    </div>

                    <!-- No HP -->
                    <div class="form-group mb-4">
                        <label for="phoneNumber" class="form-label">No. HP (WhatsApp)</label>
                        <p class="form-text">0812-3456-7890</p>
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email</label>
                        <p class="form-text">john.doe@email.com</p>
                    </div>

                    <!-- Nama Dokter -->
                    <div class="form-group mb-4">
                        <label for="doctorName" class="form-label">Nama Dokter</label>
                        <p class="form-text">dr. Jane Smith, Sp.JP</p>
                    </div>

                    <!-- Spesialis -->
                    <div class="form-group mb-4">
                        <label for="specialist" class="form-label">Spesialis</label>
                        <p class="form-text">Kardiologi</p>
                    </div>

                    <!-- Poliklinik -->
                    <div class="form-group mb-4">
                        <label for="polyclinic" class="form-label">Poliklinik</label>
                        <p class="form-text">Poliklinik Jantung</p>
                    </div>

                    <!--Hari Konsultasi -->
                    <div class="form-group mb-4">
                        <label for="consultationDay" class="form-label">Hari Konsultasi</label>
                        <p class="form-text">Senin</p>
                    </div>
                    

                    {{-- Pilih Metode Pembayaran --}}
                    {{-- <div class="form-group mb-4">
                        <label for="paymentMethod" class="form-label">Pilih Metode Pembayaran (Transfer)</label>
                        <select class="form-select" id="paymentMethod" name="payment_method" required style="height: 48px;">
                            <option selected>Pilih Metode</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Kartu Kredit">Kartu Kredit</option>
                        </select>
                    </div> --}}


                    <!-- Pilih Bank -->
                    <div class="form-group mb-4">
                        <label for="bank" class="form-label">Pilih Bank Transfer</label>
                        <select class="form-select" id="bank" name="bank" required style="height: 48px;">
                            <option selected>Pilih Bank</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BRI">BRI</option>
                        </select>
                    </div>

                    <!-- Rekening Bank (Hidden by default) -->
                    <!-- Rekening Bank -->
                    <div class="form-group mb-4" id="rekening-info" style="display: none;">
                        <label for="bankAccount" class="form-label">Rekening Bank</label>
                        <p class="form-text">
                            <span id="bankAccount" class="highlight-text"></span>
                        </p>
                    </div>



                    <!-- Placeholder for showing the account number -->
                    <div class="form-group mb-4">
                        <p id="bankAccountInfo" class="form-text text-muted"></p>
                    </div>


                    <div class="form-group mb-4">
                        <p class="text-muted">Note: Setelah melakukan pembayaran, silakan unggah bukti pembayaran dibawah ini</p>
                    </div>

                    <!-- Upload Image -->
                    <div class="form-group mb-4">
                        <label for="uploadImage" class="form-label">Unggah Bukti Pembayaran</label>
                        <input type="file" class="form-control" id="uploadImage" name="upload_image" required>
                    </div>

                    <!-- Note -->
                    <div class="form-group mb-4">
                        <p class="text-muted">Note: Admin akan memverifikasi pembayaran, mohon cek secara berkala pesanan
                            anda.</p>
                    </div>

                    <!-- Button Confirm -->
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary px-5"
                            style="height: 48px; background-color: #007858; border-color: #007858; border-radius: 12px;">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
@endpush

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var bankSelect = document.getElementById('bank');
    var rekeningInfo = document.getElementById('rekening-info');
    var rekeningText = document.getElementById('bankAccount');
    var copyButton = document.getElementById('copyButton');

    bankSelect.addEventListener('change', function() {
        var selectedBank = this.value;

        if (selectedBank === 'BCA') {
            rekeningText.textContent = '1234567890 - a.n Ciputra Mitra Hospital';
            rekeningInfo.style.display = 'block';
        } else if (selectedBank === 'Mandiri') {
            rekeningText.textContent = '0987654321 - a.n PT. Ciputra Mitra Hospital';
            rekeningInfo.style.display = 'block';
        } else if (selectedBank === 'BRI') {
            rekeningText.textContent = '1122334455 - a.n PT. Ciputra Mitra Hospital';
            rekeningInfo.style.display = 'block';
        } else {
            rekeningInfo.style.display = 'none';
        }
    });

    // copyButton.addEventListener('click', function() {
    //     var tempInput = document.createElement('input');
    //     tempInput.value = rekeningText.textContent;
    //     document.body.appendChild(tempInput);
    //     tempInput.select();
    //     document.execCommand('copy');
    //     document.body.removeChild(tempInput);
    //     alert('Nomor rekening berhasil disalin!');
    // });
});

</script>
