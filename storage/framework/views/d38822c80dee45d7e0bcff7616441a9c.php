

<?php $__env->startSection('title', 'Galeri CMH'); ?>

<?php $__env->startSection('content'); ?>
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <!-- Left Side: Text -->
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B; ">Galeri RS</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard-page')); ?>">Beranda</a></li>
                            <li class="breadcrumb-item"><a href=" ">Master Data</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Galeri RS</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="<?php echo e(route('gallery.data.create')); ?>" style="text-decoration: none;">
                        <button class="btn btn-md" style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px; border: none;">
                            <img src="<?php echo e(asset('icons/plus.svg')); ?>" width="16" height="16" style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon"> Tambah
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- DataTable Card -->
        <!-- Data Galeri -->
        <div class="card" style="border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="row">
                    <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm" style="border-radius: 10px;">
                            <?php if($gallery->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $gallery->photo)); ?>" class="img-thumbnail gallery-img" alt="gallery image" class="card-img-top" style="border-radius: 10px 10px 0 0; object-fit: cover; height: 200px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-img="<?php echo e(asset('storage/' . $gallery->photo)); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo e($gallery->description); ?></h5>
                                <p class="card-text"><small class="text-muted">Diupload pada <?php echo e($gallery->created_at->format('d-m-Y')); ?></small></p>
                                <div class="d-flex ">
                                    <a href="<?php echo e(route('gallery.data.edit', $gallery->id)); ?>" class="btn btn-sm btn-success custom-btn me-2">Edit</a>
                                    <form action="<?php echo e(route('gallery.data.destroy', $gallery->id)); ?>" method="POST" style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger custom-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img id="modalImage" src="" alt="Full view" class="img-fluid" style="border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this).closest(".dashboard-nav-dropdown").toggleClass("show").find(".dashboard-nav-dropdown").removeClass("show");
            $(this).parent().siblings().removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (window.matchMedia("(max-width: 990px )").matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });
</script>

<script>
    // Event listener for image click
    $(document).on('click', '.gallery-img', function() {
        var imgSrc = $(this).data('img'); // Get image source from data attribute
        $('#modalImage').attr('src', imgSrc); // Set modal image source
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('management-data.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/management-data/master/gallery-cmh/index.blade.php ENDPATH**/ ?>