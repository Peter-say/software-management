<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.suppliers.index')); ?>">Supplier</a></li>
                    <li class="breadcrumb-item"><?php echo e(isset($supplier) ? 'Update supplier' : 'Create supplier'); ?></li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(isset($supplier) ? 'Update supplier' : 'Create supplier'); ?></h4>
                    </div>

                    <div class="card-body">
                        <form id="supplierForm"
                            action="<?php echo e(isset($supplier) ? route('dashboard.hotel.suppliers.update', $supplier->id) : route('dashboard.hotel.suppliers.store')); ?>"
                            method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if(isset($supplier)): ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="supplier_id" value="<?php echo e($supplier->id); ?>">
                            <?php endif; ?>

                            <div class="row">
                                <!-- supplier Details -->
                                <div class="col-lg-12">
                                    <h5>Supplier Details</h5>
                                    <div class="row">
                                       

                                        <!-- Name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Name*</label>
                                                <input type="text" id="name" name="name"
                                                    class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('name', $supplier->name ?? '')); ?>" required>
                                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- Last Name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="contact_person_name" class="form-label">Contact Person Name*</label>
                                                <input type="text" id="contact_person_name" name="contact_person_name"
                                                    class="form-control <?php $__errorArgs = ['contact_person_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('contact_person_name', $supplier->contact_person_name ?? '')); ?>" required>
                                                <?php $__errorArgs = ['contact_person_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- Other Names Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="contact_person_phone" class="form-label">Contact Person Phone *</label>
                                                <input type="text" id="contact_person_phone" name="contact_person_phone"
                                                    class="form-control <?php $__errorArgs = ['contact_person_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('contact_person_phone', $supplier->contact_person_phone ?? '')); ?>">
                                                <?php $__errorArgs = ['contact_person_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- bank_account_name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="bank_account_name" class="form-label">Bank Account Name</label>
                                                <input type="text" id="bank_account_name" name="bank_account_name"
                                                    class="form-control <?php $__errorArgs = ['bank_account_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('bank_account_name', isset($supplier) && $supplier->bank_account_name)); ?>"
                                                    required>
                                                <?php $__errorArgs = ['bank_account_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- bank_name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="bank_name" class="form-label">Bank Name*</label>
                                                <input type="bank_name" id="bank_name" name="bank_name"
                                                    class="form-control <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('bank_name', $supplier->bank_name ?? '')); ?>" required>
                                                <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- bank_account_no Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="bank_account_no" class="form-label">Bank Account No*</label>
                                                <input type="number" id="bank_account_no" name="bank_account_no"
                                                    class="form-control <?php $__errorArgs = ['bank_account_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('bank_account_no', $supplier->bank_account_no ?? '')); ?>" required>
                                                <?php $__errorArgs = ['bank_account_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- email Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="address" id="address" name="address"
                                                    class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('address', $supplier->address ?? '')); ?>">
                                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- email Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" id="email" name="email"
                                                    class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('email', $supplier->email ?? '')); ?>">
                                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                       
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary"><?php echo e(isset($supplier) ? 'Update Supplier' : 'Create Supplier'); ?></button>
                                <a href="<?php echo e(route('dashboard.hotel.suppliers.index')); ?>"
                                    class="btn btn-danger light ms-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/supplier/create.blade.php ENDPATH**/ ?>