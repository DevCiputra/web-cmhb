<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/poliklinik.css') }}">
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
                    <li class="breadcrumb-item"><a href=" ">Reservasi</a></li>
                    <li class="breadcrumb-item" style="color: #023770">Pendaftaran Poliklinik</li>
                </ol>
            </nav>
        </div>

        <div id="list-poli" class="header-section">
            <div class="container-fluid">
                <h1 style="margin-bottom: 5px;">Pendaftaran Poliklinik</h1>
                <p style="margin-bottom: 15px;">Daftar Poliklinik yang tersedia di Ciputra Mitra Hospital</p>
            </div>

            <!-- Filter Card Section -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-6">
                    <div class="card-filter mb-4">
                        <div class="filter-card-body">
                            <div class="row">
                                <!-- Search Bar -->
                                <div class="col">
                                    <input type="text" id="searchPoli" class="form-control"
                                        placeholder="Cari Poliklinik...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accordion Section -->
            <div class="accordion" id="accordionPoliklinik">
                <!-- Poliklinik 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Poliklinik Umum
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionPoliklinik">
                        <div class="accordion-body">
                            <p>Pelayanan kesehatan umum untuk pemeriksaan dan konsultasi kesehatan sehari-hari.</p>
                            <a href="#" class="btn btn-primary">Reservasi</a>
                            <a href="/dokter" class="btn btn-outline-primary">Lihat Dokter</a>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Poliklinik 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Poliklinik Gigi
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionPoliklinik">
                        <div class="accordion-body">
                            <p>Pelayanan perawatan kesehatan gigi dan mulut, serta konsultasi masalah gigi.</p>
                            <a href="#" class="btn btn-primary">Reservasi</a>
                            <a href="/dokter" class="btn btn-outline-primary">Lihat Dokter</a>
                        </div>
                    </div>
                </div>

                <!-- Poliklinik 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Poliklinik Anak
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionPoliklinik">
                        <div class="accordion-body">
                            <p>Layanan kesehatan khusus anak, termasuk imunisasi dan konsultasi tumbuh kembang.</p>
                            <a href="#" class="btn btn-primary">Reservasi</a>
                            <a href="/dokter" class="btn btn-outline-primary">Lihat Dokter</a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Pagination Section -->
            <div class="pagination-container d-flex justify-content-end">
                <nav aria-label="mcu pagination">
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

    @include('layouts.footer')
    <script src="{{ asset('js/navbar.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#searchPoli").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".accordion-item").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });

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
    </script>
</body>

</html>
