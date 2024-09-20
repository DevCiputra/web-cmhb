@extends('management-data.layouts.app')

@section('title', 'Medical Check Up')

@section('content')
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Medical Check Up</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Reservasi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Medical Check Up</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('reservation.mcu.index') }}" method="GET" class="d-flex">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari data" style="max-width: 200px;" value="{{ request()->input('keyword') }}">
                        <button type="submit" class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Cari
                        </button>
                    </form>
                    <a href="{{ route('reservation.mcu.create') }}">
                        <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                            Tambah
                        </button>
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row cards-container">
            @foreach($services as $service)
            <div class="col-md-3 mb-4">
                <div class="card">
                    @php
                    $media = $service->medias->first();
                    @endphp

                    <img class="card-img-top" src="{{ $media ? Storage::url('service_photos/mcu/' . $media->name) : asset('images/default.jpg') }}" alt="Service Image"
                        style="width: 100%; height: 200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="title">{{ $service->title }}</h5>
                        <b class="price">Rp. {{ number_format($service->price, 0, ',', '.') }}</b>
                        <p class="description">{!! $service->description !!}</p>
                        <p class="description">{!! $service->special_information !!}</p>

                        <p class="text-muted mb-2">
                            Dibuat: {{ $service->created_at->format('d M Y H:i') }} <br>
                            Diedit: {{ $service->updated_at->format('d M Y H:i') }} <br>
                            Status:
                            @if($service->is_published)
                            <span class="text-success">Dipublikasikan</span>
                            @else
                            <span class="text-danger">Belum Dipublikasikan</span>
                            @endif
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            @if($service->deleted_at)
                            <span class="text-muted">Deleted</span>
                            <form action="{{ route('reservation.mcu.restore', $service->id) }}" method="POST" style="display:inline;" onsubmit="return confirmRestore();">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="page" value="{{ $services->currentPage() }}">
                                <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                            </form>
                            <a href="{{ route('reservation.mcu.detail', $service->id) }}" class="btn btn-info btn-sm">View Details</a>
                            @else
                            <div class="icon-group">
                                <a href="{{ route('reservation.mcu.edit', ['service' => $service->id, 'page' => request()->input('page', 1)]) }}" class="btn btn-edit btn-sm">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Pencil Square" class="pencil-icon">
                                </a>
                            </div>
                            @if(!$service->is_published)
                            <form action="{{ route('reservation.mcu.publish', $service->id) }}" method="POST" style="display:inline;" onsubmit="return confirmPublish();">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="page" value="{{ $services->currentPage() }}">
                                <button type="submit" class="btn btn-success btn-sm">Publish</button>
                            </form>
                            @else
                            <form action="{{ route('reservation.mcu.unpublish', $service->id) }}" method="POST" style="display:inline;" onsubmit="return confirmUnpublish();">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="page" value="{{ $services->currentPage() }}">
                                <button type="submit" class="btn btn-secondary btn-sm">Unpublish</button>
                            </form>
                            @endif
                            <form action="{{ route('reservation.mcu.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="page" value="{{ $services->currentPage() }}">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <a href="{{ route('reservation.mcu.detail', $service->id) }}" class="btn btn-info btn-sm">View Details</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const mobileScreen = window.matchMedia("(max-width: 990px )");

    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this).closest(".dashboard-nav-dropdown").toggleClass("show").find(".dashboard-nav-dropdown").removeClass("show");
            $(this).parent().siblings().removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (mobileScreen.matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });

    function confirmPublish() {
        return confirm('Are you sure you want to publish this service?');
    }

    function confirmRestore() {
        return confirm('Are you sure you want to restore this service?');
    }

    function confirmUnpublish() {
        return confirm('Are you sure you want to unpublish this service?');
    }
</script>
@endpush