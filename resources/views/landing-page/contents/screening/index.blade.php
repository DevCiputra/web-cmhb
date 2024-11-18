@extends('landing-page.layouts.app')

@section('content')

<div class="container">

    <!-- Consent Modal -->
    <div class="modal fade" id="consentModal" tabindex="-1" aria-labelledby="consentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="consentModalLabel">Pemberitahuan Screening Psikologi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Dengan melanjutkan pengisian kuesioner ini, Anda setuju untuk mengikuti pemeriksaan depresi, kecemasan dan stres. Harap dicatat, dalam 1 minggu setelah mengisi kuesioner ini, disarankan untuk mencari informasi lebih lanjut kepada ahli terkait jika diperlukan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalBtn">Tutup</button>
                    <button type="button" class="btn btn-primary" id="proceedBtn">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb Section -->
    <div style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/account">Profil</a></li>
                <li class="breadcrumb-item"><a href="/screening">Screening Psikologi</a></li>
                <li class="breadcrumb-item active" style="color: #023770" aria-current="page">Isi Kuesioner</li>
            </ol>
        </nav>
    </div>

    <div style="margin-top: 80px;">
        <div class="header-section">
            <h1 class="h3">Screening Psikologi</h1>
            <p class="text-muted">Isi setiap pertanyaan dengan memilih jawaban yang sesuai.</p>
        </div>

        @if (auth()->check())
        <form id="screeningForm" action="{{ route('screening.submit') }}" method="POST">
            @csrf
            <div class="question-slide-container">
                @foreach ($questions as $index => $question)
                <div class="question-slide" style="display:{{ $index === 0 ? 'block' : 'none' }};">
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

                    <!-- Navigation Buttons -->
                    <div class="form-group text-end mt-2">
                        @if ($index > 0)
                        <button type="button" class="btn btn-secondary px-4 me-2" onclick="prevSlide()">Kembali</button>
                        @endif
                        @if ($index < count($questions) - 1)
                            <button type="button" class="btn btn-primary px-4" onclick="nextSlide({{ $question->id }})">Selanjutnya</button>
                            @else
                            <button type="submit" class="btn btn-primary px-5"
                                style="background-color: #007858; border-color: #007858; border-radius: 12px;">
                                Submit
                            </button>
                            @endif
                    </div>
                </div>
                @endforeach
            </div>
        </form>
    </div>

    <!-- Tautan ke Riwayat Skrining -->
    <div class="text-end mt-3 mb-3">
        <a href="{{ route('screening.history') }}" class="btn" style="border-radius: 10px; background-color: #023770; color:white">
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
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.question-slide');

    // Show the modal on page load
    window.onload = function() {
        const consentModal = new bootstrap.Modal(document.getElementById('consentModal'));
        consentModal.show();

        document.getElementById('proceedBtn').addEventListener('click', function() {
            consentModal.hide();
        });

        // Redirect to '/account' when 'Tutup' button is clicked
        document.getElementById('closeModalBtn').addEventListener('click', function() {
            window.location.href = "{{ route('account-index') }}";
        });
    };

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
        });
        currentSlide = index;
    }

    function nextSlide(questionId) {
        // Check if any answer is selected for the current question
        const selectedOption = document.querySelector(`input[name="answers[${questionId}]"]:checked`);
        if (selectedOption) {
            // If an option is selected, proceed to the next slide
            showSlide(currentSlide + 1);
        } else {
            // Show a warning if no answer is selected
            alert("Harap pilih jawaban terlebih dahulu sebelum melanjutkan.");
        }
    }

    function prevSlide() {
        if (currentSlide > 0) {
            showSlide(currentSlide - 1);
        }
    }
</script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/screening.css') }}">
<style>
    main {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        /* Mengatur tinggi minimum keseluruhan layar */
    }
</style>
@endpush