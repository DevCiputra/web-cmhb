

<?php $__env->startSection('title', 'Konsultasi Online'); ?>

<?php $__env->startSection('content'); ?>

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Konsultasi Online</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard-page')); ?>">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('reservation.onlineconsultation.index')); ?>">Reservasi</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Konsultasi Online</li>
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

        <!-- DataTable Card for Konsultasi Online -->
        <div class="card" style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <div class="card-form">
                <div class="d-flex mb-3">
                    <h4 style="color: #1C3A6B"><b>Data Reservasi Konsultasi Online</b></h4>
                </div>

                <!-- Filter Status -->
                <div class="mb-3">
                    <label for="filterStatus" class="form-label">Filter Status</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Admin">Menunggu Admin</option>
                        <option value="Konfirmasi Jadwal">Konfirmasi Jadwal</option>
                        <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                        <option value="Menunggu Konfirmasi Pembayaran">Menunggu Konfirmasi Pembayaran</option>
                        <option value="Menunggu Approval Admin">Menunggu Approval Admin</option>
                        <option value="Pemesanan Berhasil">Pemesanan Berhasil</option>
                        <option value="Pemesanan Dibatalkan">Pemesanan Dibatalkan</option>
                        <option value="Status Tidak Diketahui">Status Tidak Diketahui</option>
                    </select>
                </div>

                <!-- Datepicker for filtering -->
                <div class="mb-3">
                    <label for="filterPreferredDate" class="form-label">Filter Tanggal Konsultasi Diajukan</label>
                    <input type="text" id="filterPreferredDate" class="form-control datepicker" placeholder="Pilih Tanggal">
                </div>
                <div class="mb-3">
                    <label for="filterAgreedDate" class="form-label">Filter Tanggal Konsultasi Disepakati</label>
                    <input type="text" id="filterAgreedDate" class="form-control datepicker" placeholder="Pilih Tanggal">
                </div>

                <!-- Description -->
                <div class="d-flex mb-4">
                    <p class="card-text">Berikut merupakan tabel data Konsultasi Online.</p>
                </div>

                <!-- Data Table -->
                <div style="max-height: 550px; overflow-y: auto; width: 100%;">
                    <table class="table table-bordered" id="dataTableKonsultasi" style="width: 100%; border-top: 1px solid grey;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Order ID</th>
                                <th>Nama Pasien</th>
                                <th>No. Hp</th>
                                <th>Nama Dokter</th>
                                <th>Spesialis</th>
                                <th>Waktu Konsul Diajukan</th>
                                <th>Waktu Konsul Disepakati</th>
                                <th>Bukti Pembayaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($reservation->code); ?></td>
                                <td><?php echo e($reservation->patient->name); ?></td>
                                <td><?php echo e($reservation->patient->user->whatsapp); ?></td>
                                <td><?php echo e($reservation->doctorConsultationReservation->doctor->name); ?></td>
                                <td><?php echo e($reservation->doctorConsultationReservation->doctor->specialization_name); ?></td>
                                <td><?php echo e($reservation->doctorConsultationReservation->preferred_consultation_date); ?></td>
                                <td><?php echo e($reservation->doctorConsultationReservation->agreed_consultation_date); ?></td>
                                <td>
                                    <?php if($reservation->paymentRecords->isNotEmpty() && $reservation->paymentRecords->last()->payment_proof): ?>
                                    <a href="<?php echo e(asset('storage/' . $reservation->paymentRecords->last()->payment_proof)); ?>" target="_blank">Lihat Bukti Pembayaran</a>
                                    <?php else: ?>
                                    N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge badge
                                    <?php if(is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran)): ?>
                                    badge-secondary
                                    <?php elseif($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran)): ?>
                                    badge-warning
                                    <?php elseif($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran)): ?>
                                    badge-info
                                    <?php elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi'): ?>
                                    badge-warning
                                    <?php elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas'): ?>
                                    badge-info
                                    <?php elseif($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas'): ?>
                                    badge-success
                                    <?php elseif($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan'): ?>
                                    badge-danger
                                    <?php else: ?>
                                    badge-light
                                    <?php endif; ?>"
                                        style="color: white;
                                    <?php if(is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran)): ?>
                                    background-color: #6c757d; /* Secondary color */
                                    <?php elseif($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran)): ?>
                                    background-color: #FFC107; /* Warning color */
                                    <?php elseif($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran)): ?>
                                    background-color: #17a2b8; /* Info color */
                                    <?php elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi'): ?>
                                    background-color: #FFC107; /* Warning color */
                                    <?php elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas'): ?>
                                    background-color: #17a2b8; /* Info color */
                                    <?php elseif($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas'): ?>
                                    background-color: #28A745; /* Success color */
                                    <?php elseif($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan'): ?>
                                    background-color: #dc3545; /* Danger color */
                                    <?php else: ?>
                                    background-color: #F8F9FA; /* Light color */
                                    <?php endif; ?>">
                                        
                                        <?php if(is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran)): ?>
                                        Menunggu Admin
                                        <?php elseif($reservation->reservation_status_id == 1 && is_null($reservation->status_pembayaran)): ?>
                                        Konfirmasi Jadwal
                                        <?php elseif($reservation->reservation_status_id == 2 && is_null($reservation->status_pembayaran)): ?>
                                        Menunggu Pembayaran
                                        <?php elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Menunggu Konfirmasi'): ?>
                                        Menunggu Konfirmasi Pembayaran
                                        <?php elseif($reservation->reservation_status_id == 2 && $reservation->status_pembayaran == 'Lunas'): ?>
                                        Menunggu Approval Admin
                                        <?php elseif($reservation->reservation_status_id == 3 && $reservation->status_pembayaran == 'Lunas'): ?>
                                        Pemesanan Berhasil
                                        <?php elseif($reservation->reservation_status_id == 4 && $reservation->status_pembayaran == 'Dikembalikan'): ?>
                                        Pemesanan Dibatalkan
                                        <?php else: ?>
                                        Status Tidak Diketahui
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('reservation.onlineconsultation.detail', $reservation->id)); ?>" class="btn btn-info btn-sm">Detail</a>
                                    <!-- Tambahkan action button lain sesuai kebutuhan -->
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

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    const mobileScreen = window.matchMedia("(max-width: 990px )");

    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this).closest(".dashboard-nav-dropdown").toggleClass("show").find(".dashboard-nav-dropdown").removeClass("show");
            $(this).parent().siblings().removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (mobileScreen.matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
        // Initialize the datepicker
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd" // Format to match your database date format
        });

        // Initialize DataTable
        var table = $('#dataTableKonsultasi').DataTable();

        // Filter by status
        $('#filterStatus').on('change', function() {
            var statusValue = $(this).val();
            table.column(9).search(statusValue).draw();
        });

        // Filter by preferred consultation date
        $('#filterPreferredDate').on('change', function() {
            var dateValue = $(this).val();
            // Apply filter
            table.column(6).search(dateValue).draw();
        });

        // Filter by agreed consultation date
        $('#filterAgreedDate').on('change', function() {
            var dateValue = $(this).val();
            // Apply filter
            table.column(7).search(dateValue).draw();
        });

        // Auto refresh the page every 5 minutes (300000 ms)
        setInterval(function() {
            location.reload();
        }, 300000); // 300000ms = 5 minutes
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('management-data.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/management-data/reservation/online-consultation/index.blade.php ENDPATH**/ ?>