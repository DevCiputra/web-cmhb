@extends('management-data.layouts.app')

@section('title', 'Informasi CMH')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <!-- Left Side: Text -->
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Informasi RS</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/master-info-cmh">Master Data</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Informasi RS</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Card Display -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="d-flex mb-3">
                    <h4 class="card-title" style="color: #1C3A6B"><b>Data Informasi RS</b></h4>
                    <div class="ms-auto">
                        <a href="{{ route('information.data.create') }}" style="text-decoration: none;">
                            <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                                <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                                Tambah
                            </button>
                        </a>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <p class="card-text">Berikut merupakan data Informasi RS yang tersedia.</p>
                </div>
                <div class="row">
                    @foreach($hospitalInformations as $information)
                    <div class="col-md-4 mb-4">
                        <div class="card" style="box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                            @if($information->logo)
                            <img src="{{ asset('storage/' . $information->logo) }}" class="card-img-top" alt="{{ $information->name }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $information->name }}</h5>
                                <p class="card-text">
                                    <strong>Address:</strong> {{ $information->address }}<br>
                                    <strong>Phone:</strong> {{ $information->phone }}<br>
                                    <strong>Email:</strong> {{ $information->email }}<br>
                                    <strong>Vision:</strong> {{ $information->vision }}<br>
                                    <strong>Mission:</strong> {{ $information->mission }}<br>
                                    <strong>Emergency Contact:</strong> {{ $information->emergency_contact }}<br>
                                    <strong>Customer Service Contact:</strong> {{ $information->customer_service_contact }}
                                </p>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('information.data.edit', $information->id) }}" class="btn btn-primary btn-sm me-2">Edit</a>
                                    <form action="{{ route('information.data.destroy', $information->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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