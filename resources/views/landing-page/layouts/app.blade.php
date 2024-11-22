<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta
        name="description"
        content="Rumah Sakit Terbaik di Kalimantan Selatan, Ciputra Mitra Hospital Banjarmasin">
        
    <title>{{ $title }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logocrop.ico') }}" type="image/x-icon">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Local CSS -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    @stack('styles')
</head>

<body data-bs-spy="scroll" data-bs-target=".nav" data-bs-offset="50">
    <!-- Header -->
    <header>
        @include('landing-page.layouts.navbar')
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        @include('landing-page.layouts.footer')
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <!-- Custom Scripts -->
    @stack('scripts')
</body>

</html>