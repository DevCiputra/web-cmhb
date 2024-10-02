@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-header text-center">
                <img src="{{ asset('images/user.jpg') }}" alt="User Photo">
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
                            <h6>Alamat</h6>
                            <div class="mb-3">
                                <p>{{ $patient->address ?? 'Alamat tidak tersedia' }}</p>
                            </div>
                            <h6>Usia</h6>
                            <div class="mb-3">
                                <p>{{ \Carbon\Carbon::parse($patient->created_at)->age }} Tahun</p>
                            </div>
                            <h6>Alergi</h6>
                            <div class="mb-3">
                                <p>{{ $patient->allergy ?? 'Tidak ada alergi yang terdaftar' }}</p>
                            </div>
                            <h6>Golongan Darah</h6>
                            <div class="mb-3">
                                <p>{{ $patient->blood_type ?? 'Golongan darah tidak tersedia' }}</p>
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
                            <a href="/consultation-detail" class="booking-item-link">
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12345</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-17</span>
                                            <span class="booking-time">10:30 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-success">Berhasil</span>
                                </div>
                            </a>
                            <a href="/consultation-detail" class="booking-item-link">
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12346</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-18</span>
                                            <span class="booking-time">02:45 PM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-warning">Menunggu Pembayaran</span>
                                </div>
                            </a>
                            <a href="/consultation-detail" class="booking-item-link">
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12347</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-19</span>
                                            <span class="booking-time">09:00 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-info">Menunggu Approval</span>
                                </div>
                            </a>
                            <a href="/consultation-detail" class="booking-item-link">
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12348</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-20</span>
                                            <span class="booking-time">11:00 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-danger">Cancelled</span>
                                </div>
                            </a>
                            <!-- Tambahkan item lainnya jika diperlukan -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Emergency Section -->
<!-- Emergency FAB -->
<div id="emergency" class="emergency-fab">
    <!-- Sub-menu FAB buttons that will collapse/expand -->
    <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
        <a href="#" class="btn btn-success btn-lg mb-2 rounded-circle">
            <i class="fas fa-ambulance"></i>
        </a>
        <a href="#" class="btn btn-outline-success btn-lg rounded-circle mb-2">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
    <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()">
        <i class="fa-solid fa-phone"></i>
    </a>
</div>

<!-- Modal for Editing Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="mb-3">
                        <label for="profilePhoto" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="profilePhoto">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" value="Nama User">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="user@mail.com">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" rows="3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas efficitur, eros ut porttitor semper, ex tellus cursus ipsum, eu posuere augue turpis ac tortor.</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="allergy" class="form-label">Alergi</label>
                        <input type="text" class="form-control" id="allergy" value="Alergi ayam ras">
                    </div>
                    <div class="mb-3">
                        <label for="bloodType" class="form-label">Golongan Darah</label>
                        <input type="text" class="form-control" id="bloodType" value="B">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
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