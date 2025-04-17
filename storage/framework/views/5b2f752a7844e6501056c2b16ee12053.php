

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
                    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card booking">
                            <div class="card-body">
                                <div class="booking-status d-flex align-items-center">
                                    <span>
                                        <!-- Example SVG Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28">
                                            <!-- SVG path omitted for brevity -->
                                            <path d="..." fill="var(--<?php echo e($card['class']); ?>)" />
                                        </svg>
                                    </span>
                                    <div class="ms-4">
                                        <h2 class="mb-0 font-w600"><?php echo e($card['value']); ?></h2>
                                        <p class="mb-0"><?php echo e($card['title']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\developer\index.blade.php ENDPATH**/ ?>