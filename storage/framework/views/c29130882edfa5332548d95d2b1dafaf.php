<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.settings.')); ?>">Settings</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Hotel</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Module Preference</h5>
                        <div class="card-body d-flex justify-content-between">
                            Manage modules you want to enable for your hotel operations
                            <a href="<?php echo e(route('dashboard.hotel.module-preferences.edit', Auth::user()->hotel->uuid)); ?>" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Hotel Info</h5>
                        <div class="card-body d-flex justify-content-between">
                            Manage your hotel info here
                            <a href="" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Payment Platform</h5>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span>Set up your payment platform here if you would like to receive payments online / have not done so</span>
                            <a href="<?php echo e(route('dashboard.hotel.settings.hotel-info.choose-payment-platform')); ?>" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Edit Hotel Currency</h5>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span>Edit the currency you want for your hotel for transaction. This will be used for all transactions. By default, it is set to your country's currency</span>
                            <a href="<?php echo e(route('dashboard.hotel.settings.hotel-info.edit-currency')); ?>" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/settings/hotel/index.blade.php ENDPATH**/ ?>