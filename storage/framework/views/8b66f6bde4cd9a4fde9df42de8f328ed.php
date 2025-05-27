

<?php $__env->startSection('title', 'Data Patient'); ?>

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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Pasien</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard-page')); ?>">Beranda</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Data Pasien</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Display flash messages -->
        <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <!-- DataTable Card -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="d-flex mb-3">
                    <h4 class="card-title" style="color: #1C3A6B"><b>Data Pasien</b></h4>
                    <div class="ms-auto">
                        <a href="/" style="text-decoration: none;">

                        </a>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <p class="card-text">Berikut merupakan tabel data Pasien.</p>
                </div>
                <div style="max-height: 550px; overflow-y: auto; width: 100%;">
                    <table class="table table-bordered" id="dataTablePatient" style="width: 100%; border-top: 1px solid grey;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. Rekam Medis</th>
                                <th>User ID</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Created By</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($patient->id); ?></td>
                                <td><?php echo e($patient->name); ?></td>
                                <td><?php echo e($patient->address); ?></td>
                                <td><?php echo e($patient->medical_record_id); ?></td>
                                <td><?php echo e($patient->user_id); ?></td>
                                <td><?php echo e($patient->created_at); ?></td>
                                <td><?php echo e($patient->updated_at); ?></td>
                                <td><?php echo e($patient->created_by); ?></td>
                                <td>
                                    <a href="/" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="/" method="POST" style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-md" style="background-color: #dc3545; color: #fff; border-radius: 10px; display: flex; align-items: center; padding: 8px 12px; border: none;">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTablePatient').DataTable();
    });
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('management-data.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/management-data/patient/index.blade.php ENDPATH**/ ?>