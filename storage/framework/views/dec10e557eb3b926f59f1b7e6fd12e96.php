<!-- Modal to display data for the order -->
<div class="modal fade" id="notificationModal<?php echo e($notification->id); ?>" tabindex="-1"
    aria-labelledby="notificationModalLabel<?php echo e($notification->id); ?>" aria-hidden="true">
   <div class="modal-dialog modal-lg">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="notificationModalLabel<?php echo e($notification->id); ?>">Order
                   #<?php echo e($notification->data['order_id']); ?> Details</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
               <p><strong>Title:</strong> <?php echo e($notification->data['title']); ?></p>
               <p><strong>Message:</strong> <?php echo e($notification->data['message']); ?></p>
               <p><strong>Total Amount:</strong> $<?php echo e(number_format($notification->data['total_amount'], 2)); ?></p>
               <p><strong>Status:</strong> <?php echo e($notification->data['status']); ?></p>

               <h5>Order Items</h5>
               <table class="table">
                   <thead>
                       <tr>
                           <th>Name</th>
                           <th>Quantity</th>
                           <th>Image</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php $__currentLoopData = $notification->data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                               <td><?php echo e($item['name']); ?></td>
                               <td><?php echo e($item['quantity']); ?></td>
                               <td>
                                <div class="item-image d-flex align-items-center">
                                    <?php if($item['image']): ?>
                                        
                                        <a href="<?php echo e(asset($item['image'])); ?>" data-fancybox="gallery_<?php echo e($item['name']); ?>" data-caption="<?php echo e($item['name']); ?>">
                                            <img src="<?php echo e(asset($item['image'])); ?>" alt="<?php echo e($item['name']); ?>" width="50" class="rounded img-thumbnail">
                                        </a>
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </div>
                            </td>
                            
                           </tr>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </tbody>
               </table>
           </div>
           <div class="modal-footer d-flex justify-content-between">
               <a href="<?php echo e($notification->data['link']); ?>" class="btn btn-primary" target="_blank">View Order</a>
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           </div>
       </div>
   </div>
</div>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/notification/order/details-modal.blade.php ENDPATH**/ ?>