

<?php $__env->startSection('title', 'Detail Dokter'); ?>

<?php $__env->startSection('content'); ?>
<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-normal" style="color: #023770; font-weight: bold;">Profil Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(route('dashboard-page')); ?>"
                                    style="text-decoration: none; color: #1C3A6B;">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/doctor-data" style="text-decoration: none; color: #1C3A6B;">Dokter</a>
                            </li>
                            <li class="breadcrumb-item" style="color: #023770;">Profil Dokter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto;">
            <div class="card-form" style="padding: 4rem;">
                <!-- Doctor Profile Section -->
                <div class="doctor-detail" style="text-align: center; margin-bottom: 2rem;">
                    <h1 class="doctor-name" style="font-size: 2rem; font-weight: bold; color: #023770;">
                        <?php echo e($doctor->name); ?>

                    </h1>
                    <h3 class="doctor-specialist" style="font-size: 1.5rem; color: #023770;">
                        <?php echo e($doctor->specialization_name); ?>

                    </h3>

                    <!-- Foto Dokter, dari photos -->
                    <div class="doctor-photo" style="margin-top: 2rem;">
                        <img src="<?php echo e(asset('storage/doctor/photos/' . $doctor->id . '/' . ($doctor->photos->first()->name ?? 'dokter_placeholder.jpg'))); ?>"
                            alt="Doctor Photo"
                            style="width: 200px; height: auto; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    </div>
                </div>

                <!-- Doctor Consultation Fee Section -->
                <div class="doctor-fee" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Consultation
                        Fee</h4>
                    <p style="font-size: 1.25rem; color: #444444;">
                        Rp<?php echo e(number_format($doctor->consultation_fee, 0, ',', '.')); ?>,-
                    </p>
                </div>

                <!-- Doctor Education Section -->
                <div class="doctor-education" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Riwayat
                        Pendidikan Dokter</h4>
                    <ul style="list-style-type: disc; padding-left: 1.5rem;">
                        <li class="education-item" style="font-size: 1rem; color: #444444;">
                            <?php echo e($doctor->education->name); ?>

                        </li>
                    </ul>
                </div>
                <!-- Doctor Schedule Section -->
                <div class="doctor-schedule" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Jadwal Praktek</h4>
                    <div style="font-size: 1rem; color: #444444;">
                        <?php if($doctor->schedules->isNotEmpty()): ?>
                        <?php $__currentLoopData = $doctor->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!-- Menampilkan jadwal sesuai dengan format JSON atau teks dari kolom schedule -->
                        <p><?php echo $schedule->schedule; ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <p>Jadwal praktek tidak tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CV Section, ambil dari medias -->
                <div class="doctor-cv" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">Curriculum
                        Vitae (CV)</h4>
                    <?php if($doctor->medias->isNotEmpty()): ?>
                    <a href="<?php echo e(asset('storage/doctor/medias/' . $doctor->id . '/' . $doctor->medias->first()->name)); ?>"
                        class="btn btn-primary" target="_blank"
                        style="background-color: #007BFF; color: #FFFFFF; border-radius: 8px; padding: 0.5rem 1rem; text-decoration: none;">Lihat
                        CV</a>
                    <?php else: ?>
                    <p style="font-size: 1rem; color: #444444;">Tidak ada CV tersedia.</p>
                    <?php endif; ?>
                </div>

                <!-- New Information Section: Additional Fields -->
                <div class="doctor-extra-info" style="margin-top: 2rem;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023770;">
                        Informasi Tambahan</h4>
                    <div class="extra-info">
                        <p style="font-size: 1rem; color: #444444;">
                            <strong>Publikasi:</strong>
                            <?php echo e($doctor->is_published == '1' ? 'Tersedia' : 'Tidak Tersedia'); ?>

                        </p>
                        <p style="font-size: 1rem; color: #444444;">
                            <strong>Konsultasi Dibuka:</strong>
                            <?php echo e($doctor->is_open_consultation == '1' ? 'Ya' : 'Tidak'); ?>

                        </p>
                        <p style="font-size: 1rem; color: #444444;">
                            <strong>Reservasi Dibuka:</strong>
                            <?php echo e($doctor->is_open_reservation == '1' ? 'Ya' : 'Tidak'); ?>

                        </p>
                    </div>
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
        $(".menu-toggle").click(function() {
            if (window.matchMedia("(max-width: 990px)").matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('management-data.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/management-data/doctor/detail.blade.php ENDPATH**/ ?>