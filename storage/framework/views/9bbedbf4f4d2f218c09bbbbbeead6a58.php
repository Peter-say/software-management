<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.store-items.index')); ?>">Store
                            Items</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Store Issue</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('dashboard.hotel.store-issues.store')); ?>" enctype="multipart/form-data"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row justify-content-center">
                                <!-- Item Category -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="store_item_category_id" class="text-label form-label">Item
                                            Category*</label>
                                        <select id="store_item_category_id" name="item_category_id"
                                            class="form-control <?php $__errorArgs = ['item_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="">Select Category</option>
                                            <?php $__currentLoopData = getModelItems('item-categories'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"
                                                    <?php echo e(old('item_category_id', $store_issue_item->item_category_id ?? '') == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['item_category_id'];
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
                                <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="outlet_id" class="text-label form-label">Choose Outlet*</label>
                                        <select id="outlet_id" name="outlet_id"
                                            class="form-control <?php $__errorArgs = ['outlet_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="">Select Outlet</option>
                                            <?php $__currentLoopData = getModelItems('outlets'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($outlet->id); ?>"
                                                    <?php echo e(old('outlet_id', $store_issue_item->outlet_id ?? '') == $outlet->id ? 'selected' : ''); ?>>
                                                    <?php echo e($outlet->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['outlet_id'];
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

                            <!-- Table Section -->
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table card-table display mb-4 shadow-hover table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Numbers to give out</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <div class="form-group" id="receipiant-field">
                                        <div class="d-flex justify-content-between">
                                            <label for="recipient_id" class="text-label form-label">Recipient*
                                            </label>
                                            <span>
                                                <a href="#" class="text-primary" id="choose-receipiant-name">Enter
                                                    name instead</a>
                                            </span>
                                        </div>
                                        <select id="recipient_id" name="recipient_id"
                                            class="form-control <?php $__errorArgs = ['recipient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">Select or Enter Recipient</option>
                                            <?php $__currentLoopData = $recipients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($recipient->id); ?>"
                                                    <?php echo e(old('recipient_id') == $recipient->id ? 'selected' : ''); ?>>
                                                    <?php echo e($recipient->user->name); ?>

                                                </option>
                                                <input type="hidden" name="recipient_name" value="<?php echo e($recipient->user->name); ?>">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <?php $__errorArgs = ['recipient_id'];
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
                                    <div class="form-group" id="extenal_recipient-field">
                                        <div class="d-flex justify-content-between">
                                            <label for="extenal_recipient_name" class="text-label form-label">Recipient*
                                            </label>
                                            <span>
                                                <a href="#" class="text-primary" id="select-receipiant">Select
                                                    Receipiant</a>
                                            </span>
                                        </div>
                                        <input type="text"
                                            class="form-control <?php $__errorArgs = ['extenal_recipient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="extenal_recipient_name" value="<?php echo e(old('extenal_recipient_name')); ?>"
                                            id="">
                                        <?php $__errorArgs = ['extenal_recipient_name'];
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
                                <div class="col-xl-8 col-lg-8 col-md-4 col-sm-12 mb-3">

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="note" class="text-label form-label">Note
                                            </label>
                                        </div>
                                        <input type="text" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="note" value="<?php echo e(old('note')); ?>" id="">
                                        <?php $__errorArgs = ['note'];
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

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for AJAX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#store_item_category_id').on('change', function() {
                var selectedCategoryId = $(this).val();
                var tableBody = $('table tbody');

                tableBody.empty(); // Clear the table before populating new data

                if (selectedCategoryId) {
                    $.ajax({
                        url: '<?php echo e(route('dashboard.hotel.fetch-store-items')); ?>',
                        type: 'GET',
                        data: {
                            category_id: selectedCategoryId
                        },
                        success: function(response) {
                            if (response.items.length > 0) {
                                $.each(response.items, function(index, item) {
                                    tableBody.append(`
                                        <tr>
                                            <td>${item.code}</td>
                                            <td>${item.name}</td>
                                            <td>${item.unit_measurement}</td>
                                            <td>${item.qty}</td>
                                            <td>
                                                <input type="number" name="items[${item.id}][qty]" 
                                                       class="form-control item-quantity"
                                                       min="0" max="${item.qty}" 
                                                       data-available="${item.qty}" 
                                                       placeholder="Enter quantity" value="">
                                            </td>
                                        </tr>
                                         <input type="hidden" name="items[${item.id}][store_item_id]" 
                                                       class="form-control store_item"
                                                       value="${item.id}">
                                    `);
                                });
                            } else {
                                tableBody.append(
                                    '<tr><td colspan="5">No items found</td></tr>');
                            }
                        },
                        error: function() {
                            Toastify({
                                text: 'Something went wrong',
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();

                        }
                    });
                } else {
                    // tableBody.append('<tr><td colspan="5">Select a category</td></tr>');
                }
            });

            // Trigger change event to populate items on page load if category is pre-selected
            $('#store_item_category_id').trigger('change');

            // Validate input quantity
            $(document).on('input', '.item-quantity', function() {
                var availableQty = $(this).data('available');
                var enteredQty = $(this).val();

                if (enteredQty > availableQty) {
                    Toastify({
                        text: `You cannot give out more than ${availableQty} items.`,
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                    }).showToast();
                    // alert(`You cannot give out more than ${availableQty} items.`);
                    $(this).val(availableQty);
                }
            });
            $(document).ready(function() {
                $('#extenal_recipient-field').hide();
                $('#choose-receipiant-name').click(function(event) {
                    event.preventDefault();
                    $('#receipiant-field').hide().find('select').prop('disabled', true);
                    $('#extenal_recipient-field').show().find('input').prop('disabled', false);
                });

                $('#select-receipiant').click(function(event) {
                    event.preventDefault();
                    $('#extenal_recipient-field').hide().find('input').prop('disabled', true);
                    $('#receipiant-field').show().find('select').prop('disabled', false);
                });

            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\store-item-issue\create.blade.php ENDPATH**/ ?>