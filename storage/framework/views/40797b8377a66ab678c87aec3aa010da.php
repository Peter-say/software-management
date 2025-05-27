
<!-- Modal for changing status -->
<div class="modal fade" id="changeStatusModal-<?php echo e($kitchen->id); ?>" tabindex="-1"
    aria-labelledby="changeStatusModalLabel-<?php echo e($kitchen->id); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel-<?php echo e($kitchen->id); ?>">
                    Change Order Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('dashboard.hotel.kitchen.orders.change-status', ['id' => $kitchen->id])); ?>"
                    method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group mb-3">
                        <label for="status">Select Status</label>
                        <select name="status" class="form-control">
                            <?php $__currentLoopData = getStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>"
                                    <?php echo e($kitchen->status == $status ? 'selected' : ''); ?>>
                                    <?php echo e($details['label']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/kitchen/modal/update-status.blade.php ENDPATH**/ ?>