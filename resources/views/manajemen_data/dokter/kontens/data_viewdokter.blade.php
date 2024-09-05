<head>
    <link href="{{ asset('css/dokter_profile.css') }}" rel="stylesheet">
</head>

@include('manajemen_data.layouts.dashboard')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Profile Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_dokter">Dokter</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Tambah Data Dokter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 6rem;">
                <!-- Doctor Profile Section -->
                <div class="doctor-detail">
                    <h1 class="doctor-name">Nama Dokter</h1>
                    <h3 class="doctor-specialist">Nama Spesialis</h3>
                    <div class="doctor-photo">
                        <img src="{{ asset('images/dokter1.jpg') }}" alt="Doctor Photo">
                    </div>
                </div>
    
                <!-- Doctor Education Section -->
                <div class="doctor-education">
                    <h4>Riwayat Pendidikan</h4>
                    <ul>
                        <li class="education-item">Riwayat Pendidikan 1</li>
                        <li class="education-item">Riwayat Pendidikan 2</li>
                        <li class="education-item">Riwayat Pendidikan 3</li>
                    </ul>
                </div>
    
                <!-- Doctor Schedule Section -->
                <div class="doctor-schedule">
                    <h4>Jadwal Praktek</h4>
                    <ul>
                        <li class="schedule-item">Senin: 13:00 – 18:00</li>
                        <li class="schedule-item">Rabu: 14:00 – 19:00</li>
                        <li class="schedule-item">Sabtu: 10:00 – 13:00</li>
                    </ul>
                </div>
    
                <!-- Doctor Profile Video Section -->
                <div class="doctor-profile-video">
                    <h4>Video Profile</h4>
                    <video controls>
                        <source src="path_to_video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
    
                <!-- Doctor Success Rate Section -->
                <div class="doctor-success-rate">
                    <h4>Angka Keberhasilan Operasi</h4>
                    <ul>
                        <li class="success-rate-item">Operasi A: 65%</li>
                        <li class="success-rate-item">Operasi B: 43%</li>
                    </ul>
                </div>
            </div>
        </div>

       
    </div>
</div>

