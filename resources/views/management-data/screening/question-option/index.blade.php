@extends('management-data.layouts.app')

@section('title', 'Daftar Opsi Skrining ')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Daftar Opsi Skrining</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('screening-depretion.index') }}">Daftar Soal Skrining</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Daftar Opsi Soal</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('screening-depretion.screening-options.create', $question->id) }}" class="btn btn-md btn-success">Tambah Opsi</a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <h5 class="mb-4 fw-normal" style="color: #1C3A6B;">Daftar Opsi untuk Soal: {{ $question->question_text }}</h5>

                <div class="row row-cols-1 g-4">
                    @if($options->isEmpty())
                    <p class="text-muted">Belum ada opsi untuk soal ini.</p>
                    @else
                    @foreach($options as $option)
                    <div class="col">
                        <div class="card" style="border-radius: 8px; box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title" style="color: #1C3A6B;">{{ $option->option_text }}</h6>
                                    <p class="mb-1 text-muted">Bobot: {{ $option->weight }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('screening-depretion.screening-options.edit', ['question' => $question->id, 'option' => $option->id]) }}" 
                                       class="btn btn-sm btn-warning" 
                                       style="border-radius: 8px; padding: 6px 12px; font-size: 14px; display: flex; align-items: center; justify-content: center; height: 38px;">
                                        Edit
                                    </a>
                                    <form action="{{ route('screening-depretion.screening-options.destroy', ['question' => $question->id, 'option' => $option->id]) }}" 
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                style="border-radius: 8px; padding: 6px 12px; font-size: 14px; display: flex; align-items: center; justify-content: center; height: 38px;" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus opsi ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            
            <!-- </div> -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeletion(event) {
        event.preventDefault();
        const confirmed = confirm("Apakah Anda yakin ingin menghapus opsi ini?");
        if (confirmed) {
            event.target.submit();
        }
    }
</script>

<script>
    const mobileScreen = window.matchMedia("(max-width: 990px )");
    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this).closest(".dashboard-nav-dropdown")
                .toggleClass("show")
                .find(".dashboard-nav-dropdown")
                .removeClass("show");
            $(this).parent()
                .siblings()
                .removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (mobileScreen.matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });
</script>
@endpush