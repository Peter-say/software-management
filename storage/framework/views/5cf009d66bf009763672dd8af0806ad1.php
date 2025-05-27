<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Store Items</a></li>
                </ol>
            </div>
            <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0">All Store Items</h4>
                <a href="<?php echo e(route('dashboard.hotel.store-items.create')); ?>" class="btn btn-secondary">+ New Item</a>
            </div>
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table card-table display mb-4 shadow-hover table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Selling Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $store_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($sn++); ?></td>
                                                <td>
                                                    <a href="<?php echo e(getStorageUrl('hotel/store/items/files/'. $item->image)); ?>"
                                                        data-fancybox="gallery_<?php echo e($item->id); ?>"
                                                        data-caption="<?php echo e($item->name); ?>">
                                                        <img class="me-3 rounded img-thumbnail" class="img-fluid" width="60"
                                                            src="<?php echo e(getStorageUrl('hotel/store/items/files/'. $item->image)); ?>"
                                                            alt="<?php echo e(basename($item->image)); ?>">
                                                    </a>
                                                </td>
                                                <td><?php echo e($item->name); ?></td>
                                                <td><?php echo e($item->code); ?></td>
                                                <td><?php echo e($item->itemCategory->name ?? 'N/A'); ?></td>
                                                <td><?php echo e($item->itemSubCategory->name ?? 'N/A'); ?></td>
                                                <td><?php echo e($item->unit_measurement); ?></td>
                                                <td><?php echo e($item->qty); ?></td>
                                                <td><?php echo e(number_format($item->selling_price, 2)); ?></td>
                                                <td>
                                                    <div class="dropdown dropend">
                                                        <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M11 12C11 12.5523 11.4477 13 12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12Z" stroke="#262626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M18 12C18 12.5523 18.4477 13 19 13C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11C18.4477 11 18 11.4477 18 12Z" stroke="#262626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M4 12C4 12.5523 4.44772 13 5 13C5.55228 13 6 12.5523 6 12C6 11.4477 5.55228 11 5 11C4.44772 11 4 11.4477 4 12Z" stroke="#262626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?php echo e(route('dashboard.hotel.store-items.edit', $item->id)); ?>">Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmDelete('<?php echo e(route('dashboard.hotel.store-items.destroy', $item->id)); ?>')">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Showing <?php echo e($store_items->firstItem()); ?> to
                                    <?php echo e($store_items->lastItem()); ?> of <?php echo e($store_items->total()); ?>

                                    entries
                                </div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php echo e($store_items->links('pagination::bootstrap-4')); ?>

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
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

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/store-item/index.blade.php ENDPATH**/ ?>