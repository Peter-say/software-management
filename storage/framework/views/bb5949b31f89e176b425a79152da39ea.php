

<?php $__env->startSection('contents'); ?>
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Components</a></li>
            </ol>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Hotels</h4>
                    <a href="" class="btn btn-primary">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th class="bg-none">
                                        <div class="form-check style-1">
                                            <input class="form-check-input" type="checkbox"
                                                value="" id="checkAll3">
                                        </div>
                                    </th>
                                    <th>Logo</th>
                                    <th>UUID</th>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>Joined Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="form-check style-1">
                                            <input class="form-check-input" type="checkbox"
                                                value="">
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?php echo e($hotel->hotelLogo()); ?>"
                                            data-fancybox="gallery_<?php echo e($hotel->id); ?>"
                                            data-caption="<?php echo e($hotel->name); ?>">
                                            <img src="<?php echo e($hotel->hotelLogo()); ?>"
                                                alt="Image" class="img-thumbnail"
                                                style="width: 60px; height: 60px;">
                                        </a>
                                    </td>
                                    <td><?php echo e($hotel->uuid); ?></td>
                                    <td><?php echo e($hotel->name); ?></td>
                                    <td><?php echo e($hotel->user->name); ?></td>
                                    <td><?php echo e($hotel->address ?? 'N/A'); ?></td>
                                    <td><?php echo e($hotel->phone ?? 'N/A'); ?></td>
                                    <td><?php echo e($hotel->country->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($hotel->state->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($hotel->created_at->format('D M, Y')); ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="<?php echo e(route('dashboard.hotels.show-hotel', $hotel->id)); ?>" class="btn btn-primary shadow btn-xs sharp me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('dashboard.hotel.settings.hotel-info.edit')); ?>" class="btn btn-primary shadow btn-xs sharp me-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" onclick="confirmDelete('<?php echo e(route('dashboard.hotels.delete-hotel', $hotel->id)); ?>')">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <!-- Login as Hotel Owner Button -->
                                            <a href="<?php echo e(route('dashboard.hotels.login-as-hotel-owner', $hotel->user->id)); ?>"
                                                class="btn btn-dark shadow btn-xs sharp" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Login as Hotel Owner"
                                                onclick="event.preventDefault(); document.getElementById('login-as-form-<?php echo e($hotel->id); ?>').submit();">
                                                <i class="fas fa-user-secret"></i>
                                            </a>

                                            <!-- Impersonation Form -->
                                            <form id="login-as-form-<?php echo e($hotel->id); ?>" method="POST"
                                                action="<?php echo e(route('dashboard.hotels.login-as-hotel-owner', $hotel->user->id)); ?>"
                                                style="display: none;">
                                                <?php echo csrf_field(); ?>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
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
                Are you sure you want to delete this hotel?
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
<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/developer/hotel/index.blade.php ENDPATH**/ ?>