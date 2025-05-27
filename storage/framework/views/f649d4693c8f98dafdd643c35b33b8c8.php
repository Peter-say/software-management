<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Outlet</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(isset($outlet) ? 'Update Outlet' : 'Create Outlet'); ?></h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?php echo e(isset($outlet) ? route('dashboard.hotel.outlets.update', $outlet->id) : route('dashboard.hotel.outlets.store')); ?>"
                            enctype="multipart/form-data" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php if(isset($outlet)): ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="outlet_id" value="<?php echo e($outlet->id); ?>">
                            <?php endif; ?>
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="outlet_name" class="text-label form-label">Outlet Name*</label>
                                        <select id="outlet_name" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="">Select Outlet Name</option>
                                            <?php $__currentLoopData = $outlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($outlet); ?>" <?php echo e(old('name') == $outlet ? 'selected' : ''); ?>>
                                                    <?php echo e($outlet); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <option value="other">Other</option>
                                        </select>
                                        
                                        <input type="text" id="custom_outlet_name" name="name_custom" 
                                            class="form-control mt-2 <?php $__errorArgs = ['name_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            placeholder="Enter custom outlet name" 
                                            value="<?php echo e(old('name_custom')); ?>" 
                                            style="display: none;" />
                                            
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php $__errorArgs = ['name_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
            
                                <div class="col-lg-8 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="outlet-type" class="text-label form-label">Type*</label>
                                        <select id="type" name="type" class="form-control <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="" disabled>Select Type</option>
                                            <?php $__currentLoopData = $outlet_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type); ?>" <?php echo e(old('type') == $type ? 'selected' : ''); ?>>
                                                    <?php echo e($type); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary"><?php echo e(isset($outlet) ? 'Update' : 'Submit'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
            
            <script>
                document.getElementById('outlet_name').addEventListener('change', function () {
                    var customOutletField = document.getElementById('custom_outlet_name');
                    if (this.value === 'other') {
                        customOutletField.style.display = 'block';
                        customOutletField.value = ''; // Clear custom outlet field if "Other" is selected
                    } else {
                        customOutletField.style.display = 'none';
                        customOutletField.value = ''; // Reset custom input
                    }
                });
            
                // Handle form submission
                document.querySelector('form').addEventListener('submit', function (e) {
                    var outletNameField = document.getElementById('outlet_name');
                    var customOutletField = document.getElementById('custom_outlet_name');
                    
                    // Check if "Other" is selected and the custom outlet field is visible
                    if (outletNameField.value === 'other' && customOutletField.style.display === 'block') {
                        outletNameField.name = 'name_custom'; // Change the name to send custom name
                    } else {
                        outletNameField.name = 'name'; // Keep the selected outlet name
                    }
                });
            </script>
            
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/outlet/create.blade.php ENDPATH**/ ?>