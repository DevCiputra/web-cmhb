<nav class="nav fixed-top">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="nav-title">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Ciputra Mitra Hospital Logo">
            </a>
        </div>
    </div>
    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <!-- Cek jika title bukan "Ciputra Mitra Hospital" -->
    @if(isset($title) && $title !== 'Ciputra Mitra Hospital')
    <!-- Navbar khusus (misal untuk halaman tertentu) -->
    <ul class="nav-list">
        <li><a class="nav-link" href="/doctor">Cari Dokter</a></li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Reservasi</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/medical-check-up">Medical Check Up (MCU)</a></li>
                <li><a class="dropdown-item" href="/polyclinic">Pendaftaran Poli</a></li>
                <li><a class="dropdown-item" href="/home-service">Home Service</a></li>
                <li><a class="dropdown-item" href="/online-consultation">Konsultasi Online</a></li>
            </ul>
        </li>
        <li><a class="nav-link" href="/promotion">Promo</a></li>
        <li><a class="nav-link" href="/information">Informasi</a></li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Fitur</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/skrining-depresi">Skrining Depresi</a></li>
                <li><a class="dropdown-item" href="/bmi">BMI</a></li>
            </ul>
        </li>
        <li><a class="nav-link" href="#emergency">IGD 24 Jam</a></li>

        @if(Auth::check())
        <!-- Jika halaman title == "Akun Saya" -->
        @if(isset($title) && $title === 'Akun Saya')
        <li>
            <a href="{{ route('logout') }}" class="btn-account" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @else
        <li><a href="{{ route('account-index') }}" class="btn-account">Akun Saya</a></li>
        @endif
        @else
        <li><a href="{{ route('register') }}" class="btn-account">Daftar</a></li>
        @endif

    </ul>
    @else
    <!-- Navbar default (untuk halaman umum atau beranda) -->
    <ul class="nav-list">
        <li><a class="nav-link" href="#doctor">Cari Dokter</a></li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Reservasi</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#card-mcu">Medical Check Up (MCU)</a></li>
                <li><a class="dropdown-item" href="#card-poliklinik">Pendaftaran Poli</a></li>
                <li><a class="dropdown-item" href="#card-home-service">Home Service</a></li>
                <li><a class="dropdown-item" href="#card-konsultasi">Konsultasi Online</a></li>
            </ul>
        </li>
        <li><a class="nav-link" href="#promotion">Promo</a></li>
        <li><a class="nav-link" href="#info">Informasi</a></li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Fitur</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#feature">Skrining Depresi</a></li>
                <li><a class="dropdown-item" href="#feature">BMI</a></li>
            </ul>
        </li>
        <li><a class="nav-link" href="#emergency">IGD 24 Jam</a></li>

        @if(Auth::check())
        <!-- Tampilkan Akun Saya jika user sudah login di halaman beranda -->
        <li><a href="{{ route('account-index') }}" class="btn-account">Akun Saya</a></li>
        @else
        <li><a href="{{ route('register') }}" class="btn-account">Akun Saya</a></li>
        @endif
    </ul>
    @endif
</nav>