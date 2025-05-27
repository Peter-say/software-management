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
                        <h4 class="card-title">Hotel Users</h4>
                        <a href="<?php echo e(route('dashboard.hotel-users.create')); ?>" class="btn btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Gender</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Joining Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $hotel_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <?php if($hotel_user->photo): ?>
                                                <td><img class="" width="35"
                                                        src="<?php echo e(getStorageUrl('hotel/users/photos/' . $hotel_user->photo)); ?>"
                                                        alt="photo"></td>
                                            <?php else: ?>
                                                <td><img class="" width="35"
                                                        src="<?php echo e(asset('dashboard/images/profile/small/pic1.jpg')); ?>"
                                                        alt="photo"></td>
                                            <?php endif; ?>
                                            <td><?php echo e($hotel_user->user->name); ?></td>
                                            <td><?php echo e($hotel_user->role); ?></td>
                                            <td><?php echo e($hotel_user->gender ?? 'N/A'); ?></td>
                                            <td><a
                                                    href="javascript:void(0);"><strong><?php echo e($hotel_user->phone ?? 'N/A'); ?></strong></a>
                                            </td>
                                            <td><a
                                                    href="javascript:void(0);"><strong><?php echo e($hotel_user->user->email); ?></strong></a>
                                            </td>
                                            <td><?php echo e($hotel_user->created_at->format('D M, Y')); ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="<?php echo e(route('dashboard.hotel-users.edit', $hotel_user->id)); ?>" class="btn btn-primary shadow btn-xs sharp me-1">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" onclick="confirmDelete('<?php echo e(route('dashboard.hotel-users.delete', $hotel_user->id)); ?>')">
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
                    Are you sure you want to delete this user?
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

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/users/index.blade.php ENDPATH**/ ?>