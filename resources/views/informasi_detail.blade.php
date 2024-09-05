<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/informasi_detail.css') }}">
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
                    <li class="breadcrumb-item"><a href="">Informasi</a> </li>
                    <li class="breadcrumb-item active" style="color: #023770">Detail Artikel</li>
                </ol>
            </nav>
        </div>

        <!-- info Detail Section -->
        <div class="container info-detail" style="margin-top: 40px;">
            <div class="info-header">
                <h1 class="info-title">Judul Artikel</h1>
                <div class="info-meta">
                    <span class="category">Kategori Artikel</span>
                    <span class="publish-date">Tanggal Publish: 09 Agustus 2024</span>
                </div>
            </div>
            
            <div class="info-content">
                <img src="{{ asset('images/info1.png') }}" alt="info Image" class="info-image">
                <p class="info-content"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel tellus vel justo malesuada efficitur ut eget augue. In ultrices pretium odio venenatis imperdiet. Nullam sed leo ut turpis congue efficitur. Mauris velit leo, ullamcorper et leo non, faucibus pretium eros. Mauris placerat elit posuere lacus dignissim auctor. Etiam condimentum, nisi eu pellentesque iaculis, lacus dui congue metus, ac imperdiet nulla tortor ac turpis. Ut eget velit mauris. In accumsan erat sit amet placerat tempus. Cras semper ligula orci, sed volutpat nisi ultrices ut.

                    Suspendisse dictum posuere ipsum vel faucibus. Nunc cursus consectetur nisl, maximus mattis neque feugiat ac. Proin tempus euismod quam, id feugiat purus laoreet nec. Praesent neque massa, efficitur eget posuere non, convallis sit amet ex. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc auctor urna sit amet risus sodales interdum. Curabitur fringilla nisl a nulla porttitor eleifend. Vivamus venenatis cursus enim in pharetra.
                    
                    Mauris vulputate feugiat hendrerit. Donec hendrerit porta lectus a fermentum. Proin sapien dui, tristique at velit a, egestas malesuada ante. Morbi lacinia, augue id interdum suscipit, est quam congue ipsum, at eleifend risus quam in nisi. Vivamus augue lacus, iaculis in pellentesque sit amet, sodales quis ipsum. Aenean imperdiet arcu neque, eget vehicula sem pretium ac. Pellentesque posuere lobortis nibh sed consequat. Nam porttitor laoreet metus ut euismod. In quis elementum nulla, ut porta justo. Praesent vestibulum id ligula in imperdiet. Suspendisse potenti. </p>
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
    </div>
</body>

</html>
