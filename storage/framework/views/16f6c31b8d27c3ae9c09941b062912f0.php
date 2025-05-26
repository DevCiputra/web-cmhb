<?php $__env->startSection('title', 'Dokter'); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-app">
    <header class="dashboard-toolbar">
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>

    <div class="dashboard-content">
        <div class="card-header mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard-page')); ?>">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Dokter</li>
                        </ol>
                    </nav>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <!-- <select class="form-select" id="specializationFilter" style="width: 200px;">
                        <option selected>Pilih Spesialis</option>
                        <?php $__currentLoopData = $specializations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($specialization); ?>"><?php echo e($specialization); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select> -->

                    <form action="<?php echo e(route('doctor.data.index')); ?>" method="GET" class="d-flex">
                        <input type="text" class="form-control" name="query" placeholder="Cari Dokter"
                            style="max-width: 500px;" value="<?php echo e(request('query')); ?>">
                        <button type="submit" class="btn btn-md ms-2"
                            style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px;">
                            Cari
                        </button>
                    </form>
                    <a href="<?php echo e(route('doctor.data.create')); ?>" style="text-decoration: none;">
                        <button class="btn btn-md"
                            style="background-color: #007858; color: #fff; border-radius: 10px; padding: 8px 12px; border: none;">
                            <img src="<?php echo e(asset('icons/plus.svg')); ?>" width="16" height="16"
                                style="filter: invert(100%); margin-right: 8px;" alt="Plus Icon">
                            Tambah
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifikasi -->
        <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <div class="row cards-container">
            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top"
                        src="<?php echo e(asset('storage/doctor/photos/' . $doctor->id . '/' . ($doctor->photos->first()->name ?? 'dokter_placeholder.jpg'))); ?>"
                        alt="<?php echo e($doctor->name); ?>"
                        style="width: 100%; height: 200px; object-fit: cover; object-position: 50% 20%;">

                    <div class="card-body">
                        <div class="header-container d-flex justify-content-between">
                            <h5 class="title card-title"><?php echo e($doctor->name); ?></h5>
                            <div class="icon-group">
                                <a href="<?php echo e(route('doctor.data.edit', $doctor->id)); ?>" class="btn btn-edit">
                                    <img src="<?php echo e(asset('icons/pencil-square.svg')); ?>" alt="Edit" class="pencil-icon">
                                </a>
                                <a href="<?php echo e(route('doctor.data.show', $doctor->id)); ?>" class="btn btn-view">
                                    <img src="<?php echo e(asset('icons/eye-fill.svg')); ?>" alt="View" class="eye-icon">
                                </a>
                                <form action="<?php echo e(route('doctor.data.destroy', $doctor->id)); ?>" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-delete">
                                        <i class="fas fa-trash" style="color: red; font-size: 18px;"></i>
                                    </button>

                                </form>

                                <div>
                                                                    <!-- Tombol untuk mengubah status publikasi -->
                                <form action="<?php echo e(route('doctor.data.updatePublished', $doctor->id)); ?>" method="POST" style="display:inline-block;" id="publishForm">
                                    <?php echo csrf_field(); ?>
                                    <button type="button" class="btn btn-toggle-published" onclick="confirmPublish()"
                                        style="background-color: <?php echo e($doctor->is_published ? '#28a745' : '#dc3545'); ?>; color: white; border-radius: 5px; padding: 8px 12px; font-size: 14px;">
                                        <?php echo e($doctor->is_published ? 'Tampil' : 'Sembunyikan'); ?>

                                    </button>
                                </form>
                                </div>


                            </div>
                        </div>
                        <p class="specialist" style="color: #425b84"><?php echo e($doctor->specialization_name); ?></p>
                        <p class="polyclinic" style="color: #687c9c"> <?php echo e($doctor->polyclinic->name ?? 'N/A'); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php echo e($doctors->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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


<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .btn-toggle-published {
        transition: background-color 0.3s ease;
    }

    .btn-toggle-published:hover {
        opacity: 0.8;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('management-data.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/management-data/doctor/index.blade.php ENDPATH**/ ?>