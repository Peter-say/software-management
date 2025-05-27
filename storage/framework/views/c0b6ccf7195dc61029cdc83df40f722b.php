<div class="col-xl-6">
    <div class="card">
        <div class="card-header border-0 pb-0">
            <h4 class="fs-20">Recent Booking Schedule</h4>
        </div>
        <div class="card-body pb-2 loadmore-content" id="BookingContent">
            <div class="text-center event-calender border-bottom booking-calender">
                <input type='text' class="form-control d-none " id='datetimepicker1' />
            </div>

            <?php if(!$recent_room_reservations->count()): ?>
                <div class="d-flex justify-content-center aligh-item-center mt-5">
                    <h4>No recent booking available</h4>
                </div>
            <?php else: ?>
                <?php $__currentLoopData = $recent_room_reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rooms mt-3 d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center mb-3">
                            <a href="<?php echo e($recent->room->RoomImage()); ?>" data-fancybox="gallery_<?php echo e($recent->room->id); ?>"
                                data-caption="<?php echo e($recent->room->name); ?>">
                                <img class="me-3 rounded img-thumbnail" src="<?php echo e($recent->room->RoomImage()); ?>"
                                    alt="<?php echo e(basename($recent->room->RoomImage())); ?>">
                            </a>
                            <?php $__currentLoopData = $recent->room->RoomImages()->skip(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(asset('storage/' . $image->file_path)); ?>"
                                    data-fancybox="gallery_<?php echo e($recent->room->id); ?>"
                                    data-caption="<?php echo e($recent->room->name); ?>">
                                    <img class="me-3 rounded img-thumbnail"
                                        src="<?php echo e(asset('storage/' . $image->file_path)); ?>"
                                        alt="<?php echo e(basename($image->file_path)); ?>" style="display: none">
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="ms-4 bed-text">
                                <h4><?php echo e($recent->room->roomType->name . ' - ' . $recent->room->name); ?></h4>
                                <span><small>(<?php echo e('From: ' . $recent->calculateDaysLengthFrom() . ' To: ' . $recent->calculateDaysLengthTo()); ?>)</small></span>
                                <div class="users d-flex align-items-center">
                                    <?php if($recent->guest->id_picture_location): ?>
                                        <img src="<?php echo e(getStorageUrl('hotel/guests/id_picture_locations/' . $recent->guest->id_picture_location)); ?>"
                                            alt="<?php echo e($recent->guest->full_name); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo e(getStorageUrl('dashboard/images/users/user1.jpg')); ?>"
                                            alt="<?php echo e($recent->guest->full_name); ?>">
                                    <?php endif; ?>
                                    <div>
                                        <span
                                            class="fs-16 font-w500 me-3"><?php echo e(Str::limit($recent->guest->short_name, 15)); ?></span>
                                        <span><?php echo e($recent->created_at->diffForHumans()); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="date bg-sm bg-secondary"><?php echo e($recent->calculateNight()); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <div class="card-footer border-0 m-auto pt-0">
            <a href="javascript:void(0);" class="btn btn-link m-auto dlab-load-more fs-16 font-w500 text-secondary"
                id="load-more-btn" style="<?php echo e(count($recent_room_reservations) > 1 ? 'display: none;' : ''); ?>">
                View more
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $(document).ready(function() {
            let currentPage = 1;

            $('#load-more-btn').click(function() {
                currentPage++;
                $.ajax({
                    url: "<?php echo e(route('dashboard.load-more-recent-reservation')); ?>",
                    type: "GET",
                    data: {
                        page: currentPage
                    },
                    success: function(response) {
                        $('.loadmore-content').append(response.html);
                        if (!response.hasMore) {
                            $('#load-more-btn').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading more posts:', error);
                    }
                });
            });
        });
    });
</script>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/fragments/dashboard/recent-booking-schedule.blade.php ENDPATH**/ ?>