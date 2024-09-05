<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>


    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class='dashboard'>
        <div class="dashboard-nav">
            <header>
                <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
                <a href="#" class="brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" style="width: 150px;">
                </a>
            </header>
            <nav class="dashboard-nav-list">
                <a href="#" class="dashboard-nav-item active">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-calendar-alt"></i> Reservasi
                    </a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="/dashboard_mcu" class="dashboard-nav-dropdown-item">MCU</a>
                        <a href="/dashboard_poli" class="dashboard-nav-dropdown-item">Pendaftaran Poli</a>
                        <a href="/dashboard_homeservice" class="dashboard-nav-dropdown-item">Home Service</a>
                    </div>
                </div>
                <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-info-circle"></i> Informasi
                    </a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="/dashboard_artikel" class="dashboard-nav-dropdown-item">Artikel</a>
                        <a href="/dashboard_promosi" class="dashboard-nav-dropdown-item">Promo</a>
                    </div>
                </div>
                <a href="/dashboard_dokter" class="dashboard-nav-item">
                    <i class="fas fa-user-md"></i> Dokter
                </a>
                <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-folder"></i> Master Data
                    </a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="/dashboard_user" class="dashboard-nav-dropdown-item">User</a>
                        <a href="/dashboard_role" class="dashboard-nav-dropdown-item">Role</a>
                        <a href="/dashboard_informasirs" class="dashboard-nav-dropdown-item">Informasi RS</a>
                        <a href="/dashboard_galerirs" class="dashboard-nav-dropdown-item">Galeri RS</a>
                    </div>
                </div>
                <a href="#" class="dashboard-nav-item">
                    <i class="fas fa-user-circle"></i> Profile
                </a>
                <div class="nav-item-divider"></div>
                <a href="#" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>

        <script>

            
            const mobileScreen = window.matchMedia("(max-width: 990px )");
            $(document).ready(function() {
                $(".dashboard-nav-dropdown-toggle").click(function() {
                    $(this).closest(".dashboard-nav-dropdown")
                        .toggleClass("show")
                        .find(".dashboard-nav-dropdown")
                        .removeClass("show");
                    $(this).parent()
                        .siblings()
                        .removeClass("show");
                });
                $(".menu-toggle").click(function() {
                    if (mobileScreen.matches) {
                        $(".dashboard-nav").toggleClass("mobile-show");
                    } else {
                        $(".dashboard").toggleClass("dashboard-compact");
                    }
                });
            });6
        </script>

</html>
