<div class="dashboard-nav">
    <header>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        <a href="{{ route('dashboard-page') }}" class="brand-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" style="width: 150px;">
        </a>
    </header>

    <nav class="dashboard-nav-list">
        <a href="{{ route('dashboard-page') }}" class="dashboard-nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Beranda
        </a>

        <!-- Reservasi -->
        <div class="dashboard-nav-dropdown {{ Request::is('reservation-*') ? 'active' : '' }}">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-calendar-alt"></i> Reservasi
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="/reservation-mcu" class="dashboard-nav-dropdown-item {{ Request::is('reservation-mcu') ? 'active' : '' }}">MCU</a>
                <a href="/reservation-polyclinic" class="dashboard-nav-dropdown-item {{ Request::is('reservation-polyclinic') ? 'active' : '' }}">Pendaftaran Poli</a>
                <a href="/reservation-homeservice" class="dashboard-nav-dropdown-item {{ Request::is('reservation-homeservice') ? 'active' : '' }}">Home Service</a>
                <a href="/reservation-online-consultation" class="dashboard-nav-dropdown-item {{ Request::is('reservation-online-consultation') ? 'active' : '' }}">Konsultasi Online</a>
            </div>
        </div>

        <!-- Informasi -->
        <div class="dashboard-nav-dropdown {{ Request::is('information-*') ? 'active' : '' }}">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-info-circle"></i> Informasi
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="/information-article" class="dashboard-nav-dropdown-item {{ Request::is('information-article') ? 'active' : '' }}">Artikel</a>
                <a href="/information-promotion" class="dashboard-nav-dropdown-item {{ Request::is('information-promotion') ? 'active' : '' }}">Promo</a>
                <a href="{{ route('information-categories.index') }}" class="dashboard-nav-dropdown-item {{ Request::is('information-categories') ? 'active' : '' }}">Kategori</a>
            </div>
        </div>

        <!-- Dokter -->
        <div class="dashboard-nav-dropdown {{ Request::is('doctor-*') ? 'active' : '' }}">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-user-md"></i> Dokter
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="{{ route('doctor.data.index') }}" class="dashboard-nav-dropdown-item {{ Request::is('doctor/data') ? 'active' : '' }}">Data Dokter</a>
                <a href="{{ route('doctor.polyclinic.index') }}" class="dashboard-nav-dropdown-item {{ Request::is('doctor/polyclinic') ? 'active' : '' }}">Poliklinik Dokter</a>
            </div>
        </div>

        <!-- Master Data -->
        <div class="dashboard-nav-dropdown {{ Request::is('master-*') ? 'active' : '' }}">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-folder"></i> Master Data
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="/master-user" class="dashboard-nav-dropdown-item {{ Request::is('master-user') ? 'active' : '' }}">User</a>
                <a href="/master-role" class="dashboard-nav-dropdown-item {{ Request::is('master-role') ? 'active' : '' }}">Role</a>
                <a href="/master-info-cmh" class="dashboard-nav-dropdown-item {{ Request::is('master-info-cmh') ? 'active' : '' }}">Informasi RS</a>
                <a href="/master-gallery-cmh" class="dashboard-nav-dropdown-item {{ Request::is('master-gallery-cmh') ? 'active' : '' }}">Galeri RS</a>
            </div>
        </div>

        <!-- Skrining -->
        <div class="dashboard-nav-dropdown {{ Request::is('screening-*') || Request::is('question-categories*') || Request::is('screening_classifications*') ? 'active' : '' }}">
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-heartbeat"></i> Skrining
            </a>
            <div class="dashboard-nav-dropdown-menu">
                <a href="{{ route('screening-depretion.index') }}" class="dashboard-nav-dropdown-item {{ Request::is('screening-depretion') ? 'active' : '' }}">Skrining Depresi</a>

                <!-- Menambahkan submenu untuk kategori soal -->
                <a href="{{ route('question-categories.index') }}" class="dashboard-nav-dropdown-item {{ Request::is('question-categories*') ? 'active' : '' }}">Kategori Soal</a>

                <!-- Menambahkan submenu untuk klasifikasi skrining -->
                <a href="{{ route('screening-classifications.index') }}" class="dashboard-nav-dropdown-item {{ Request::is('screening-classifications*') ? 'active' : '' }}">Klasifikasi Skrining</a>

            </div>
        </div>

        <!-- Pasien -->
        <a href="/patient-data" class="dashboard-nav-item {{ Request::is('patient-data') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> Pasien
        </a>

        <div class="nav-item-divider"></div>

        <!-- Display Logged-in User Info -->
        <div class="user-info" style="padding: 15px; display: flex; align-items: center;">
            <img src="{{ asset('images/userplaceholder.png') }}" alt="User Profile" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 10px;">
            <span style="font-weight: bold;">{{ Auth::user()->username }}</span>
        </div>

        <!-- Logout Link -->
        <a href="#" class="dashboard-nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
</div>