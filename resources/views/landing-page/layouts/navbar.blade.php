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
    <ul class="nav-list">
        @if (isset($title) && $title !== 'Ciputra Mitra Hospital')
        <li><a class="nav-link" href="/doctor">Cari Dokter</a></li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Reservasi</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/medical-check-up">Medical Check Up (MCU)</a></li>
                <li><a class="dropdown-item" href="{{ route('coming-page') }}">Pendaftaran Poli</a></li>
                <li><a class="dropdown-item" href="{{ route('coming-page') }}">Home Service</a></li>
                <li><a class="dropdown-item" href="/consultation-online">Konsultasi Online</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Informasi</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('promotion') }}">Promo</a></li>
                <li><a class="dropdown-item" href="{{ route('article') }}">Artikel</a></li>
                <li><a class="dropdown-item" href="https://antrian.ciputramitrahospital.id/antrianPasien" target="_blank">Antrian Online</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Fitur</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('screening.form') }}">Screening Psikologi</a></li>

                <li><a class="dropdown-item" href="{{ route('bmi-calculator') }}">BMI</a></li>
            </ul>
        </li>
        @else
        <li><a class="nav-link" href="#doctor">Cari Dokter</a></li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Reservasi</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#reservation">Medical Check Up (MCU)</a></li>
                <li><a class="dropdown-item" href="#reservation">Pendaftaran Poli</a></li>
                <li><a class="dropdown-item" href="#reservation">Home Service</a></li>
                <li><a class="dropdown-item" href="#reservation">Konsultasi Online</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Informasi</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#promotion">Promo</a></li>
                <li><a class="dropdown-item" href="#info">Artikel</a></li>
                <li><a class="dropdown-item" href="https://antrian.ciputramitrahospital.id/antrianPasien" target="_blank">Antrian Online</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle" style="margin-bottom:-5px;">Fitur</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#feature">Screening Psikologi</a></li>
                <li><a class="dropdown-item" href="#feature">BMI Calculator</a></li>
            </ul>
        </li>
        @endif
        <!-- Dropdown Akun -->
        <li class="nav-item dropdown">
            @if (Auth::check())
            <a href="#" class="btn-account dropdown-toggle">
                {{ explode(' ', Auth::user()->username)[0] }}
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('account-index') }}">Informasi Pribadi</a></li>
                <li><a class="dropdown-item" href="{{ route('account-index', ['tab' => 'riwayat']) }}">Riwayat Pemesanan</a></li>
                <li><a class="dropdown-item" href="{{ route('account-index', ['tab' => 'riwayat-skrining']) }}">Riwayat Skrining</a></li>
                <li>
                    <a href="{{ route('logout') }}" class="dropdown-item btn-logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
            <!-- Form Logout -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @else
            <!-- Tombol buat akun untuk pengguna yang tidak login -->
            <a href="{{ route('login') }}" class="btn-account">Log In</a>
            @endif
        </li>
    </ul>
</nav>