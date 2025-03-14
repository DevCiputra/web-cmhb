@extends('landing-page.layouts.app')

@section('content')
<!-- Breadcrumb Section -->

<div class="container" style="margin-top: 80px;  margin-bottom: 100px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-primary">Beranda</a></li>
                <li class="breadcrumb-item" style="color: #023770">Akses File MCU</li>
            </ol>
        </nav>
    </div>

    <div class="header-section text-center mt-4">
        <h1 class="text-primary">Akses File MCU Anda</h1>
        <p class="text-muted">Masukkan nama dan kode akses untuk melihat dan mengunduh file MCU Anda.</p>
    </div>

    <!-- Access Form Section -->
    <div class="access-form text-center shadow-sm p-4 rounded bg-white">
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama</label>
            <input type="text" id="name" class="form-control" placeholder="Masukkan nama Anda">
        </div>
        <div class="mb-3">
            <label for="access-code" class="form-label fw-semibold">Kode Akses</label>
            <input type="password" id="access-code" class="form-control" placeholder="Masukkan kode akses">
        </div>
        <button class="btn btn-primary w-100" onclick="accessMCU()">Akses File</button>
    </div>

    <div id="file-list" class="mt-4 text-center" style="display: none;">
        <h3 class="text-muted">File MCU Anda</h3>
        <ul id="file-links" class="list-group mt-3">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="#" class="text-decoration-none text-primary">MCU_Jayandra_11-03-2025.pdf</a>
                <div>
                    <span class="badge bg-success">Tersedia</span>
                    <button class="btn btn-sm btn-outline-primary ms-2">Unduh</button>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="#" class="text-decoration-none text-primary">Lab_Report_11-03-2025.pdf</a>
                <div>
                    <span class="badge bg-success">Tersedia</span>
                    <button class="btn btn-sm btn-outline-primary ms-2">Unduh</button>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="#" class="text-decoration-none text-primary">Xray_Result_11-03-2025.pdf</a>
                <div>
                    <span class="badge bg-success">Tersedia</span>
                    <button class="btn btn-sm btn-outline-primary ms-2">Unduh</button>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function accessMCU() {
        const name = document.getElementById('name').value.trim();
        const accessCode = document.getElementById('access-code').value.trim();
        
        if (!name || !accessCode) {
            alert('Harap masukkan nama dan kode akses yang valid.');
            return;
        }

        // Simulasi validasi akses
        if (name === "Jayandra Kevin" && accessCode === "123456") {
            document.getElementById('file-list').style.display = 'block';
        } else {
            alert('Nama atau kode akses tidak valid.');
        }
    }
</script>

<script src="{{ asset('js/navbar.js') }}"></script>

<script>
    function setImagePreview(imageUrl, title) {
        document.getElementById('imagePreview').src = imageUrl;
        document.getElementById('imagePreviewModalLabel').innerText = title;
    }

    function toggleEmergencyButtons() {
        const buttons = document.getElementById("emergency-buttons");
        buttons.classList.toggle("expand");

        if (buttons.style.maxHeight === "0px" || buttons.style.maxHeight === "") {
            buttons.style.maxHeight = "200px"; // Expand the sub-menu (adjust height as needed)
        } else {
            buttons.style.maxHeight = "0px"; // Collapse the sub-menu
        }
    }
</script>


@endpush

@push('styles')
<style>
    .access-form {
        max-width: 400px;
        margin: auto;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .form-control {
        border-radius: 8px;
    }
    
    .btn-primary {
        border-radius: 8px;
        font-weight: bold;
    }
    
    .breadcrumb {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .list-group-item a {
        font-weight: 500;
    }
    
    .btn-outline-primary {
        border-radius: 6px;
        font-weight: 500;
    }
</style>
@endpush
