<div class="dashboard-nav">
    <header>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        <a href="<?php echo e(route('dashboard-page')); ?>" class="brand-logo">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Brand Logo" style="width: 150px;">
        </a>
    </header>

    <nav class="dashboard-nav-list">
        <a href="<?php echo e(route('dashboard-page')); ?>"
            class="dashboard-nav-item <?php echo e(Request::is('dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-home"></i> Beranda
        </a>

        <!-- Reservasi -->
        <div class="dashboard-nav-dropdown <?php echo e(Request::is('reservation-*') ? 'active' : ''); ?>">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-calendar-alt"></i> Reservasi
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="/reservation-mcu"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('reservation-mcu') ? 'active' : ''); ?>">MCU</a>
                <a href="/reservation-polyclinic"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('reservation-polyclinic') ? 'active' : ''); ?>">Pendaftaran Poli</a>
                <a href="/reservation-homeservice"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('reservation-homeservice') ? 'active' : ''); ?>">Home Service</a>
                <a href="/reservation-online-consultation"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('reservation-online-consultation') ? 'active' : ''); ?>">Konsultasi Online</a>
            </div>
        </div>

        <!-- Informasi -->
        <div class="dashboard-nav-dropdown <?php echo e(Request::is('information-*') ? 'active' : ''); ?>">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-info-circle"></i> Informasi
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="/information-article"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('information-article') ? 'active' : ''); ?>">Artikel</a>
                <a href="/information-promote"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('information-promote') ? 'active' : ''); ?>">Promo</a>
                <a href="<?php echo e(route('information-categories.index')); ?>"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('information-categories') ? 'active' : ''); ?>">Kategori</a>
            </div>
        </div>

        <!-- Dokter -->
        <div class="dashboard-nav-dropdown <?php echo e(Request::is('doctor-*') ? 'active' : ''); ?>">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-user-md"></i> Dokter
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="<?php echo e(route('doctor.data.index')); ?>"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('doctor/data') ? 'active' : ''); ?>">Data Dokter</a>
                <a href="<?php echo e(route('doctor.polyclinic.index')); ?>"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('doctor/polyclinic') ? 'active' : ''); ?>">Poliklinik Dokter</a>
            </div>
        </div>

        <!-- Master Data -->
        <div class="dashboard-nav-dropdown <?php echo e(Request::is('master-*') ? 'active' : ''); ?>">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-folder"></i> Master Data
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="/master-user"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('master-user') ? 'active' : ''); ?>">User</a>
                <a href="/master-role"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('master-role') ? 'active' : ''); ?>">Role</a>
                <a href="/master-info-cmh"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('master-info-cmh') ? 'active' : ''); ?>">Informasi RS</a>
                <a href="/master-gallery-cmh"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('category-polyclinic') ? 'active' : ''); ?>">Galeri RS</a>

            </div>
        </div>

        <!-- Skrining -->
        <div class="dashboard-nav-dropdown <?php echo e(Request::is('screening-*') || Request::is('question-categories*') || Request::is('screening_classifications*') ? 'active' : ''); ?>">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-heartbeat"></i> Skrining
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="<?php echo e(route('screening-depretion.index')); ?>"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('screening-depretion') ? 'active' : ''); ?>">Skrining Depresi</a>
                <a href="<?php echo e(route('question-categories.index')); ?>"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('question-categories*') ? 'active' : ''); ?>">Kategori Soal</a>
                <a href="<?php echo e(route('screening-classifications.index')); ?>"
                    class="dashboard-nav-dropdown-item <?php echo e(Request::is('screening-classifications*') ? 'active' : ''); ?>">Klasifikasi Skrining</a>
            </div>
        </div>

        <!-- Pasien -->
        <a href="/patient-data" class="dashboard-nav-item <?php echo e(Request::is('patient-data') ? 'active' : ''); ?>">
            <i class="fas fa-user-circle"></i> Pasien
        </a>

        <!-- File Sharing -->
        <a href="<?php echo e(route('file-sharing.index')); ?>" class="dashboard-nav-item <?php echo e(Request::is('sharing-master*') ? 'active' : ''); ?>">
            <i class="fas fa-archive"></i> File Sharing
        </a>

        <div class="nav-item-divider"></div>

        <!-- Display Logged-in User Info -->
        <div class="user-info" style="padding: 15px; display: flex; align-items: center;">
            <img src="<?php echo e(asset('images/userplaceholder.png')); ?>" alt="User Profile" class="rounded-circle"
                style="width: 50px; height: 50px; margin-right: 10px;">
            <span style="font-weight: bold;"><?php echo e(Auth::user()->username); ?></span>
        </div>

        <!-- Logout Link -->
        <a href="#" class="dashboard-nav-item"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
    </nav>
</div>
<?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/management-data/layouts/sidebar.blade.php ENDPATH**/ ?>