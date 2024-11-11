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
                            <button class="nav-link flex-fill text-center py-2 px-3" id="nav-screening-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-screening" type="button" role="tab"
                                aria-controls="nav-screening" aria-selected="false">Riwayat Skrining</button>
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
                                    <p>{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') : 'Belum diisi' }}
                                    </p>
                                </div>

                                <h6>Usia</h6>
                                <div class="mb-3">
                                    <p>{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age . ' Tahun' : 'Belum diisi' }}
                                    </p>
                                </div>

                                <h6>No. RM Ciputra Mitra Hospital</h6>
                                <div class="mb-3">
                                    <p>{{ $patient->medical_record_id ?? 'Isi No. RM Ciputra Mitra Hospital Anda terlebih dahulu' }}
                                    </p>
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
                                                        Dokter:
                                                        {{ $reservation->doctorConsultationReservation->doctor->name ?? 'Nama dokter tidak tersedia' }}
                                                    </span>
                                                </div>

                                            </div>
                                            <span
                                                class="status-badge badge
    @if (is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran)) badge-secondary
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
        badge-secondary @endif
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
                        
                        <div class="tab-pane fade" id="nav-screening" role="tabpanel" aria-labelledby="nav-screening-tab">
                            <div class="container mt-3">
                                @if(isset($screeningHistories) && !$screeningHistories->isEmpty())
                                <h5>Riwayat Pengisian Skrining Psikologi</h5>
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Pengisian</th>
                                            <th>Skor Total Distres</th>
                                            <th>Klasifikasi Total Distres</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($screeningHistories as $history)
                                            <tr>
                                                <td>{{ $history->created_at->format('d-m-Y') }}</td>
                                                <td>{{ $history->total_distress_score }}</td>
                                                <td>{{ $history->total_distress_classification }}</td>
                                                <td>
                                                    <a href="{{ route('showResult', $history->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>Anda belum memiliki riwayat pengisian skrining.</p>
                            @endif                              
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
                    <form id="editProfileForm" action="{{ route('account-update', $patient->id) }}" method="POST"
                        enctype="multipart/form-data">
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
                            <input type="file" class="form-control mt-2 @error('profile_picture') is-invalid @enderror"
                                id="profilePhoto" name="profile_picture" accept="image/*"
                                onchange="previewImage(event)">
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $user->patient->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dob" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                                name="dob"
                                value="{{ old('dob', $patient->dob ? $patient->dob->format('Y-m-d') : '') }}">
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="medical_record_id" class="form-label">No. RM Ciputra Mitra Hospital</label>
                            <input type="text" class="form-control @error('medical_record_id') is-invalid @enderror"
                                id="medical_record_id" name="medical_record_id"
                                value="{{ old('medical_record_id', $patient->medical_record_id) }}">
                            @error('medical_record_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                required>{{ old('address', $patient->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="allergy" class="form-label">Alergi</label>
                            <input type="text" class="form-control @error('allergy') is-invalid @enderror"
                                id="allergy" name="allergy"
                                value="{{ old('allergy', $patient->allergies->pluck('name')->implode(', ')) }}">
                            @error('allergy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bloodType" class="form-label">Golongan Darah</label>
                            <input type="text" class="form-control @error('blood_type') is-invalid @enderror"
                                id="bloodType" name="blood_type"
                                value="{{ old('blood_type', $patient->bloodGroup->name ?? '') }}">
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

    <!-- Emergency Section -->
    <!-- Emergency FAB -->
    <div id="emergency" class="emergency-fab">
        <!-- Sub-menu FAB buttons that will collapse/expand -->
        <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
            <a href="tel:+625116743911" class="btn btn-success btn-lg mb-2 rounded-circle">
                <i class="fas fa-ambulance"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=6278033212250&text=Saya%20tertarik%20layanan%20di%20Ciputra%20Hospital%20saya%20ingin%20informasi%20mengenai...."
                class="btn btn-outline-success btn-lg rounded-circle mb-2" target="_blank">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
        <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()">
            <i class="fa-solid fa-phone"></i>
        </a>
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
document.addEventListener("DOMContentLoaded", function () {
    // Define the tabs and their respective content
    const infoTab = document.getElementById('profile-info-tab');
    const riwayatTab = document.getElementById('nav-profile-tab');
    const riwayatSkriningTab = document.getElementById('nav-riwayat-skrining-tab');
    const infoContent = document.getElementById('profile-info');
    const riwayatContent = document.getElementById('nav-profile');
    const riwayatSkriningContent = document.getElementById('nav-riwayat-skrining');

    // Check if there's a saved active tab in localStorage, otherwise set default to 'Informasi Pribadi'
    if (!localStorage.getItem('activeTab')) {
        localStorage.setItem('activeTab', 'profile-info-tab');
        infoTab.classList.add('active');
        infoContent.classList.add('show', 'active');
        riwayatTab.classList.remove('active');
        riwayatContent.classList.remove('show', 'active');
        riwayatSkriningTab.classList.remove('active');
        riwayatSkriningContent.classList.remove('show', 'active');
    }

    // Get the last active tab from localStorage and activate it
    const lastTab = localStorage.getItem('activeTab');
    const activeTab = document.getElementById(lastTab);
    if (activeTab) {
        activeTab.classList.add('active');
        const tabContent = document.getElementById(activeTab.getAttribute("aria-controls"));
        tabContent.classList.add('show', 'active');
    }

    // Event listener for tabs to handle switching
    const tabs = document.querySelectorAll('.nav-profile .nav-link');
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            localStorage.setItem('activeTab', this.id); // Save the active tab to localStorage

            // Remove active class and show class from all tabs and their contents
            tabs.forEach(t => {
                t.classList.remove('active');
                const content = document.getElementById(t.getAttribute('aria-controls'));
                content.classList.remove('show', 'active');
            });

            // Add active class to the clicked tab
            this.classList.add('active');
            const content = document.getElementById(this.getAttribute('aria-controls'));
            content.classList.add('show', 'active');
        });
    });

    // Check for the 'tab' parameter in the URL to switch tabs accordingly
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');

    if (tab === 'riwayat') {
        // Switch to Riwayat Pesanan tab if 'riwayat' is in the URL
        riwayatTab.classList.add('active');
        riwayatContent.classList.add('show', 'active');
        infoTab.classList.remove('active');
        infoContent.classList.remove('show', 'active');
        riwayatSkriningTab.classList.remove('active');
        riwayatSkriningContent.classList.remove('show', 'active');
        localStorage.setItem('activeTab', 'nav-profile-tab');
    } else if (tab === 'riwayat-skrining') {
        // Switch to Riwayat Skrining tab if 'riwayat-skrining' is in the URL
        riwayatSkriningTab.classList.add('active');
        riwayatSkriningContent.classList.add('show', 'active');
        infoTab.classList.remove('active');
        infoContent.classList.remove('show', 'active');
        riwayatTab.classList.remove('active');
        riwayatContent.classList.remove('show', 'active');
        localStorage.setItem('activeTab', 'nav-riwayat-skrining-tab');
    } else {
        // Default to 'Informasi Pribadi' tab if no 'tab' param is found
        infoTab.classList.add('active');
        infoContent.classList.add('show', 'active');
        riwayatTab.classList.remove('active');
        riwayatContent.classList.remove('show', 'active');
        riwayatSkriningTab.classList.remove('active');
        riwayatSkriningContent.classList.remove('show', 'active');
    }
});



    function toggleEmergencyButtons() {
        const buttons = document.getElementById("emergency-buttons");
        buttons.classList.toggle("expand");

        if (buttons.style.maxHeight === "0px" || buttons.style.maxHeight === "") {
            buttons.style.maxHeight = "200px"; // Expand the sub-menu (adjust height as needed)
        } else {
            buttons.style.maxHeight = "0px"; // Collapse the sub-menu
        }
    }
</script>
@endpush



@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user_profile.css') }}">
@endpush
