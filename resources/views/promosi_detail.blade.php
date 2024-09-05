<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Promo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/promosi_detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>

<body>
    <!-- Navbar Section -->
    @include('layouts.navbar')

    <!-- Main Container -->
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container breadcrumb-container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="">Promo</a> </li>
                    <li class="breadcrumb-item active" style="color: #023770">Paket Promo</li>
                </ol>
            </nav>
        </div>
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
            <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle"
                onclick="toggleEmergencyButtons()">
                <i class="fa-solid fa-phone"></i>
            </a>
        </div>

        <!-- Footer Section -->
        @include('layouts.footer')
        <script src="{{ asset('js/navbar.js') }}"></script>
        <script>
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
    </div>
</body>

</html>
