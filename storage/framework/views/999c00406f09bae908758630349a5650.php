<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Hotel Setings</h5>
                        <div class="card-body d-flex justify-content-between">
                            Manage Hotel details here
                            <a href="<?php echo e(route('dashboard.hotel.settings.hotel-info.')); ?>" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Account Settings</h5>
                        <div class="card-body d-flex justify-content-between">
                            Manage your personal info here
                            <a href="" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/settings/index.blade.php ENDPATH**/ ?>