@include('manajemen_data.layouts.dashboard')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Edit Informasi RS</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Master Data</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_infors">Informasi RS</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Edit Informasi RS</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-body" style="padding: 2rem;">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan Nama">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">URL</label>
                        <input type="text" class="form-control" id="address" placeholder="Masukkan URL">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Masukkan Phone Number">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Masukkan Email">
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Upload Logo</label>
                        <input type="file" class="form-control" id="logo" accept="image/*"
                            placeholder="Upload Foto Logo">
                    </div>
                    <div class="mb-3">
                        <label for="vision" class="form-label">Vision</label>
                        <input type="text" class="form-control" id="vision" placeholder="Masukkan Visi">
                    </div>
                    <div class="mb-3">
                        <label for="mission" class="form-label">Mission</label>
                        <input type="text" class="form-control" id="mission" placeholder="Masukkan Misi">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger me-2"
                            style="background-color: #DC3545; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Hapus
                        </button>
                        <button type="submit" class="btn btn-success"
                            style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

