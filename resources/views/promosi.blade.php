<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/promosi.css') }}">
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
                    <li class="breadcrumb-item" style="color: #023770">Promo</li>
                </ol>
            </nav>
        </div>

        <div id="header-promosi" class="header-section">
            <div class="container-fluid">
                <h1 style="margin-bottom: 5px;">Promo</h1>
                <p style="margin-bottom: 15px;">Temukan paket promo yang tersedia di Ciputra Mitra Hospital</p>
            </div>

            <!-- Filter Card Section -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-6">
                    <div class="card-filter mb-4">
                        <div class="filter-card-body">
                            <div class="row">
                                <!-- Filter Dropdown -->
                                <div class="col-lg-8">
                                    <select class="form-select">
                                        <option selected>Pilih Promo</option>
                                        <option value="1">Terbaru</option>
                                        <option value="2">Skrining</option>
                                        <option value="3">CT-Scan</option>
                                        <option value="4">MRI</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotions Card Section -->
            <div class="row">
                <div class="col-md-4 promotion-item">
                    <a href="/promosi_detail" class="text-decoration-none">
                        <div class="promotion-content">
                            <img src="{{ asset('images/promo1.jpg') }}" alt="Medical Check Up" class="img-fluid">
                        </div>
                    </a>
                </div>
                <div class="col-md-4 promotion-item">
                    <a href="/promosi_detail" class="text-decoration-none">
                        <div class="promotion-content">
                            <img src="{{ asset('images/promo2.jpg') }}" alt="Pendaftaran Poliklinik" class="img-fluid">
                        </div>
                    </a>
                </div>
                <div class="col-md-4 promotion-item">
                    <a href="/promosi_detail" class="text-decoration-none">
                        <div class="promotion-content">
                            <img src="{{ asset('images/promo3.jpg') }}" alt="Home Service" class="img-fluid">
                        </div>
                    </a>
                </div>
                <div class="col-md-4 promotion-item">
                    <a href="/promosi_detail" class="text-decoration-none">
                        <div class="promotion-content">
                            <img src="{{ asset('images/promo1.jpg') }}" alt="Medical Check Up" class="img-fluid">
                        </div>
                    </a>
                </div>
                <div class="col-md-4 promotion-item">
                    <a href="/promosi_detail" class="text-decoration-none">
                        <div class="promotion-content">
                            <img src="{{ asset('images/promo2.jpg') }}" alt="Pendaftaran Poliklinik" class="img-fluid">
                        </div>
                    </a>
                </div>
                <div class="col-md-4 promotion-item">
                    <a href="/promosi_detail" class="text-decoration-none">
                        <div class="promotion-content">
                            <img src="{{ asset('images/promo3.jpg') }}" alt="Home Service" class="img-fluid">
                        </div>
                    </a>
                </div>
            </div>
            


            <!-- Pagination Section -->
            <div class="pagination-container d-flex justify-content-end">
                <nav aria-label="promosi pagination">
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
            $("#searchpromosi").on("keyup", function() {
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
</body>

</html>
