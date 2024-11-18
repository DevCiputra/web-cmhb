@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <!-- Hero Section -->
    <div id="hero" class="hero-section">
        <div class="hero-content">
            <div class="row align-items-center">
                <div class="col-md-6 hero-text">
                    <h1>Care For Your Health & Happiness</h1>
                    <p>Jaga kesehatan Anda dengan layanan medis yang terpercaya dan dukungan profesional dari para ahli.</p>
                    <div class="hero-buttons">
                        <a href="/doctor" class="btn btn-outline-success btn-lg" style="border-radius: 30px;">Cari Dokter</a>
                    </div>
                </div>
                <div class="col-md-6 hero-image">
                    <img src="{{ asset('images/cmh-new.jpeg') }}" alt="Doctor and patient" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="icon-card">
            <div class="card-content">
                <div class="icon-text">
                    <i class="fas fa-user-md"></i>
                    <div>
                        <strong>52</strong>
                        <p>DOKTER SPESIALIS</p>
                    </div>
                </div>
                <div class="icon-text">
                    <i class="fas fa-bed"></i>
                    <div>
                        <strong>156</strong>
                        <p>BEDS</p>
                    </div>
                </div>
                <!-- Teks Center of Excellence -->
                <div class="icon-text">
                    <i class="fas fa-heartbeat"></i>
                    <div>
                        <p id="center-of-excellence" style="cursor: pointer;"> <strong>CENTER OF EXCELLENCE</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Section -->
    <div id="doctor" class="doctor-section">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 doctor-image">
                    <img src="{{ asset('images/alldok.jpg') }}" alt="Doctors" class="img-fluid">
                </div>
                <div class="col-md-6 doctor-text">
                    <h1>Temukan Dokter Profesional</h1>
                    <p>Dapatkan perawatan yang sesuai dari dokter profesional yang berpengalaman di bidangnya.</p>
                    <div class="doctor-buttons">
                        <a href="/doctor" class="btn btn-success btn-lg"
                            style="margin-right: 0.5rem; border-radius: 30px;">Cari Dokter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Section -->
    <div id="reservation" class="reservation-section">
        <div class="container">
            <h1>Reservasi Layanan</h1>
            <p>Pilih layanan kesehatan yang Anda butuhkan dan buat reservasi dengan mudah.</p>
            <div class="row justify-content-center">
                <!-- Column 1 -->
                <div class="col-md-5 d-flex flex-column">
                    <a href="{{ route('medical-check-up') }}" class="reservation-item mb-3" id="card-mcu">
                        <div class="reservation-content">
                            <img src="{{ asset('images/mcu-new.jpg') }}" alt="Medical Check Up" class="img-fluid">
                            <div class="reservation-info">
                                <h2>Medical Check Up (MCU)</h2>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('coming-page') }}" class="reservation-item mb-3" id="card-home-service">
                        <div class="reservation-content">
                            <img src="{{ asset('images/homeservis.png') }}" alt="Home Service" class="img-fluid">
                            <div class="reservation-info">
                                <h2> Layanan Home Service</h2>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Column 2 -->
                <div class="col-md-5 d-flex flex-column">
                    <a href="{{ route('coming-page') }}" class="reservation-item mb-3" id="card-poliklinik">
                        <div class="reservation-content">
                            <img src="{{ asset('images/poli-new.jpeg') }}" alt="Pendaftaran Poliklinik"
                                class="img-fluid">
                            <div class="reservation-info">
                                <h2>Pendaftaran Poliklinik</h2>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('onlineconsultation.landing') }}" class="reservation-item mb-3"
                        id="card-konsultasi">
                        <div class="reservation-content">
                            <img src="{{ asset('images/konsul-dokter.jpg') }}" alt="Konsultasi Online" class="img-fluid">
                            <div class="reservation-info">
                                <h2>Konsultasi Online</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <!-- Promotion Section -->
    <div id="promotion" class="promotion-section">
        <div class="container-fluid">
            <h1 style="margin-bottom: 10px;">Promo</h1>
            <p style="margin-bottom: 15px;">Dapatkan penawaran menarik untuk berbagai layanan kesehatan kami.</p>
            <a href="{{ route('coming-page') }}" class="btn btn-semua"
                style="color:#023770; font-size: 1.2rem; margin-top: -10px; margin-bottom: 10px">
                Lihat Semua
                <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right" class="chevron-icon">
            </a>
            <div class="row">
                <div class="col-md-4 promotion-item">
                    <div class="promotion-content">
                        <img src="{{ asset('images/promo1.jpg') }}" alt="Medical Check Up" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4 promotion-item">
                    <div class="promotion-content">
                        <img src="{{ asset('images/promo2.jpg') }}" alt="Pendaftaran Poliklinik" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4 promotion-item">
                    <div class="promotion-content">
                        <img src="{{ asset('images/promo3.jpg') }}" alt="Home Service" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Section -->
    <!-- <div id="info" class="info-section">
        <div class="container">
            <h1 style="margin-bottom: 10px;">What's New</h1>
            <p style="margin-bottom: 15px;">Lorem ipsum dolor sit amet consectetur adipiscing elit semper dalar
                elementum tempus hac tellus libero accumsan.</p>
            <a href="{{ route('coming-page') }}" class="btn btn-semua"
                style="color:#023770; font-size: 1.2rem; margin-top: -10px; margin-bottom: 10px">
                Lihat Semua
                <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right" class="chevron-icon">
            </a>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="info-item">
                        <div class="info-content card">
                            <div class="badge-container">
                                <span class="badge">Artikel</span>
                            </div>
                            <img src="{{ asset('images/info1.png') }}" class="card-img-top" alt="Info 1">
                            <div class="card-body">
                                <h5 class="card-title">Title 1</h5>
                                <p class="card-text">Some quick example text to build on the card.</p>
                                <a href="{{ route('coming-page') }}" class="btn btn-link">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="info-item">
                        <div class="info-content card">
                            <div class="badge-container">
                                <span class="badge">Health Tips</span>
                            </div>
                            <img src="{{ asset('images/info2.png') }}" class="card-img-top" alt="Info 2">
                            <div class="card-body">
                                <h5 class="card-title">Title 2</h5>
                                <p class="card-text">Some quick example text to build on the card.</p>
                                <a href="{{ route('coming-page') }}" class="btn btn-link">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="info-item">
                        <div class="info-content card">
                            <div class="badge-container">
                                <span class="badge">Event</span>
                            </div>
                            <img src="{{ asset('images/info3.png') }}" class="card-img-top" alt="Info 3">
                            <div class="card-body">
                                <h5 class="card-title">Title 3</h5>
                                <p class="card-text">Some quick example text to build on the card.</p>
                                <a href="{{ route('coming-page') }}" class="btn btn-link">
                                    Selengkapnya
                                    <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                        class="chevron-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Feature Section -->
    <div id="feature" class="feature-section">
        <div class="container">
            <h1>Jelajahi Fitur Kami</h1>
            <p>Temukan berbagai fitur yang dapat membantu Anda untuk menjalani hidup yang lebih sehat dan lebih baik.</p>
            <div class="row g-4">
                <!-- Column 1 -->
                <div class="col-md-6">
                    <div class="feature-item" style="background-color: #DFF2ED;">
                        <h5 class="feature-title">Screening depression, anxiety & stress</h5>
                        <p class="card-text">Lakukan screening untuk mengetahui potensi depresi, kecemasan dan stres. dapatkan rekomendasi tindakan selanjutnya yang sesuai.</p>
                        <a href="{{ route('screening.form') }}" class="btn btn-outline-success btn-lg rounded-pill">Mulai Skrining</a>
                    </div>
                </div>
                <!-- Column 2 -->
                <div class="col-md-6">
                    <div class="feature-item" style="border-color: #CCE4DE;">
                        <h5 class="feature-title">Body Mass Index (BMI)</h5>
                        <p class="card-text">Cek status kesehatan tubuh Anda untuk mengetahui apakah berat badan Anda ideal.</p>
                        <a href="{{ route('coming-page') }}" class="btn btn-success btn-lg rounded-pill">Coba Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Custom -->
    <div id="excellenceModal" class="modal">
        <div class="modal-content">
            <button type="button" class="close">&times;</button>
            <img src="{{ asset('images/coe-chp.png') }}" alt="Center of Excellence" class="img-fluid">
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
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>
<script>
    function toggleEmergencyButtons() {
        const buttons = document.getElementById("emergency-buttons");
        const isExpanded = buttons.classList.toggle("expand");

        // Set maxHeight untuk animasi expand/collapse
        buttons.style.maxHeight = isExpanded ? "200px" : "0px";
    }
</script>


<!-- JavaScript untuk mengontrol modal -->
<script>
    // JavaScript for controlling modal
    const excellenceBtn = document.getElementById('center-of-excellence');
    const modal = document.getElementById('excellenceModal');
    const closeModal = document.querySelector('.close');

    // Open the modal when the icon is clicked
    excellenceBtn.onclick = function() {
        modal.style.display = 'block';
        // Adding a slight delay to show modal after animation starts
        setTimeout(function() {
            modal.style.opacity = 1;
        }, 100);
    }

    // Close the modal when the close button is clicked
    closeModal.onclick = function() {
        modal.style.display = 'none';
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
<!-- CSS untuk modal -->
<style>
    /* Modal Styling */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Black background with opacity */
        overflow: auto;
        padding-top: 60px;
        /* Spacing from the top */
        animation: fadeIn 0.5s ease-out;
        /* Fade-in effect when modal opens */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        /* Center the modal */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        /* Maximum width for a larger modal */
        border-radius: 10px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
        /* Soft shadow for depth */
        transform: translateY(-30px);
        animation: slideUp 0.5s ease-out forwards;
        /* Slide-up effect when modal opens */
    }

    /* Close Button */
    .close {
        color: #aaa;
        font-size: 36px;
        font-weight: bold;
        background-color: transparent;
        border: none;
        position: absolute;
        top: 15px;
        right: 15px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close:hover,
    .close:focus {
        color: #ff4040;
        /* Red color when hovering */
    }

    /* Image Styling */
    .modal-body img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    /* Fade-in and Slide-up Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            transform: translateY(-30px);
        }

        to {
            transform: translateY(0);
        }
    }
</style>
@endpush