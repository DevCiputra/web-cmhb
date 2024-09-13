@extends('management-data.layouts.app')

@section('title', 'Beranda')

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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Beranda</h4>
                </div>

                <!-- buatkan saya tampilan data analytics di komponen dibawah ini -->


            </div>
        </div>

        <!-- Cards Container -->
        <div class="row cards-container">
            <div class="d-flex align-items-center gap-2">
                <!-- disini --><!-- Data Analytics Cards -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Card 1: Jumlah User -->
                    <div class="card" style="width: 12rem; background-color: #007858; color: black; text-align: center;">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah User</h5>
                            <h3 class="card-text">xxx</h3>
                        </div>
                    </div>

                    <!-- Card 2: Jumlah Transaksi -->
                    <div class="card" style="width: 12rem; background-color: #1C3A6B; color: black; text-align: center;">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Transaksi</h5>
                            <h3 class="card-text">xxx</h3>
                        </div>
                    </div>

                    <!-- Card 3: Total Pendapatan -->
                    <div class="card" style="width: 12rem; background-color: #023770; color: black; text-align: center;">
                        <div class="card-body">
                            <h5 class="card-title">Total Pendapatan</h5>
                            <h3 class="card-text">Rp. xxx</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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