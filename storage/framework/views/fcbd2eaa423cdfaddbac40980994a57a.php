<?php $__currentLoopData = $recent_room_reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="rooms mt-3 d-flex align-items-center justify-content-between flex-wrap">
        <div class="d-flex align-items-center mb-3">
            <a href="<?php echo e($recent->room->RoomImage()); ?>" data-fancybox="gallery_<?php echo e($recent->room->id); ?>"
                data-caption="<?php echo e($recent->room->name); ?>">
                <img class="me-3 rounded img-thumbnail" src="<?php echo e($recent->room->RoomImage()); ?>"
                    alt="<?php echo e(basename($recent->room->RoomImage())); ?>">
            </a>
            <?php $__currentLoopData = $recent->room->RoomImages()->skip(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(asset('storage/' . $image->file_path)); ?>" data-fancybox="gallery_<?php echo e($recent->room->id); ?>"
                    data-caption="<?php echo e($recent->room->name); ?>">
                    <img class="me-3 rounded img-thumbnail" src="<?php echo e(asset('storage/' . $image->file_path)); ?>"
                        alt="<?php echo e(basename($image->file_path)); ?>" style="display: none">
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="ms-4 bed-text">
                <h4><?php echo e($recent->room->roomType->name . ' ' . $recent->room->name); ?></h4>
                <span><small>(<?php echo e('From: ' . $recent->calculateDaysLengthFrom() . ' To: ' . $recent->calculateDaysLengthTo()); ?>)</small></span>
                <div class="users d-flex align-items-center">
                    <img src="images/users/user1.jpg" alt="">
                    <div>
                        <span class="fs-16 font-w500 me-3"><?php echo e(Str::limit($recent->guest->full_name, 15)); ?></span>
                        <span><?php echo e($recent->created_at->diffForHumans()); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <span class="date bg-sm bg-secondary mb-3"><?php echo e($recent->calculateNight()); ?></span>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\fragments\dashboard\load-more-booking-schedule.blade.php ENDPATH**/ ?>