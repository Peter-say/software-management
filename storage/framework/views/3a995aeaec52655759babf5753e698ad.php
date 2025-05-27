<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.expenses-dashbaord')); ?>">Expense</a>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.expenses.index')); ?>">List</a>
                    <li class="breadcrumb-item "><a href="<?php echo e(route('dashboard.hotel.expenses.index')); ?>">View</a>

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
                                <h5>Expense Details</h5>
                                <div class="row">

                                    <!-- Name Field -->
                                    <div class="col-xl-3 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Category*</label>
                                            <select id="category" name="category_id"
                                                class="form-control <?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled>
                                                <option value="">Select Country</option>
                                                <?php $__currentLoopData = getModelItems('expense-categories'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($category->id); ?>"
                                                        <?php echo e(old('category_id', $expense->category_id ?? '') == $category->id ? 'selected' : ''); ?>>
                                                        <?php echo e($category->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['country_id'];
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
                                            <label for="expense_date" class="text-label form-label">
                                                Date*</label>
                                            <input type="date" id="expense-date" name="expense_date"
                                                class="form-control  <?php $__errorArgs = ['expense_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('expense_date', isset($expense) && $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '')); ?>"
                                                required disabled>

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
                                            <label for="supplier_id" class="form-label">Supplier
                                            </label>
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
                                                        <?php echo e(old('supplier_id', $expense->supplier_id ?? '') == $supplier->id ? 'selected' : ''); ?>>
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
                                                    <?php if(isset($expense->uploaded_file)): ?>
                                                        <iframe src="<?php echo e(getStorageUrl('hotel/expense/files/' . $expense->uploaded_file)); ?>"
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
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea type="text" id="note" name="note" cols="2" rows="2"
                                                class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled><?php echo e(old('note', isset($expense) && $expense->note)); ?></textarea>
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
                                <?php if(isset($expense) && $expense->items->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $expense->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $expenseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div id="input-template" class="row">
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="expense_date"
                                                        class="text-label form-label">Item/Description</label>
                                                    <input type="text" id="description_<?php echo e($key); ?>"
                                                        name="description[]"
                                                        class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        value="<?php echo e(old('description.' . $key, $expenseItem->expenseItem->name ?? '')); ?>"
                                                        list="items" disabled>
                                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    <datalist id="items">
                                                        <?php $__currentLoopData = getModelItems('expense-items'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($item->name); ?>">
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="expense_date"
                                                        class="text-label form-label">Quantity</label>
                                                    <input id="qty_<?php echo e($key); ?>" name="qty[]" type="number"
                                                        onkeyup="updateAmount(<?php echo e($key); ?>)" inputmode="decimal"
                                                        min="0" step="any"
                                                        class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Qty"
                                                        value="<?php echo e(old('qty.' . $key, $expenseItem->qty)); ?>" disabled>
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
                                                    <label for="expense_date" class="text-label form-label">Rate</label>
                                                    <input type="number" id="rate_<?php echo e($key); ?>" name="rate[]"
                                                        onkeyup="updateAmount(<?php echo e($key); ?>)" inputmode="decimal"
                                                        min="0" step="any"
                                                        class="form-control <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Rate"
                                                        value="<?php echo e(old('rate.' . $key, $expenseItem->rate)); ?>" disabled>
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
                                                    <label for="expense_date" class="text-label form-label">Amount</label>
                                                    <input type="number" id="amount_<?php echo e($key); ?>"
                                                        name="amount[]"
                                                        class="form-control money <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Amount"
                                                        value="<?php echo e(old('amount.' . $key, $expenseItem->amount)); ?>"
                                                        disabled>
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
                                                    <label for="expense_date" class="text-label form-label">Unit
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
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Unit Qty"
                                                        value="<?php echo e(old('unit_qty.' . $key, $expenseItem->unit_qty)); ?>"
                                                        disabled>
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
                                        <?php if($expense->paymentStatus() === 'pending'): ?>
                                            <div class="alert alert-danger mt-3" role="alert">
                                                <h6 class="mb-0">No payments have been made for this expense.</h6>
                                            </div>
                                        <?php elseif($expense->paymentStatus() === 'partial'): ?>
                                            <div class="alert alert-warning mt-3" role="alert">
                                                <h6 class="mb-0">Partial payment made. Remaining <?php echo e(number_format($expense->amount - $expense->payments->sum('amount'))); ?></h6>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-success mt-3" role="alert">
                                                <h6 class="mb-0">Items already paid for</h6>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if($expense->payments()->count() > 0): ?>
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
                                                    <?php $__currentLoopData = $expense->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($payment->created_at->format('jS, M Y')); ?></td>
                                                            <td><?php echo e(number_format($payment->amount)); ?></td>
                                                            <td><?php echo e($payment->payment_method); ?></td>
                                                            <td><?php echo e($payment->note ?? 'N/A'); ?></td>
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
                                    <?php if($expense->amount > $expense->payments()->sum('amount') || $expense->payments() === null): ?>
                                        
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#payment-modal-<?php echo e($expense->id); ?>"
                                            class="btn btn-primary shadow btn-xl sharp me-2">
                                            Make payment
                                        </button>
                                    <?php endif; ?>
        
                            </div>
                        </div>
                        <?php echo $__env->make('dashboard.general.payment.modal', [
                            'payableType' => $payableType,
                            'payableModel' => $expense,
                            'currencies' => $currencies,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/expenses/show.blade.php ENDPATH**/ ?>