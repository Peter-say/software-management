<?php $__env->startSection('contents'); ?>
    <!--**********************************
                                               Content body start
                                              ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    <p class="fw-semibold fs-18 mb-0">Welcome back, <?php echo e(auth()->user()?->name); ?></p>
                </div>
               
            </div>
            <!-- End::page-header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/index.blade.php ENDPATH**/ ?>