<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skrining Depresi</title>
    <link rel="stylesheet" href="{{ asset('css/skrining.css') }}">
</head>
<body>
    <div class="container">
        <h1>Skrining Depresi</h1>
        <form action="/submit_skrining" method="post">
            <!-- Contoh pertanyaan yang diambil dari database -->
            <div class="question">
                <label>1. Apakah Anda merasa sedih atau kehilangan minat dalam aktivitas sehari-hari?</label>
                <div class="options">
                    <label><input type="radio" name="q1" value="1"> Tidak pernah</label>
                    <label><input type="radio" name="q1" value="2"> Jarang</label>
                    <label><input type="radio" name="q1" value="3"> Kadang-kadang</label>
                    <label><input type="radio" name="q1" value="4"> Sering</label>
                    <label><input type="radio" name="q1" value="5"> Selalu</label>
                </div>
            </div>
            
            <!-- Duplikat div.question untuk setiap pertanyaan yang disimpan di database -->
            <!-- Pertanyaan ke-2, ke-3, dst. dengan `name="q2"`, `name="q3"` dan seterusnya -->
            
            <button type="submit" class="submit-button">Kirim Jawaban</button>
        </form>
    </div>
</body>
</html>


@extends('landing-page.layouts.app')
@section('content')

<body>
    <div class="coming-soon-section">
        <div class="coming-soon-content">
            <h1>We Are Coming Soon !</h1>
            <p>Our website is under construction, and we are working hard to give you a great experience. Stay tuned !</p><a href="{{ url('/') }}" class="btn btn-custom">Back to Home</a>
        </div>
    </div>
</body>
@endsection

@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@push('styles')

@endpush