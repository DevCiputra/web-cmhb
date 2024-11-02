@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="col-md-8">
            <div class="profile-header text-center">

                <!-- Menampilkan gambar profil pasien -->
                @if ($patient && $patient->profile_picture)
                <img src="{{ asset('storage/' . $patient->profile_picture) }}" alt="Patient Photo"
                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                @else
                <img src="{{ asset('images/userplaceholder.png') }}" alt="Patient Photo"
                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                @endif


                <h5>{{ $user->username }}</h5>
                <p>{{ $user->whatsapp }}</p>
                <p>{{ $user->email }}</p>
                <img src="icons/pencil-square.png" alt="Edit Profile" class="edit-icon" data-bs-toggle="modal"
                    data-bs-target="#editProfileModal">
            </div>
            <div class="tab-bar" style="max-width: auto;">
                <nav class="nav-profile">
                    <div class="nav nav-tabs mb-1 justify-content-center" id="nav-tab" role="tablist">
                        <button class="nav-link active flex-fill text-center py-2 px-3" id="profile-info-tab"
                            data-bs-toggle="tab" data-bs-target="#profile-info" type="button" role="tab"
                            aria-controls="profile-info" aria-selected="true">Informasi Pribadi</button>
                        <button class="nav-link flex-fill text-center py-2 px-3" id="nav-profile-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab"
                            aria-controls="nav-profile" aria-selected="false">Riwayat Pesanan</button>
                    </div>
                </nav>

                <div class="tab-content p-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="profile-info" role="tabpanel"
                        aria-labelledby="profile-info-tab">
                        <div class="profile-info">
                            <h6>Nama Lengkap</h6>
                            <div class="mb-3">
                                <p>{{ $patient->name ?? 'Isi nama Anda terlebih dahulu' }}</p>
                            </div>

                            <h6>Alamat</h6>
                            <div class="mb-3">
                                <p>{{ $patient->address ?? 'Alamat tidak tersedia' }}</p>
                            </div>

                            <h6>Tanggal Lahir</h6>
                            <div class="mb-3">
                                <p>{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') : 'Belum diisi' }}</p>
                            </div>

                            <h6>Usia</h6>
                            <div class="mb-3">
                                <p>{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age . ' Tahun' : 'Belum diisi' }}</p>
                            </div>

                            <h6>Alergi</h6>
                            <div class="mb-3">
                                <p>
                                    @if ($patient->allergies && $patient->allergies->isNotEmpty())
                                    @foreach ($patient->allergies as $allergy)
                                    {{ $allergy->name }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                    @else
                                    Tidak ada alergi yang terdaftar
                                    @endif
                                </p>
                            </div>

                            <h6>Golongan Darah</h6>
                            <div class="mb-3">
                                <p>
                                    @if ($patient->bloodGroup)
                                    {{ $patient->bloodGroup->name }}
                                    @else
                                    Golongan darah tidak tersedia
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <!-- Filter Section -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Filter by:</span>
                            <div class="btn-group" role="group" aria-label="Filter Options">
                                <button type="button" class="btn btn-outline-primary"
                                    id="filter-latest">Terbaru</button>
                                <button type="button" class="btn btn-outline-primary" id="filter-newest">Paling
                                    Lama</button>
                            </div>
                        </div>

                        <!-- Scrollable Consultation List -->
                        <div class="consultation-list" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($reservations as $reservation)
                            <a href="{{ route('consultation.detail', $reservation->id) }}"
                                class="booking-item-link">
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code"
                                            style="margin-right:8px">{{ $reservation->code }}</span>
                                        <div class="booking-details">
                                            <span class="booking-date">
                                                {{ $reservation->doctorConsultationReservation->formatted_date ?? 'Tanggal belum diset' }}
                                            </span>

                                            <span class="booking-time">
                                                {{ $reservation->doctorConsultationReservation->formatted_time ?? 'Pukul belum diset' }}
                                            </span>

                                            <!-- Menampilkan Nama Dokter -->
                                            <span class="doctor-name">
                                                Dokter: {{ $reservation->doctorConsultationReservation->doctor->name ?? 'Nama dokter tidak tersedia' }}
                                            </span>
                                        </div>

                                    </div>
                                    <span class="status-badge badge
    @if (is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran))
        badge-secondary
    @elseif ($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran))
        badge-warning
    @elseif ($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran))
        badge-info
    @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi')
        badge-warning
    @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas')
        badge-info
    @elseif ($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas')
        badge-success
    @elseif ($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan')
        badge-danger
    @else
        badge-secondary
    @endif
">
                                        {{-- Menampilkan teks status berdasarkan kondisi --}}
                                        @if (is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran))
                                        Menunggu Admin
                                        @elseif ($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran))
                                        Konfirmasi Jadwal
                                        @elseif ($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran))
                                        Menunggu Pembayaran
                                        @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi')
                                        Menunggu Konfirmasi Pembayaran
                                        @elseif ($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas')
                                        Menunggu Approval Admin
                                        @elseif ($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas')
                                        Pemesanan Berhasil
                                        @elseif ($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan')
                                        Pemesanan Dibatalkan
                                        @else
                                        Status Tidak Diketahui
                                        @endif
                                    </span>


                                </div>
                            </a>
                            @endforeach
                            <!-- Tambahkan item lainnya jika diperlukan -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cek jika ada error, buka modal secara otomatis -->
@if ($errors->any())
<script>
    window.onload = function() {
        var editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
        editProfileModal.show();
    }
</script>
@endif


<!-- Modal untuk Mengedit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="{{ route('account-update', $patient->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Preview Foto Profil -->
                    <div class="mb-3">
                        <label for="profilePhoto" class="form-label">Foto Profil</label>
                        <div>
                            @if ($patient && $patient->profile_picture)
                            <img src="{{ asset('storage/' . $patient->profile_picture) }}" alt="Profile Photo"
                                id="previewProfilePhoto"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            @else
                            <img src="{{ asset('default_profile.png') }}" alt="Default Profile Photo"
                                id="previewProfilePhoto"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            @endif
                        </div>
                        <input type="file" class="form-control mt-2 @error('profile_picture') is-invalid @enderror" id="profilePhoto" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                        @error('profile_picture')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->patient->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dob" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob', $patient->dob ? $patient->dob->format('Y-m-d') : '') }}">
                        @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $patient->address) }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="allergy" class="form-label">Alergi</label>
                        <input type="text" class="form-control @error('allergy') is-invalid @enderror" id="allergy" name="allergy" value="{{ old('allergy', $patient->allergies->pluck('name')->implode(', ')) }}">
                        @error('allergy')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bloodType" class="form-label">Golongan Darah</label>
                        <input type="text" class="form-control @error('blood_type') is-invalid @enderror" id="bloodType" name="blood_type" value="{{ old('blood_type', $patient->bloodGroup->name ?? '') }}">
                        @error('blood_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const output = document.getElementById('previewProfilePhoto');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
</script>


@endsection
@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Dapatkan elemen tab untuk 'Informasi Pribadi' dan 'Riwayat Pesanan'
        const infoTab = document.getElementById('profile-info-tab');
        const riwayatTab = document.getElementById('nav-profile-tab');
        const infoContent = document.getElementById('profile-info');
        const riwayatContent = document.getElementById('nav-profile');

        // Aktifkan default tab hanya jika tidak ada yang dipilih sebelumnya di localStorage
        if (!localStorage.getItem('activeTab')) {
            infoTab.classList.add('active');
            infoContent.classList.add('show', 'active');
            riwayatTab.classList.remove('active');
            riwayatContent.classList.remove('show', 'active');
        }

        // Cek tab yang terakhir kali dipilih di localStorage
        const lastTab = localStorage.getItem('activeTab');
        if (lastTab) {
            const activeTab = document.querySelector(`#${lastTab}`);
            const tabContent = document.querySelector(`#${activeTab.getAttribute("aria-controls")}`);
            if (activeTab && tabContent) {
                // Aktifkan tab terakhir yang diakses
                activeTab.classList.add('active');
                tabContent.classList.add('show', 'active');
            }
        }

        // Event listener untuk setiap tab, menyimpan posisi terakhir yang dikunjungi
        const tabs = document.querySelectorAll('.nav-profile .nav-link');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                localStorage.setItem('activeTab', this.id);

                // Tampilkan konten yang sesuai dan sembunyikan yang lain
                if (this.id === 'profile-info-tab') {
                    riwayatContent.classList.remove('show', 'active');
                    infoContent.classList.add('show', 'active');
                } else if (this.id === 'nav-profile-tab') {
                    infoContent.classList.remove('show', 'active');
                    riwayatContent.classList.add('show', 'active');
                }
            });
        });

        // Cek apakah ada parameter `tab` pada URL
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');

        // Jika `tab` adalah `riwayat`, aktifkan tab Pemesanan Konsultasi
        if (tab === 'riwayat') {
            riwayatTab.classList.add('active');
            infoTab.classList.remove('active');

            riwayatContent.classList.add('show', 'active');
            infoContent.classList.remove('show', 'active');

            // Simpan riwayat tab ke localStorage
            localStorage.setItem('activeTab', 'nav-profile-tab');
        } else {
            // Jika tidak ada `tab`, pastikan 'Informasi Pribadi' adalah tampilan default
            infoTab.classList.add('active');
            infoContent.classList.add('show', 'active');
            riwayatTab.classList.remove('active');
            riwayatContent.classList.remove('show', 'active');
        }
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user_profile.css') }}">
@endpush