@extends('landing-page.layouts.app')

@section('content')
<!-- Breadcrumb Section -->

<div class="container">
    <div style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/account">Profil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('screening.history') }}">Riwayat Screening</a></li>
                <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Hasil Screening</li>
            </ol>
        </nav>
    </div>

    <div style="margin-top: 80px;">
        <div class="header-section">
            <h1 class="h3" style="color: #023770;">Hasil Skrining Psikologi</h1>
            <p class="text-muted">Berikut adalah hasil dari skrining psikologi Anda.</p>
        </div>

        <!-- Ringkasan Hasil Kategori -->
        <div class="card mb-4" style="background-color: #f0f7ff;">
            <div class="card-header text-center" style="background-color: #023770; color: white;">
                <h4>Ringkasan Hasil Skrining</h4>
            </div>
            <div class="card-body text-center">
                <p><strong>Klasifikasi Total Distres: {{ $result['total_distress']['classification'] }}</strong></p>
                <p>Skor Total Distres: {{ $result['total_distress']['score'] }}</p>
            </div>
        </div>

        <!-- Detil Skor Kategori -->
        <div class="row">
            @foreach(['stress', 'anxiety', 'depression'] as $category)
            <div class="col-md-4">
                <div class="card mb-4" style="background-color: #f9fafe;">
                    <div class="card-header text-center" style="background-color: #023770; color: white;">
                        <h4>Klasifikasi {{ ucfirst($category) }}</h4>
                    </div>
                    <div class="card-body text-center">
                        <p>Skor: {{ $result[$category]['score'] }}</p>
                        <p>Klasifikasi: {{ $result[$category]['classification'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Saran berdasarkan hasil total_distress -->
        <div class="card mb-4 alert alert-info text-center">
            <p><strong>Saran:</strong> {{ $suggestion }}</p>
            @if(isset($onlineConsultationUrl))
            <p>
                <a href="{{ $onlineConsultationUrl }}" class="btn btn-primary" target="_blank">
                    Konsultasi Online Sekarang
                </a>
            </p>
            @endif
        </div>


        <!-- Tabel Ringkasan Jawaban -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #023770; color: white;">
                <h4>Ringkasan Jawaban</h4>
            </div>
            <div class="card-body" style="background-color: #f3f8ff;">
                <table class="table table-striped">
                    <thead style="background-color: #023770; color: white;">
                        <tr>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($answeredScreening->responses as $response)
                        <tr>
                            <td>{{ $response->question->question_text }}</td>
                            <td>{{ $response->option->option_text }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Button to View Screening History -->
        <div class="text-end mt-3 mb-3">
            <a href="{{ route('screening.history') }}" class="btn btn-secondary" style="border-radius: 10px; background-color: #023770; color: white;">
                Lihat Riwayat Skrining
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush