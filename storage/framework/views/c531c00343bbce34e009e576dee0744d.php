

<?php $__env->startSection('title', 'Tambah Data Dokter'); ?>

<?php $__env->startSection('content'); ?>

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Tambah Data Dokter</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard-page')); ?>">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/doctor-data">Dokter</a></li>
                            <li class="breadcrumb-item" style="color: #023770">Tambah Data Dokter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>



        <!-- Form Card -->
        <div class="card"
            style="box-shadow: 4px 4px 24px 0px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px; overflow: hidden; height: auto">
            <div class="card-form" style="padding: 2rem;">
                <form action="<?php echo e(route('doctor.data.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Dokter</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Masukkan Nama Dokter" required value="<?php echo e(old('name')); ?>">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="specialization_name" class="form-label">Spesialis</label>
                        <input type="text" class="form-control" id="specialization_name" name="specialization_name"
                            placeholder="Masukkan Spesialis" required value="<?php echo e(old('specialization_name')); ?>">
                        <?php $__errorArgs = ['specialization_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="doctor_polyclinic_id" class="form-label">Poliklinik</label>
                        <select class="form-select" id="doctor_polyclinic_id" name="doctor_polyclinic_id" required>
                            <option value="">Pilih Poliklinik</option>
                            <?php $__currentLoopData = $polyclinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $polyclinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($polyclinic->id); ?>"><?php echo e($polyclinic->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['doctor_polyclinic_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="education" class="form-label">Latar Belakang Pendidikan</label>
                        <textarea class="form-control" id="education" name="education" rows="4"
                            placeholder="Masukkan Latar Belakang Pendidikan" required><?php echo e(old('education')); ?></textarea>
                        <?php $__errorArgs = ['education'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Link Accuity</label>
                        <input type="url" class="form-control" id="address" name="address"
                            placeholder="Masukkan Link Accuity Dokter" required value="<?php echo e(old('address')); ?>">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Jadwal Praktek sebagai teks bebas menggunakan Trix Editor -->
                    <div class="mb-3">
                        <label for="doctor_schedule" class="form-label">Jadwal Praktek</label>
                        <input id="doctor_schedule" type="hidden" name="doctor_schedule" value="<?php echo e(old('doctor_schedule')); ?>">
                        <trix-editor input="doctor_schedule" placeholder="Masukkan jadwal praktek dokter secara bebas (contoh: Senin - Jumat, 09:00 - 17:00)"></trix-editor>
                        <?php $__errorArgs = ['doctor_schedule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="doctor_photos" class="form-label">Foto Dokter</label>
                        <input type="file" class="form-control" id="doctor_photos" name="doctor_photos"
                            accept="image/*">
                        <?php $__errorArgs = ['doctor_photos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="doctor_medias" class="form-label">Curriculum Vitae (Opsional)</label>
                        <input type="file" class="form-control" id="doctor_medias" name="doctor_medias"
                            accept=".pdf,.doc,.docx">
                        <?php $__errorArgs = ['doctor_medias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Input Consultation Fee -->
                    <div class="mb-3">
                        <label for="consultation_fee" class="form-label">Biaya Konsultasi (IDR)</label>
                        <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" placeholder="Masukkan Biaya Konsultasi" required value="<?php echo e(old('consultation_fee')); ?>">
                        <?php $__errorArgs = ['consultation_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="email" class="form-label">Email Dokter</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Dokter untuk keperluan Konsultasi Online" required value="<?php echo e(old('email')); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div> -->

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_open_consultation" name="is_open_consultation" value="1">
                        <label class="form-check-label" for="is_open_consultation">Buka Konsultasi</label>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_open_reservation" name="is_open_reservation" value="1">
                        <label class="form-check-label" for="is_open_reservation">Buka Reservasi</label>
                    </div>


                    <div class="d-flex justify-content-end">
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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

<script>
    document.getElementById('add-schedule').addEventListener('click', function() {
        const scheduleContainer = document.getElementById('schedule-container');
        const newScheduleRow = document.createElement('div');
        newScheduleRow.classList.add('schedule-row', 'mb-2');
        newScheduleRow.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label for="day" class="form-label">Hari</label>
                    <div class="input-group">
                        <select name="doctor_schedule[days][]" class="form-select" required>
                            <option value="">Pilih Hari</option>
                            <option value="Monday">Senin</option>
                            <option value="Tuesday">Selasa</option>
                            <option value="Wednesday">Rabu</option>
                            <option value="Thursday">Kamis</option>
                            <option value="Friday">Jumat</option>
                            <option value="Saturday">Sabtu</option>
                            <option value="Sunday">Minggu</option>
                        </select>
                        <button type="button" class="btn btn-danger remove-schedule">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="start_time" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control" name="doctor_schedule[start_time][]" required>
                </div>
                <div class="col-md-4">
                    <label for="end_time" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control" name="doctor_schedule[end_time][]" required>
                </div>
            </div>
        `;
        scheduleContainer.appendChild(newScheduleRow);
    });

    document.getElementById('schedule-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-schedule')) {
            const scheduleRow = e.target.closest('.schedule-row');
            if (scheduleRow) {
                scheduleRow.remove();
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('management-data.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/management-data/doctor/create.blade.php ENDPATH**/ ?>