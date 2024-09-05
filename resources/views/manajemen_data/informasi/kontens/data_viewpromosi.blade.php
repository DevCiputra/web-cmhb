<head>
    <link href="{{ asset('css/promosi_detail.css') }}" rel="stylesheet">
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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Detail Promo</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_promosi ">Promo</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Promo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="container promosi-detail" style="margin-top: 40px;">
                <!-- promosi Package Section -->
                <div class="promosi-package">
                    <h1 class="title">Nama Paket Promo</h1>
                    <h3 class="price">Rp. 500.000</h3>
                    <div class="promosi-photo">
                        <img src="{{ asset('images/promo1.jpg') }}" alt="promosi Photo">
                    </div>
                </div>
    
                <!-- promosi Description Section -->
                <div class="promosi-description">
                    <h4>Rincian Paket</h4>
                    <ul>
                        <li class="description-item">Darah Lengkap</li>
                        <li class="description-item">Trigliserida</li>
                        <li class="description-item">LDL Kolesterol</li>
                        <li class="description-item">Gula Darah Puasa</li>
                        <li class="description-item">Konsultasi Dokter Spesialis promosi</li>
                        <li class="description-item">Cholesterol Total</li>
                        <li class="description-item">EKG</li>
                    </ul>
                </div>
    
                <!-- promosi Information Section -->
                <div class="promosi-info">
                    <h4>Informasi Penting</h4>
                    <ul>
                        <li class="info-item">Berlaku hingga 31 Desember</li>
                        <li class="info-item">Untuk anak di bawah 17 tahun harap membawa foto copy Akte Kelahiran</li>
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

<script>
    $(document).ready(function() {
        $('#deskripsiMCU').summernote({
            height: 400, // Set the height of the editor
            placeholder: 'Masukkan Deskripsi MCU',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
