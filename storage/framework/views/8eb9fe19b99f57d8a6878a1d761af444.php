<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.hotel.requisitions.index')); ?>">Requisitions</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Create Requisition</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Requisition</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('dashboard.hotel.requisitions.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php if(isset($requisition)): ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="requisition_id" value="<?php echo e($requisition->id); ?>">
                            <?php endif; ?>
                           <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="purpose" class="text-label form-label">Purpose</label>
                                    <input type="text" id="purpose" name="purpose"
                                        class="form-control <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('purpose')); ?>" required>
                                    <?php $__errorArgs = ['purpose'];
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
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="department" class="form-label">Select Department</label>
                                    <select name="department" id="department"
                                        class="form-control <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">-- Select a Department --</option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($department); ?>"
                                                <?php echo e(old('department') == $department? 'selected' : ''); ?>>
                                                <?php echo e($department); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['department'];
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


                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3">Requisition Items</h5>
                                    <table class="table table-bordered" id="requisition-items-table">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" name="items[0][item_name]" class="form-control"
                                                        required>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[0][quantity]" class="form-control"
                                                        min="1" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="items[0][unit]" class="form-control">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger remove-item-btn">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" id="add-item-btn">Add Item</button>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Submit Requisition</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 1;

            // Add item row
            document.getElementById('add-item-btn').addEventListener('click', function() {
                const tableBody = document.querySelector('#requisition-items-table tbody');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <input type="text" name="items[${itemIndex}][item_name]" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" name="items[${itemIndex}][quantity]" class="form-control" min="1" required>
                    </td>
                    <td>
                        <input type="text" name="items[${itemIndex}][unit]" class="form-control">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-item-btn">Remove</button>
                    </td>
                `;
                tableBody.appendChild(newRow);
                itemIndex++;
            });

            // Remove item row
            document.querySelector('#requisition-items-table').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item-btn')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\requisition\create.blade.php ENDPATH**/ ?>