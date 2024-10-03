@extends('landing-page.layouts.app')

@section('content')
<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif; /* Menggunakan font Poppins */
        background: #f5f7fa;
    }
    .coming-soon-section {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(to right, #023770, #E3EFFF); /* Gradient Background */
        color: #ffffff;
        text-align: center;
    }
    .coming-soon-content {
        background: rgba(0, 0, 0, 0.3); /* Transparansi untuk konten */
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3); /* Shadow untuk tampilan */
    }
    h1 {
        font-size: 3rem;
        margin-bottom: 20px;
        letter-spacing: 2px; /* Spasi antar huruf */
    }
    p {
        font-size: 1.2rem;
        margin-bottom: 30px;
    }
    .btn-custom {
        background-color: #2a8f74; /* Warna tombol custom */
        border: none;
        color: #ffffff;
        padding: 12px 30px;
        font-size: 1rem;
        border-radius: 30px; /* Tombol melengkung */
        transition: all 0.3s ease-in-out;
    }
    .btn-custom:hover {
        background-color: #00503b; /* Warna tombol saat hover */
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2); /* Shadow saat hover */
        transform: translateY(-3px); /* Efek hover */
    }
</style>
</head>
<body>
<div class="coming-soon-section">
    <div class="coming-soon-content">
        <h1>We Are Coming Soon!</h1>
        <p>Our website is under construction, and we are working hard to give you a great experience. Stay tuned!</p>
        <a href="{{ url('/') }}" class="btn btn-custom">Back to Home</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection

