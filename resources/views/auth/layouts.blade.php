<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/logocrop.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row w-100">
            <!-- Background Section (Gradient Background with Logo) -->
            <div class="col-12 col-lg-6 full-image-section">
                <div class="position-relative">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                    <div class="circle"></div>
                </div>
            </div>

            <!-- Content Section (Dynamic Section for Login or Register) -->
            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center auth-form-container">
                <div class="auth-form text-center">
                    <!-- Section Title and Sub-title -->
                    <h2>@yield('form-title')</h2>
                    <p>@yield('form-description')</p>
                    <!-- Main Form Content -->
                    @yield('form-content')
                </div>
            </div>
        </div>
    </div>
</body>

</html>