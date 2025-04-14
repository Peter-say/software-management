<script>
    window.addEventListener('load', function() {
        <?php if($message = Session::get('success_message')): ?>
            Toastify({
                text: '<?php echo e($message); ?>',
                duration: 5000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
            }).showToast();
        <?php endif; ?>

        <?php if($message = Session::get('error_message')): ?>
            Toastify({
                text: '<?php echo e($message); ?>',
                duration: 5000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
            }).showToast();
        <?php endif; ?>

        <?php if($message = Session::get('warning_message')): ?>
            Toastify({
                text: '<?php echo e($message); ?>',
                duration: 5000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #f39c12, #f1c40f)',
            }).showToast();
        <?php endif; ?>
    });
</script>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\notifications\flash-messages.blade.php ENDPATH**/ ?>