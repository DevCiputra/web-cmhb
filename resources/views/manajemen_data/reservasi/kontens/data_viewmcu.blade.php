<head>
    <link href="{{ asset('css/mcu_detail.css') }}" rel="stylesheet">
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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Detail Paket MCU</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_mcu ">Medical Check Up</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Paket MCU</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 6rem;">
                    <div class="mcu-package">
                        <h1 class="title">Nama Paket MCU</h1>
                        <h3 class="price">Rp. 500.000</h3>
                        <div class="mcu-photo">
                            <img src="{{ asset('images/mcu1.jpg') }}" alt="mcu Photo">
                        </div>
                    </div>
        
                    <!-- mcu Description Section -->
                    <div class="mcu-description">
                        <h4>Rincian Paket</h4>
                        <ul>
                            <li class="description-item">Darah Lengkap</li>
                            <li class="description-item">Trigliserida</li>
                            <li class="description-item">LDL Kolesterol</li>
                            <li class="description-item">Gula Darah Puasa</li>
                            <li class="description-item">Konsultasi Dokter Spesialis MCU</li>
                            <li class="description-item">Cholesterol Total</li>
                            <li class="description-item">EKG</li>
                        </ul>
                    </div>
        
                    <!-- mcu Information Section -->
                    <div class="mcu-info">
                        <h4>Informasi Penting</h4>
                        <ul>
                            <li class="info-item">Harap membawa identitas diri (KTP/Paspor) untuk dewasa </li>
                            <li class="info-item">Untuk anak di bawah 17 tahun harap membawa foto copy Akte Kelahiran </li>
                            <li class="info-item">Puasa 10 - 12 jam sebelum pemeriksaan dilaksanakan</li>
                        </ul>
                    </div>
        
                    <div class="text-center" style="margin-top: 40px;">
                        <a href="#" class="btn btn-reservation"
                            style="background-color: #007858; color:white; border-color: #007858; border-radius: 18px; margin-bottom:10px">
                            Reservasi Sekarang
                        </a>
                    </div>
            </div>
        </div>

       
    </div>
</div>

