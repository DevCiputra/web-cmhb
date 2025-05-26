

<?php $__env->startSection('title', 'Masuk'); ?>

<?php $__env->startSection('form-title', 'Masuk ke Akun Anda'); ?>
<?php $__env->startSection('form-description', 'Masukkan email dan kata sandi untuk masuk.'); ?>

<?php $__env->startSection('form-content'); ?>

<?php if(session('error')): ?>
<div class="alert alert-danger">
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?>
<?php if(session('success')): ?>
<div class="alert alert-success">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('login.post')); ?>">
    <?php echo csrf_field(); ?>
    <div class="mb-3 text-start">
        <label for="username" class="form-label">Username</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo e(old('username')); ?>" required>
        </div>
        <?php $__errorArgs = ['username'];
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
    <div class="mb-3 text-start">
        <label for="password" class="form-label">Kata Sandi</label>
        <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
            <input type="password" class="form-control" id="password" name="password" required>
            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                <i class="fa-solid fa-eye" id="eyeIcon"></i>
            </button>
        </div>
        <?php $__errorArgs = ['password'];
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
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Masuk</button>
    </div>
</form>

<div class="mt-3 text-center">
    <a href="<?php echo e(route('password.reset.request')); ?>" class="text-decoration-none">Lupa kata sandi?</a>
</div>

<div class="mt-3 text-center">
    <!-- Link ke halaman registrasi -->
    <p>Belum punya akun? <a href="<?php echo e(route('register')); ?>" class="text-decoration-none">Daftar di sini</a>.</p>
</div>
<?php $__env->stopSection(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {


        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute between 'password' and 'text'
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the eye icon
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Toggle Password Visibility for the confirmation field
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmation = document.querySelector('#password_confirmation');
        const eyeIconConfirm = document.querySelector('#eyeIconConfirm');

    });
</script>
<?php echo $__env->make('auth.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-cmhb\resources\views/auth/login.blade.php ENDPATH**/ ?>