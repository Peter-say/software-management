<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <!-- Page Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Order Items</a></li>
                </ol>
            </div>

            <!-- Action Bar -->
            <div class="container-fluid">
                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="card-action coin-tabs ">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <!-- Example for possible future tabs -->
                                
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <a href="<?php echo e(route('dashboard.hotel.bar-items.create')); ?>" class="btn btn-secondary me-2">+
                            New Item</a>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#upload-bar-items-modal"
                            class="btn btn-primary me-2">Upload Items</a>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#truncate-items-modal"
                            class="btn btn-primary me-2">Truncate Items <i class="fas fa-question-circle"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Delete all the bar items"></i></a>
                    </div>
                </div>

                <!-- Restaurant Items Table -->
                <div class="row ">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="AllRooms">
                                        <div class="table-responsive">
                                            <table class="table card-table display mb-4 shadow-hover table-responsive-lg"
                                                id="guestTable-all3">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-none">
                                                            <div class="form-check style-1">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="checkAll3">
                                                            </div>
                                                        </th>
                                                        <th>Item Name</th>
                                                        <th>Category</th>
                                                        <th>Image</th>
                                                        <th>Price</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th class="bg-none">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $bar_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check style-1">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="room-list-bx d-flex align-items-center">
                                                                    <div>
                                                                        <span
                                                                            class="fs-16 font-w500 text-nowrap"><?php echo e($item->name); ?></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap"><?php echo e($item->category ?? 'N/A'); ?></span>
                                                            </td>
                                                            <td>
                                                                <div class="room-list-bx d-flex align-items-center">
                                                                    <?php if($item->image): ?>
                                                                        <a href="<?php echo e($item->itemImage()); ?>"
                                                                            data-fancybox="gallery_<?php echo e($item->id); ?>"
                                                                            data-caption="<?php echo e($item->name); ?>">
                                                                            <img src="<?php echo e($item->itemImage()); ?>"
                                                                                alt="Image" class="img-thumbnail"
                                                                                style="width: 60px; height: 60px;">
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <?php echo e('N/A'); ?>

                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">₦<?php echo e(number_format($item->price)); ?></span>
                                                            </td>
                                                            <td>
                                                                <span class="fs-16 font-w500 text-nowrap">
                                                                    <button type="button" data-bs-toggle="modal"
                                                                        data-bs-target="#generalItemDescriptionModal"
                                                                        class="btn btn-primary btn-sm show-body"
                                                                        data-item-id="<?php echo e($item->id); ?>"
                                                                        data-item-content="<?php echo e($item->description); ?>">
                                                                        View
                                                                    </button>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap"><?php echo e(getItemAvailability($item->is_available)); ?></span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <!-- Edit Button -->
                                                                    <a href="<?php echo e(route('dashboard.hotel.bar-items.edit', $item->id)); ?>"
                                                                        class="btn btn-primary shadow btn-xs sharp me-1">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>

                                                                    <!-- Delete Button -->
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger shadow btn-xs sharp"
                                                                        onclick="confirmDelete('<?php echo e(route('dashboard.hotel.bar-items.destroy', $item->id)); ?>')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center">
                                            <?php echo e($bar_items->links()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this room?
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(url) {
            $('#deleteForm').attr('action', url);
            $('#deleteModal').modal('show');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/bar-items/index.blade.php ENDPATH**/ ?>