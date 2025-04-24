

<?php $__env->startSection('contents'); ?>
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Components</a></li>
            </ol>
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
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Hotel</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Joined Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="form-check style-1">
                                    <input class="form-check-input" type="checkbox"
                                        value="">
                                </div>
                            </td>
                            <td>
                                <a href="<?php echo e($user->photo); ?>"
                                    data-fancybox="gallery_<?php echo e($user->id); ?>"
                                    data-caption="<?php echo e($user->name); ?>">
                                    <img src="<?php echo e($user->photo); ?>"
                                        alt="Image" class="img-thumbnail"
                                        style="width: 60px; height: 60px;">
                                </a>
                            </td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><?php echo e($user->address ?? 'N/A'); ?></td>
                            <td><?php echo e($user->hotel ?? 'N/A'); ?></td>
                            <td><?php echo e($user->role); ?></td>
                            <td><?php echo e($user->phone ?? 'N/A'); ?></td>
                            <td><?php echo e(optional($user->created_at)->format('D M, Y') ?? 'N/A'); ?></td>

                            <td>
                                <div class="d-flex">
                                    <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" onclick="confirmDelete('<?php echo e(route('dashboard.hotel-users.delete', $user->id)); ?>')">
                                        <i class="fa fa-trash"></i>
                                    </a>
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
!-- Delete Confirmation Modal -->
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
<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\developer\users\index.blade.php ENDPATH**/ ?>