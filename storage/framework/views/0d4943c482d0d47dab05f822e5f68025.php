<?php if(session()->has('success_message')): ?>
    <div id="popup-message" class="popup-message success">
        <div class="d-flex justify-content-around">
            <p class="text-white"><?php echo e(session('success_message')); ?></p>
            <span id="cancel-popup" wire:click="closePopup">X</span>
        </div>
    </div>
<?php endif; ?>

<?php if(session()->has('error_message')): ?>
    <div class="popup-message error " id="popup-message">
        <div class="d-flex justify-content-around">
            <p class="text-white"><?php echo e(session('error_message')); ?></p>
            <span id="cancel-popup" wire:click="closePopup">X</span>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/notifications/pop-up.blade.php ENDPATH**/ ?>