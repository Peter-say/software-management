<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Guests</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Guests</h4>
                        <a href="<?php echo e(route('dashboard.hotel.guests.create')); ?>" class="btn btn-primary">Add New Guest</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Title</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Other Names</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Other Phone</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Birthday</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $guests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <?php if($guest->id_picture_location): ?>
                                                <td><img class="" width="35"
                                                        src="<?php echo e(getStorageUrl('hotel/guests/id_picture_locations/' . $guest->id_picture_location)); ?>"
                                                        alt="ID Picture"></td>
                                            <?php else: ?>
                                                <td><img class="" width="35"
                                                        src="<?php echo e(asset('dashboard/images/profile/small/pic1.jpg')); ?>"
                                                        alt="ID Picture"></td>
                                            <?php endif; ?>
                                            <td><?php echo e($guest->title); ?></td>
                                            <td><?php echo e($guest->first_name); ?></td>
                                            <td><?php echo e($guest->last_name ?? 'N/A'); ?></td>
                                            <td><?php echo e($guest->other_names ?? 'N/A'); ?></td>
                                            <td><a href="mailto:<?php echo e($guest->email); ?>"><?php echo e($guest->email ?? 'N/A'); ?></a></td>
                                            <td><?php echo e($guest->phone_code); ?> <?php echo e($guest->phone ?? 'N/A'); ?></td>
                                            <td><?php echo e($guest->other_phone ?? 'N/A'); ?></td>
                                            <td><?php echo e($guest->state->name ?? 'N/A'); ?></td>
                                            <td><?php echo e($guest->country->name ?? 'N/A'); ?></td>
                                            <td><?php echo e($guest->birthday ? $guest->birthday->format('D M, Y') : 'N/A'); ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="<?php echo e(route('dashboard.hotel.guests.show', $guest->uuid)); ?>" class="btn btn-primary shadow btn-xs sharp me-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('dashboard.hotel.guests.edit', $guest->id)); ?>"
                                                        class="btn btn-primary shadow btn-xs sharp me-1">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp"
                                                        onclick="confirmDelete('<?php echo e(route('dashboard.hotel.guests.destroy', $guest->id)); ?>')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#fund-guest-wallet-modal" class="btn btn-primary shadow btn-xs sharp">
                                                        <i class="fas fa-wallet"></i>
                                                    </a>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                        <?php echo $__env->make('dashboard.hotel.guest.wallet.credit', ['guest' => $guest], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php echo $__env->make('dashboard.hotel.guest.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/guest/index.blade.php ENDPATH**/ ?>