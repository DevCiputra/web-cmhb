<div class="dashboard-nav">
    <header>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        <a href="#" class="brand-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" style="width: 150px;">
        </a>
    </header>

    <nav class="dashboard-nav-list">
        <a href="/dashboard" class="dashboard-nav-item active">
            <i class="fas fa-home"></i> Beranda
        </a>
        <!-- Reservasi -->
        <div class='dashboard-nav-dropdown'>
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-calendar-alt"></i> Reservasi
            </a>
            <div class='dashboard-nav-dropdown-menu'>
                <a href="/reservation-mcu" class="dashboard-nav-dropdown-item">MCU</a>
                <a href="/reservation-polyclinic" class="dashboard-nav-dropdown-item">Pendaftaran Poli</a>
                <a href="/reservation-homeservice" class="dashboard-nav-dropdown-item">Home Service</a>
                <a href="/reservation-online-consultation" class="dashboard-nav-dropdown-item">Konsultasi Online</a>
            </div>
        </div>

        <!-- Informasi -->
        <div class='dashboard-nav-dropdown'>
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-info-circle"></i> Informasi
            </a>
            <div class='dashboard-nav-dropdown-menu'>
                <a href="/information-article" class="dashboard-nav-dropdown-item">Artikel</a>
                <a href="/information-promote" class="dashboard-nav-dropdown-item">Promo</a>
            </div>
        </div>

        <!-- Dokter -->
        <div class='dashboard-nav-dropdown'>
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-user-md"></i> Dokter
            </a>
            <div class='dashboard-nav-dropdown-menu'>
                <a href="{{ route('doctor.data.index') }}" class="dashboard-nav-dropdown-item">Data Dokter</a>
                <a href="{{ route('doctor.polyclinic.index') }}" class="dashboard-nav-dropdown-item">Poliklinik
                    Dokter</a>
            </div>
        </div>

        <!-- Master Data -->
        <div class='dashboard-nav-dropdown'>
            <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-folder"></i> Master Data
            </a>
            <div class='dashboard-nav-dropdown-menu'>
                <a href="/master-user" class="dashboard-nav-dropdown-item">User</a>
                <a href="/master-role" class="dashboard-nav-dropdown-item">Role</a>
                <a href="/master-info-cmh" class="dashboard-nav-dropdown-item">Informasi RS</a>
                <a href="/master-gallery-cmh" class="dashboard-nav-dropdown-item">Galeri RS</a>
            </div>
        </div>

        <a href="/patient-data" class="dashboard-nav-item">
            <i class="fas fa-user-circle"></i> Pasien
        </a>

        <div class="nav-item-divider"></div>

        <!-- Display Logged-in User Info -->
        <div class="user-info" style="padding: 15px; display: flex; align-items: center;">
            <img src="{{ asset('images/userplaceholder.png') }}" alt="User Profile"
                class="rounded-circle" style="width: 50px; height: 50px; margin-right: 10px;">
            <span style="font-weight: bold;">{{ Auth::user()->username }}</span>
        </div>

        <!-- Logout Link -->
        <a href="#" class="dashboard-nav-item"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
</div>
