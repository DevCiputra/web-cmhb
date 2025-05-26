

<?php $__env->startSection('content'); ?>
<div class="container" style="margin-top: 80px;">
    <!-- Hero Section -->
    <div id="hero" class="hero-section">
        <div class="hero-content">
            <div class="row align-items-center">
                <div class="col-md-6 hero-text">
                    <h1><?php echo e($hospitalInformation->vision ?? 'Care For Your Health & Happiness'); ?></h1>
                    <p>Jaga kesehatan Anda dengan layanan medis yang terpercaya dan dukungan profesional dari para ahli.</p>
                    <div class="hero-buttons">
                        <a href="/doctor" class="btn btn-outline-success btn-lg" style="border-radius: 30px;">Cari Dokter</a>
                    </div>
                </div>
                <div class="col-md-6 hero-image">
                    <img src="<?php echo e(asset('images/cmh-new.jpeg')); ?>" alt="Doctor and patient" class="img-fluid">
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
                    <img src="<?php echo e(asset('images/alldok.jpg')); ?>" alt="Doctors" class="img-fluid">
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
                    <a href="<?php echo e(route('medical-check-up')); ?>" class="reservation-item mb-3" id="card-mcu">
                        <div class="reservation-content">
                            <img src="<?php echo e(asset('images/mcu-new.jpg')); ?>" alt="Medical Check Up" class="img-fluid">
                            <div class="reservation-info">
                                <h2>Medical Check Up (MCU)</h2>
                            </div>
                        </div>
                    </a>
                    <a href="<?php echo e(route('coming-page')); ?>" class="reservation-item mb-3" id="card-home-service">
                        <div class="reservation-content">
                            <img src="<?php echo e(asset('images/homeservis.png')); ?>" alt="Home Service" class="img-fluid">
                            <div class="reservation-info">
                                <h2> Layanan Home Service</h2>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Column 2 -->
                <div class="col-md-5 d-flex flex-column">
                    <a href="<?php echo e(route('coming-page')); ?>" class="reservation-item mb-3" id="card-poliklinik">
                        <div class="reservation-content">
                            <img src="<?php echo e(asset('images/poli-new.jpeg')); ?>" alt="Pendaftaran Poliklinik"
                                class="img-fluid">
                            <div class="reservation-info">
                                <h2>Pendaftaran Poliklinik</h2>
                            </div>
                        </div>
                    </a>
                    <a href="<?php echo e(route('onlineconsultation.landing')); ?>" class="reservation-item mb-3"
                        id="card-konsultasi">
                        <div class="reservation-content">
                            <img src="<?php echo e(asset('images/konsul-dokter.jpg')); ?>" alt="Konsultasi Online" class="img-fluid">
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
            <a href="<?php echo e(route('promotion')); ?>" class="btn btn-semua"
                style="color:#023770; font-size: 1.2rem; margin-top: -10px; margin-bottom: 10px">
                Lihat Semua
                <img src="<?php echo e(asset('icons/chevron-right.png')); ?>" alt="Chevron Right" class="chevron-icon">
            </a>
            <div class="row">
                <?php $__currentLoopData = $promotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 promotion-item">
                    <div class="promotion-content">
                        <?php if($promo->media->isNotEmpty()): ?>
                        <img src="<?php echo e($promo->media->first()->file_url); ?>" alt="<?php echo e($promo->title); ?>" class="img-fluid">
                        <?php else: ?>
                        <img src="<?php echo e(asset('images/default-promo.jpg')); ?>" alt="Default Promo" class="img-fluid">
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<!-- Information Section -->
<div id="info" class="info-section">
    <div class="container">
        <h1 style="margin-bottom: 10px;">What's New</h1>
        <p style="margin-bottom: 15px;">Informasi terbaru tentang kesehatan dan layanan kami.</p>
        <a href="<?php echo e(route('article')); ?>" class="btn btn-semua"
            style="color:#023770; font-size: 1.2rem; margin-top: -10px; margin-bottom: 10px">
            Lihat Semua
            <img src="<?php echo e(asset('icons/chevron-right.png')); ?>" alt="Chevron Right" class="chevron-icon">
        </a>
        <div class="row g-4" style="display: flex; flex-wrap: wrap;">
            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6" style="display: flex; flex-direction: column;">
                <div class="info-item" style="flex: 1; display: flex; flex-direction: column;">
                    <div class="info-content card" style="display: flex; flex-direction: column; height: 100%;">
                        <div class="badge-container">
                            <span class="badge">Artikel</span>
                        </div>
                        <?php if($article->media->isNotEmpty()): ?>
                        <img src="<?php echo e($article->media->first()->file_url); ?>" class="card-img-top" alt="<?php echo e($article->title); ?>">
                        <?php else: ?>
                        <img src="<?php echo e(asset('images/default-article.jpg')); ?>" class="card-img-top" alt="Default Article">
                        <?php endif; ?>
                        <div class="card-body" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <h5 class="card-title"><?php echo e($article->title); ?></h5>
                            <p class="card-text" style="line-height: 1.6; word-wrap: break-word; text-align: justify;">
                                <?php echo e(\Illuminate\Support\Str::limit(html_entity_decode(strip_tags($article->description)), 100)); ?>

                            </p>
                            
                            <a href="<?php echo e(route('article.detail.landing', ['id' => $article->id])); ?>" class="btn btn-link">
                                Selengkapnya
                                <img src="<?php echo e(asset('icons/chevron-right.png')); ?>" alt="Chevron Right" class="chevron-icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>


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
                        <p class="card-text">Lakukan screening untuk mengetahui potensi depresi, kecemasan dan stres.</p>
                        <a href="<?php echo e(route('screening.form')); ?>" class="btn btn-outline-success btn-lg rounded-pill">Mulai Skrining</a>
                    </div>
                </div>
                <!-- Column 2 -->
                <div class="col-md-6">
                    <div class="feature-item" style="border-color: #CCE4DE;">
                        <h5 class="feature-title">Body Mass Index (BMI)</h5>
                        <p class="card-text">Cek status kesehatan tubuh Anda untuk mengetahui apakah berat badan Anda ideal.</p>
                        <a href="<?php echo e(route('bmi-calculator')); ?>" class="btn btn-success btn-lg rounded-pill">Coba Sekarang</a>
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

    <!-- Modal Custom -->
    <div id="excellenceModal" class="modal">
        <div class="modal-content">
            <button type="button" class="close">&times;</button>
            <img src="<?php echo e(asset('images/coe-chp.png')); ?>" alt="Center of Excellence" class="img-fluid">
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/navbar.js')); ?>"></script>
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

    setTimeout(function() {
        location.reload();
    }, 300000); // 300000 ms = 5 menit

</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/landingpage.css')); ?>">
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('landing-page.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/landing-page/contents/landing-page.blade.php ENDPATH**/ ?>