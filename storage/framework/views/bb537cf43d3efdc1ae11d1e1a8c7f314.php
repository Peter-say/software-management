<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.notifications.view-all')); ?>">Notifications</a></li>
                    <li class="breadcrumb-item">Details</li>
                </ol>
            </div>

            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show">
                                        <!-- Notification Title -->
                                        <div class="d-flex justify-content-between p-3">
                                            <div class="d-flex flex-column">
                                                <h4 class="font-weight-bold"><?php echo e($notification->data['title']); ?></h4>
                                                <p class="text-muted">Notification ID: <?php echo e($notification->id); ?></p>
                                                <p class="mb-2"><?php echo e($notification->data['message']); ?></p>
                                                <p class="text-primary font-weight-bold">Status: <?php echo e($notification->data['status']); ?></p>
                                            </div>
                                        </div>

                                        <!-- Conditional Display based on Notification Type -->
                                        <?php if($notification->type === 'App\Notifications\KitchenOrderNotification'): ?>
                                            <!-- Kitchen Order Details -->
                                            <div class="p-3">
                                                <h5 class="font-weight-bold">Order Details:</h5>
                                                <p><strong>Order ID:</strong> <?php echo e($notification->data['order_id']); ?></p>
                                                <p><strong>Total Amount:</strong> $<?php echo e($notification->data['total_amount']); ?></p>
                                                <p><strong>Status:</strong> <?php echo e($notification->data['status']); ?></p>

                                                <h6 class="font-weight-bold">Items in the Order:</h6>
                                                <ul class="list-group">
                                                    <?php $__currentLoopData = $notification->data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="list-group-item">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <strong><?php echo e($item['name']); ?></strong>
                                                                </div>
                                                                <div class="text-muted">
                                                                    Quantity: <?php echo e($item['quantity']); ?>

                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        <?php elseif($notification->type === 'App\Notifications\StoreItemRequisitionNotification'): ?>
                                            <!-- Store Item Requisition Details -->
                                            <div class="p-3">
                                                <h5 class="font-weight-bold">Requisition Details:</h5>
                                                <p><strong>Requisition ID:</strong> <?php echo e($notification->data['requisition_id']); ?></p>
                                                <p><strong>Department:</strong> <?php echo e($notification->data['department']); ?></p>
                                                <p><strong>Purpose:</strong> <?php echo e($notification->data['purpose']); ?></p>
                                                <p><strong>Status:</strong> <?php echo e($notification->data['status']); ?></p>

                                                <h6 class="font-weight-bold">Items Requested:</h6>
                                                <ul class="list-group">
                                                    <?php $__currentLoopData = $notification->data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="list-group-item">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <strong><?php echo e($item['item_name']); ?></strong>
                                                                </div>
                                                                <div class="text-muted">
                                                                    Quantity: <?php echo e($item['quantity']); ?> <?php echo e($item['unit'] ?? ''); ?>

                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                            <?php elseif($notification->type === 'App\Notifications\BarOrderNotification'): ?>
                                            <!-- Store Item Requisition Details -->
                                            <div class="p-3">
                                                <h5 class="font-weight-bold">Order Details:</h5>
                                                <p><strong>Order ID:</strong> <?php echo e($notification->data['order_id']); ?></p>
                                                <p><strong>Total Amount:</strong> $<?php echo e($notification->data['total_amount']); ?></p>
                                                <p><strong>Status:</strong> <?php echo e($notification->data['status']); ?></p>

                                                <h6 class="font-weight-bold">Items in the Order:</h6>
                                                <ul class="list-group">
                                                    <?php $__currentLoopData = $notification->data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="list-group-item">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <strong><?php echo e($item['name']); ?></strong>
                                                                </div>
                                                                <div class="text-muted">
                                                                    Quantity: <?php echo e($item['quantity']); ?>

                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        <?php else: ?>
                                            <!-- Handle other notification types or show an error message -->
                                            <div class="alert alert-warning">Unknown notification type.</div>
                                        <?php endif; ?>

                                        <!-- Link to view more details -->
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/notification/single.blade.php ENDPATH**/ ?>