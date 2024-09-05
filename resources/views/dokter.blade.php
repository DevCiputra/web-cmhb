<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dokter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>

<body>
    <!-- Navbar Section -->
    @include('layouts.navbar')
    <div class="container" style="margin-top: 80px;">
        <!-- Breadcrumb Section -->
        <div class="container" style="margin-top: 110px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item" style="color: #023770">Cari Dokter</li>
                </ol>
            </nav>
        </div>

        <div id="list-doctor" class="header-section">
            <div class="container-fluid">
                <h1 style="margin-bottom: 5px;">Cari Dokter</h1>
                <p style="margin-bottom: 15px;">Temukan Dokter Profesional di Ciputra Mitra Hospital.</p>

                <!-- Filter Card Section -->
                <div class="row justify-content-center">
                    <div class="col-md-8 col-md-6">
                        <div class="card-filter mb-4">
                            <div class="filter-card-body">
                                <div class="row">
                                    <!-- Search Bar -->
                                    <div class="col-md-8 mb-2">
                                        <input type="text" class="form-control" placeholder="Cari dokter...">
                                    </div>
                                    <!-- Filter Dropdown -->
                                    <div class="col-md-4">
                                        <select class="form-select">
                                            <option selected>Pilih Spesialis</option>
                                            <option value="1">Cardiologist</option>
                                            <option value="2">Dermatologist</option>
                                            <option value="3">Pediatrician</option>
                                            <option value="4">General Practitioner</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Cards Container -->
                <div class="doctor-cards-container">
                    <div class="row">
                        <!-- Card 1 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter1.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. John Doe, Sp.A. </h5>
                                    <p class="specialist"s>Spesialis Anak</p>
                                    <a href="/profile" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter2.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Jane Smith, Sp.B.</h5>
                                    <p class="specialist">Spesialis Bedah</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter3.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Emily Johnson, Sp.PD.</h5>
                                    <p class="specialist">Spesialis Penyakit Dalam</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 4 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter4.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Michael Brown, Sp.G.</h5>
                                    <p class="specialist">Spesialis Gizi</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Additional Cards -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter5.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Lily Anderson, Sp.M.</h5>
                                    <p class="specialist">Spesialis Mata</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 1 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter1.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. John Doe, Sp.A. </h5>
                                    <p class="specialist">Spesialis Anak</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter2.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Jane Smith, Sp.B.</h5>
                                    <p class="specialist">Spesialis Bedah</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter3.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Emily Johnson, Sp.PD.</h5>
                                    <p class="specialist">Spesialis Penyakit Dalam</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 4 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter4.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Michael Brown, Sp.G.</h5>
                                    <p class="specialist">Spesialis Gizi</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 1 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter1.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. John Doe, Sp.A. </h5>
                                    <p class="specialist">Spesialis Anak</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter2.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Jane Smith, Sp.B.</h5>
                                    <p class="specialist">Spesialis Bedah</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="col-md-3 mb-4">
                            <div class="doctor-card">
                                <img class="doctor-card-img-top" src="{{ asset('images/dokter3.jpg') }}"
                                    alt="Doctor Image">
                                <div class="doctor-card-body">
                                    <h5 class="name">Dr. Emily Johnson, Sp.PD.</h5>
                                    <p class="specialist">Spesialis Penyakit Dalam</p>
                                    <a href="#" class="btn btn-profil">
                                        Lihat Profil
                                        <img src="{{ asset('icons/chevron-right.png') }}" alt="Chevron Right"
                                            class="chevron-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination Section -->
                    <div class="pagination-container d-flex justify-content-end">
                        <nav aria-label="Doctor pagination">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1<span class="sr-only"></span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
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
    </div>

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
