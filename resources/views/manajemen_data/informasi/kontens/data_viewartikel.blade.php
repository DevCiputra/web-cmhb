<head>
    <link href="{{ asset('css/informasi_detail.css') }}" rel="stylesheet">
</head>

@include('manajemen_data.layouts.dashboard')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; font-weight:">Detail Artikel</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Informasi</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard_artikel ">Artikel</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Artikel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="container info-detail" style="margin-top: 40px;">
                <div class="info-header">
                    <h1 class="info-title">Judul Artikel</h1>
                    <div class="info-meta">
                        <span class="category">Kategori Artikel</span>
                        <span class="publish-date">Tanggal Publish: 09 Agustus 2024</span>
                    </div>
                </div>
                
                <div class="info-content">
                    <img src="{{ asset('images/info1.png') }}" alt="info Image" class="info-image">
                    <p class="info-content"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel tellus vel justo malesuada efficitur ut eget augue. In ultrices pretium odio venenatis imperdiet. Nullam sed leo ut turpis congue efficitur. Mauris velit leo, ullamcorper et leo non, faucibus pretium eros. Mauris placerat elit posuere lacus dignissim auctor. Etiam condimentum, nisi eu pellentesque iaculis, lacus dui congue metus, ac imperdiet nulla tortor ac turpis. Ut eget velit mauris. In accumsan erat sit amet placerat tempus. Cras semper ligula orci, sed volutpat nisi ultrices ut.
    
                        Suspendisse dictum posuere ipsum vel faucibus. Nunc cursus consectetur nisl, maximus mattis neque feugiat ac. Proin tempus euismod quam, id feugiat purus laoreet nec. Praesent neque massa, efficitur eget posuere non, convallis sit amet ex. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc auctor urna sit amet risus sodales interdum. Curabitur fringilla nisl a nulla porttitor eleifend. Vivamus venenatis cursus enim in pharetra.
                        
                        Mauris vulputate feugiat hendrerit. Donec hendrerit porta lectus a fermentum. Proin sapien dui, tristique at velit a, egestas malesuada ante. Morbi lacinia, augue id interdum suscipit, est quam congue ipsum, at eleifend risus quam in nisi. Vivamus augue lacus, iaculis in pellentesque sit amet, sodales quis ipsum. Aenean imperdiet arcu neque, eget vehicula sem pretium ac. Pellentesque posuere lobortis nibh sed consequat. Nam porttitor laoreet metus ut euismod. In quis elementum nulla, ut porta justo. Praesent vestibulum id ligula in imperdiet. Suspendisse potenti. </p>
                </div>
            </div>
        </div>

       
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#deskripsiMCU').summernote({
            height: 400, // Set the height of the editor
            placeholder: 'Masukkan Deskripsi MCU',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
