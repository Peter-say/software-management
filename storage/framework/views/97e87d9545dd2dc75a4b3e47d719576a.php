
<!-- Modal for adding note -->
<div class="modal fade" id="addKitchenNoteModal-<?php echo e($kitchen->id); ?>" tabindex="-1"
    aria-labelledby="addKitchenNoteModalLabel-<?php echo e($kitchen->id); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKitchenNoteLabel-<?php echo e($kitchen->id); ?>">
                    Add Note
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('dashboard.hotel.kitchen.orders.add-note', ['id' => $kitchen->id])); ?>"
                    method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="form-group mb-3">
                        <label for="notes">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes', $kitchen->notes)); ?></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\kitchen\modal\add-note.blade.php ENDPATH**/ ?>