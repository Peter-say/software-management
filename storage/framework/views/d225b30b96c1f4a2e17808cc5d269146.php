<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.purchases-dashbaord')); ?>">Expense</a>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.purchases.index')); ?>">List</a>
                    <li class="breadcrumb-item "><a href="<?php echo e(route('dashboard.hotel.purchases.index')); ?>">View</a>

                    </li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card" disabled>
                    <div class="card-header">
                        
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- expense Details -->
                            <div class="col-lg-12">
                                <h5>Purchase Details</h5>
                                <div class="row">

                                    <!-- Name Field -->
                                    <div class="col-xl-3 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Item Category*</label>
                                            <select id="category" name="item_category_id"
                                                class="form-control <?php $__errorArgs = ['item_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled>
                                                <option value="">Select Category</option>
                                                <?php $__currentLoopData = getModelItems('item-categories'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($category->id); ?>"
                                                        <?php echo e(old('item_category_id', $purchase->item_category_id ?? '') == $category->id ? 'selected' : ''); ?>>
                                                        <?php echo e($category->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['item_category_id'];
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
                                    <!-- Date Field -->
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Date*</label>
                                            <input type="date" id="purchase-date" name="purchase_date"
                                                class="form-control  <?php $__errorArgs = ['purchases_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('purchase_date', isset($purchase) && $purchase->purchase_date ? $purchase->purchase_date->format('Y-m-d') : '')); ?>"
                                                required>

                                            <?php $__errorArgs = ['exapense_date'];
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

                                    <!-- Supplier Field -->
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="supplier_id" class="form-label">Supplier</label>
                                            <select id="supplier_id" name="supplier_id"
                                                class="form-control <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled>
                                                <option value="">Select Supplier</option>
                                                <?php $__currentLoopData = getModelItems('suppliers'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($supplier->id); ?>"
                                                        <?php echo e(old('supplier_id', $purchase->supplier_id ?? '') == $supplier->id ? 'selected' : ''); ?>>
                                                        <?php echo e($supplier->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['supplier_id'];
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
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status" name="status"
                                                class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled>
                                                <option value="">Select Status</option>
                                                <?php $__currentLoopData = ['pending', 'partial', 'ordered']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($status); ?>"
                                                        <?php echo e(old('status', $purchase->status ?? '') == $status ? 'selected' : ''); ?>>
                                                        <?php echo e(ucfirst($status)); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['status'];
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
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="expense_date" class="text-label form-label">
                                                Uploaded File</label>
                                            <div>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#fileModal">
                                                    View File
                                                </button>
                                            </div>

                                            <?php $__errorArgs = ['exapense_date'];
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
                                    <!-- Modal -->
                                    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="fileModalLabel">Uploaded File</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php if(isset($purchase->file_path)): ?>
                                                        <iframe src="<?php echo e(getStorageUrl('hotel/purchase/files/' . $purchase->file_path)); ?>"
                                                            width="100%" height="500px"></iframe>
                                                    <?php else: ?>
                                                        <p>No file uploaded.</p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- note Field -->
                                    <div class="col-xl-9 col-md-9  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="note" class="form-label">Note</label>
                                            <input type="text" id="note" name="note"
                                                class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled
                                                value="<?php echo e(old('note', isset($purchase) ? $purchase->note : '')); ?>">
                                            <?php $__errorArgs = ['note'];
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

                        <div class="row no-gutters">
                            <div id="input-container" class="col-lg card-form__body card-body">
                                <?php if(isset($purchase) && $purchase->items->isNotEmpty()): ?>
                                <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $purchaseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div id="input-template" class="row align-items-center">
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="store_item_id_0"
                                                class="text-label form-label">Item/Description</label>
                                            <select id="store_item_id_0" name="store_item_id[]"
                                                class="form-control <?php $__errorArgs = ['store_item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled>
                                                <option value="" disabled selected>Select an item</option>
                                                <?php $__currentLoopData = getModelItems('store-items'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>"
                                                        <?php echo e(old('store_item_id.' . $key, $purchaseItem->pivot->store_item_id) == $item->id ? 'selected' : ''); ?>>
                                                        <?php echo e($item->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['store_item_id'];
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
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date"
                                                class="text-label form-label">Quantity</label>
                                            <input id="qty_<?php echo e($key); ?>" name="qty[]"
                                                type="number" onkeyup="updateAmount(<?php echo e($key); ?>)"
                                                inputmode="decimal" min="0" step="any"
                                                class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  disabled
                                                placeholder="Qty"
                                                value="<?php echo e(old('qty.' . $key, $purchaseItem->pivot->qty)); ?>">
                                            <?php $__errorArgs = ['qty'];
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
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date"
                                                class="text-label form-label">Rate</label>
                                            <input type="number" id="rate_<?php echo e($key); ?>"
                                                name="rate[]" onkeyup="updateAmount(<?php echo e($key); ?>)"
                                                inputmode="decimal" min="0" step="any"
                                                class="form-control <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  disabled
                                                placeholder="Rate"
                                                value="<?php echo e(old('rate.' . $key, $purchaseItem->pivot->rate)); ?>">
                                            <?php $__errorArgs = ['rate'];
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
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="received_<?php echo e($key); ?>"
                                                class="text-label form-label">Received</label>
                                            <input type="number" id="received_<?php echo e($key); ?>"
                                                name="received[]" inputmode="decimal" min="0"
                                                step="any"
                                                class="form-control <?php $__errorArgs = ['received'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  disabled
                                                placeholder="Received"
                                                value="<?php echo e(old('received.' . $key, $purchaseItem->pivot->received)); ?>">
                                            <?php $__errorArgs = ['received'];
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
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date"
                                                class="text-label form-label">Amount</label>
                                            <input type="number" id="amount_<?php echo e($key); ?>"
                                                name="amount[]"
                                                class="form-control money <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  disabled
                                                placeholder="Amount"
                                                value="<?php echo e(old('amount.' . $key, $purchaseItem->pivot->amount)); ?>">
                                            <?php $__errorArgs = ['amount'];
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
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">Unit
                                                Quantity</label>
                                            <input type="number" id="unitQty_<?php echo e($key); ?>"
                                                name="unit_qty[]" inputmode="decimal" min="0"
                                                step="any"
                                                class="form-control money <?php $__errorArgs = ['unit_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  disabled
                                                placeholder="Unit Qty"
                                                value="<?php echo e(old('unit_qty.' . $key, $purchaseItem->pivot->unit_qty)); ?>">
                                            <?php $__errorArgs = ['unit_qty'];
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="d-flex justify-content-center">
                                        <h4>No Data</h4>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Payments Made</h4>
                                    <div class="d-flex justify-content-end">
                                        <?php if($purchase->paymentStatus() === 'pending'): ?>
                                            <div class="alert alert-danger mt-3" role="alert">
                                                <h6 class="mb-0">No payments have been made for this purchase.</h6>
                                            </div>
                                        <?php elseif($purchase->paymentStatus() === 'partial'): ?>
                                            <div class="alert alert-warning mt-3" role="alert">
                                                <h6 class="mb-0">Partial payment made. Remaining <?php echo e(number_format($purchase->amount - $purchase->payments->sum('amount'))); ?></h6>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-success mt-3" role="alert">
                                                <h6 class="mb-0">Items already paid for</h6>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if($purchase->payments()->count() > 0): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                        <th>Payment Method</th>
                                                        <th>Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $purchase->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($payment->created_at->format('jS, M Y')); ?></td>
                                                            <td><?php echo e(number_format($payment->amount)); ?></td>
                                                            <td><?php echo e($payment->payment_method); ?></td>
                                                            <td><?php echo e($payment->description ?? 'N/A'); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning" role="alert">
                                            No payments made for this expense.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <?php if($purchase->amount > $purchase->payments()->sum('amount') || $purchase->payments() === null): ?>
                                        
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#payment-modal-<?php echo e($purchase->id); ?>"
                                            class="btn btn-primary shadow btn-xl sharp me-2">
                                            Make payment
                                        </button>
                                    <?php endif; ?>
        
                            </div>
                        </div>
                        <?php echo $__env->make('dashboard.general.payment.modal', [
                            'payableType' => $payableType,
                            'payableModel' => $purchase,
                            'currencies' => $currencies,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\purchases\show.blade.php ENDPATH**/ ?>