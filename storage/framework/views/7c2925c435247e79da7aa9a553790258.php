

<?php $__env->startSection('title', 'Beranda'); ?>

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
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Beranda</h4>
                </div>

                <!-- buatkan saya tampilan data analytics di komponen dibawah ini -->


            </div>
        </div>

        <div class="row cards-container">
            <!-- Card: Jumlah User per Role -->
            <div class="card futuristik-card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah User</h5>
                    <?php $__currentLoopData = $userCountByRole; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h6><?php echo e(ucfirst($role)); ?>: <?php echo e($count); ?></h6>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Card: Jumlah Transaksi -->
            <div class="card futuristik-card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Transaksi</h5>
                    <h3 class="card-text"><?php echo e($completedTransactionsCount); ?></h3>
                </div>
            </div>

            <!-- Card: Total Pendapatan -->
            <div class="card futuristik-card">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <h3 class="card-text">Rp. <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h3>
                </div>
            </div>

            <!-- Card: Jumlah Dokter -->
            <div class="card futuristik-card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Dokter</h5>
                    <h3 class="card-text"><?php echo e($doctorCount); ?></h3>
                </div>
            </div>

            <!-- Card: Jumlah Poliklinik -->
            <div class="card futuristik-card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Poliklinik</h5>
                    <h3 class="card-text"><?php echo e($polyclinicCount); ?></h3>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: space-evenly;
        margin-top: 20px;
    }

    .futuristik-card {
        width: 15rem;
        background: linear-gradient(145deg, #e0eafc, #cfd6e6);
        /* Warna latar belakang lebih terang */
        border: none;
        color: #1C3A6B;
        /* Teks gelap */
        text-align: center;
        border-radius: 12px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .futuristik-card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
    }

    .futuristik-card .card-body {
        padding: 1.5rem;
    }

    .futuristik-card .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
        color: #1C3A6B;
        /* Teks judul dengan warna gelap */
    }

    .futuristik-card .card-text {
        font-size: 2rem;
        font-weight: bold;
        color: #1C3A6B;
        /* Teks utama berwarna gelap */
    }
</style>
<?php $__env->stopPush(); ?>

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
<?php echo $__env->make('management-data.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/management-data/dashboard/index.blade.php ENDPATH**/ ?>