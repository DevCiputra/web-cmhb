@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">

    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/account">Profile</a></li>
                <li class="breadcrumb-item"><a href="/account">Skrining Psikologi</a></li>
                <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Isi Kuesioner</li>
            </ol>
        </nav>
    </div>

    <div class="header-section">
        <div class="container-fluid">
            <h1 class="h3">Skrining Psikologi</h1>
            <p class="text-muted">Isi setiap pertanyaan dengan memilih jawaban yang sesuai.</p>
        </div>
    </div>

    @if (auth()->check())
    <form action="{{ route('screening.submit') }}" method="POST">
        @csrf
        @foreach ($questions as $question)
        <div class="form-group mb-4">
            <label class="form-label">{{ $question->question_text }}</label>
            @foreach ($question->options as $option)
            <div class="form-check">
                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                    id="option_{{ $option->id }}" value="{{ $option->id }}" required>
                <label class="form-check-label" for="option_{{ $option->id }}">
                    {{ $option->option_text }}
                </label>
            </div>
            @endforeach
        </div>
        @endforeach

        <div class="form-group text-end">
            <button type="submit" class="btn btn-primary px-5"
                style="height: 48px; background-color: #007858; border-color: #007858; border-radius: 12px;">
                Submit
            </button>
        </div>
    </form>

    <!-- Tautan ke Riwayat Skrining -->
    <div class="text-end mt-3">
        <a href="{{ route('screening.history') }}" class="btn btn-secondary" style="border-radius: 10px;">
            Lihat Riwayat Skrining
        </a>
    </div>

    @else
    <p class="text-danger">Anda wajib login untuk mengakses fitur ini.</p>
    @endif
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush