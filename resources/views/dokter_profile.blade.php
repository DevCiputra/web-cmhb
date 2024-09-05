<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dokter_profile.css') }}">
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
                    <li class="breadcrumb-item"><a href="/dokter">Cari Dokter</a> </li>
                    <li class="breadcrumb-item active" style="color: #023770">Profile Dokter</li>
                </ol>
            </nav>
        </div>
        <div class="container doctor-profile" style="margin-top: 40px;">
            <!-- Doctor Profile Section -->
            <div class="doctor-detail">
                <h1 class="doctor-name">Nama Dokter</h1>
                <h3 class="doctor-specialist">Nama Spesialis</h3>
                <div class="doctor-photo">
                    <img src="{{ asset('images/dokter1.jpg') }}" alt="Doctor Photo">
                </div>
            </div>

            <!-- Doctor Education Section -->
            <div class="doctor-education">
                <h4>Riwayat Pendidikan</h4>
                <ul>
                    <li class="education-item">Riwayat Pendidikan 1</li>
                    <li class="education-item">Riwayat Pendidikan 2</li>
                    <li class="education-item">Riwayat Pendidikan 3</li>
                </ul>
            </div>

            <!-- Doctor Schedule Section -->
            <div class="doctor-schedule">
                <h4>Jadwal Praktek</h4>
                <ul>
                    <li class="schedule-item">Senin: 13:00 – 18:00</li>
                    <li class="schedule-item">Rabu: 14:00 – 19:00</li>
                    <li class="schedule-item">Sabtu: 10:00 – 13:00</li>
                </ul>
            </div>

            <!-- Doctor Profile Video Section -->
            <div class="doctor-profile-video">
                <h4>Video Profile</h4>
                <video controls>
                    <source src="path_to_video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <!-- Doctor Success Rate Section -->
            <div class="doctor-success-rate">
                <h4>Angka Keberhasilan Operasi</h4>
                <ul>
                    <li class="success-rate-item">Operasi A: 65%</li>
                    <li class="success-rate-item">Operasi B: 43%</li>
                </ul>
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
</body>

</html>
