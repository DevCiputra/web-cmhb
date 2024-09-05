@include('manajemen_data.layouts.dashboard')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <!-- Left Side: Text -->
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Artikel</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Informasi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Artikel</li>
                        </ol>
                    </nav>
                </div>

                <!-- Right Side: Controls -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Search Box -->
                    <input type="text" class="form-control" placeholder="Cari data" style="max-width: 200px;">

                    <!-- Dropdown Category -->
                    <select class="form-select">
                        <option selected>Pilih Kategori</option>
                        <option value="1">Kategori 1</option>
                        <option value="2">Kategori 2</option>
                    </select>

                    <!-- Add Button -->
                    <a href="/tambah_artikel" style="text-decoration: none;">
                        <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                            <img src="{{ asset('icons/plus.svg') }}" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                            Tambah
                        </button>
                    </a>                    
                </div>
            </div>
        </div>
        <!-- Cards Container -->
        <div class="row cards-container">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/info1.png') }}" alt="Artikel Image">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">Title</h5>
                            <div class="icon-group">
                                <a href="/edit_artikel" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Pencil Square"
                                        class="pencil-icon">
                                </a>
                                <a href="/view_artikel" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="Eye" class="eye-icon">
                                </a>
                            </div>
                        </div>
                        <p class="description">Some quick example text to build on the card.</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/info2.png') }}" alt="Artikel Image">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">Title</h5>
                            <div class="icon-group">
                                <a href="/edit_artikel" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Pencil Square"
                                        class="pencil-icon">
                                </a>
                                <a href="/view_artikel" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="Eye" class="eye-icon">
                                </a>
                            </div>
                        </div>
                        <p class="description">Some quick example text to build on the card.</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/info3.png') }}" alt="Artikel Image">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">Title</h5>
                            <div class="icon-group">
                                <a href="/edit_artikel" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Pencil Square"
                                        class="pencil-icon">
                                </a>
                                <a href="/view_artikel" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="Eye" class="eye-icon">
                                </a>
                            </div>
                        </div>
                        <p class="description">Some quick example text to build on the card.</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/info4.png') }}" alt="Artikel Image">
                    <div class="card-body">
                        <div class="header-container">
                            <h5 class="title">Title</h5>
                            <div class="icon-group">
                                <a href="/edit_artikel" class="btn btn-edit">
                                    <img src="{{ asset('icons/pencil-square.svg') }}" alt="Pencil Square"
                                        class="pencil-icon">
                                </a>
                                <a href="/view_artikel" class="btn btn-view">
                                    <img src="{{ asset('icons/eye.svg') }}" alt="Eye" class="eye-icon">
                                </a>
                            </div>
                        </div>
                        <p class="description">Some quick example text to build on the card.</p>
                        <a href="#" class="btn btn-action">
                            Publish
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

