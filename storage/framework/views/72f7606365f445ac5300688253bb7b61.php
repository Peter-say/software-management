   <!-- Modal Structure -->
   <div class="modal fade" id="viewNotesModal-<?php echo e($purchase_history->id); ?>" tabindex="-1" aria-labelledby="viewNotesModalLabel-<?php echo e($purchase_history->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNotesModalLabel">Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Notes Content -->
               <?php if($purchase_history->notes): ?>
               <p id="noteContent"><?php echo e($purchase_history->notes); ?></p>
               <?php else: ?>
                   <div class="d-flex justify-content-center">
                    <p>No notes</p>
                   </div>
               <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/guest/modal/note.blade.php ENDPATH**/ ?>