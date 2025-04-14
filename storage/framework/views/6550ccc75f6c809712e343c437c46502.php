  <!-- Modal to display items for the order -->
  <div class="modal fade" id="orderItemsModal<?php echo e($kitchen->restaurantOrder->id); ?>" tabindex="-1" aria-labelledby="orderItemsModalLabel<?php echo e($kitchen->restaurantOrder->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderItemsModalLabel<?php echo e($kitchen->restaurantOrder->id); ?>">Order #<?php echo e($kitchen->restaurantOrder->id); ?> Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $kitchen->restaurantOrder->restaurantOrderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->restaurantItem->name); ?></td>
                                <td><?php echo e($item->qty); ?></td>
                                <td>$<?php echo e(number_format($item->amount, 2)); ?></td>
                                <td>$<?php echo e(number_format($item->discount_amount, 2)); ?> (<?php echo e($item->discount_type); ?>)</td>
                                <td>$<?php echo e(number_format($item->tax_amount, 2)); ?> (<?php echo e($item->tax_rate); ?>%)</td>
                                <td>$<?php echo e(number_format($item->total_amount, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <?php if($kitchen->restaurantOrder->notes): ?>
                <button class="btn-primary"> <i class="fas fa-question-circle text-white" 
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top" 
                    title="<?php echo e($kitchen->restaurantOrder->notes); ?>">Read notes</i></button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\kitchen\order-items.blade.php ENDPATH**/ ?>